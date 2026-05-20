const express = require('express');
const router = express.Router();
const { verifyToken } = require('../middleware/auth');
const adminController = require('../controllers/adminController');

// Public route (login)
router.post('/login', adminController.login);

// Protected routes (semua di bawah ini butuh token)
router.use(verifyToken);

router.get('/users', adminController.getUsers);
router.delete('/users/:id', adminController.deleteUser);

router.get('/agents', adminController.getAgents);
router.delete('/agents/:id', adminController.deleteAgent);

router.get('/trips', adminController.getTrips);
router.delete('/trips/:id', adminController.deleteTrip);

router.get('/logs', adminController.getLogs);

// ============ ENDPOINT UNTUK AGEN (LARAVEL) ============

// Login agen
router.post('/agen/login', async (req, res) => {
    const { email, password } = req.body;
    
    try {
        const agent = await db.getOne(
            `SELECT id, nama, nama_agen, email, password, status FROM agents WHERE email = :email`,
            { email }
        );
        
        if (!agent) {
            return res.status(401).json({ error: 'Email tidak ditemukan' });
        }
        
        if (agent.STATUS === 'banned') {
            return res.status(401).json({ error: 'Akun Anda telah diblokir' });
        }
        
        const bcrypt = require('bcryptjs');
        const isValid = await bcrypt.compare(password, agent.PASSWORD);
        
        if (!isValid) {
            return res.status(401).json({ error: 'Password salah' });
        }
        
        const jwt = require('jsonwebtoken');
        const token = jwt.sign(
            { id: agent.ID, email: agent.EMAIL, role: 'agent' },
            process.env.JWT_SECRET,
            { expiresIn: '24h' }
        );
        
        res.json({
            token,
            agent: {
                id: agent.ID,
                nama: agent.NAMA,
                nama_agen: agent.NAMA_AGEN,
                email: agent.EMAIL
            }
        });
        
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
});

// Middleware untuk agen
function verifyAgentToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];
    
    if (!token) {
        return res.status(401).json({ error: 'Token required' });
    }
    
    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET);
        if (decoded.role !== 'agent') {
            return res.status(403).json({ error: 'Agen only' });
        }
        req.agent = decoded;
        next();
    } catch (err) {
        res.status(403).json({ error: 'Invalid token' });
    }
}

// CRUD Wisata untuk Agen
router.get('/agen/wisata', verifyAgentToken, async (req, res) => {
    const wisata = await db.query(
        `SELECT * FROM wisata WHERE agen_id = :agen_id AND status = 'active' ORDER BY created_at DESC`,
        { agen_id: req.agent.id }
    );
    res.json(wisata);
});

// TEST endpoint - langsung query tanpa token
router.get('/test-agents', async (req, res) => {
    try {
        const agents = await db.query('SELECT * FROM agents');
        res.json({ success: true, count: agents.length, data: agents });
    } catch (err) {
        console.error('Test agents error:', err);
        res.status(500).json({ success: false, error: err.message });
    }
});

router.post('/agen/wisata', verifyAgentToken, async (req, res) => {
    const { judul, lokasi, deskripsi, harga, kategori } = req.body;
    
    const result = await db.execute(`
        INSERT INTO wisata (agen_id, judul, lokasi, deskripsi, harga, kategori, status, created_at)
        VALUES (:agen_id, :judul, :lokasi, :deskripsi, :harga, :kategori, 'active', SYSDATE)
        RETURNING id INTO :id
    `, {
        agen_id: req.agent.id,
        judul, lokasi, deskripsi, harga, kategori,
        id: { dir: oracledb.BIND_OUT, type: oracledb.NUMBER }
    });
    
    res.json({ success: true, id: result.outBinds.id });
});

router.put('/agen/wisata/:id', verifyAgentToken, async (req, res) => {
    const { judul, lokasi, deskripsi, harga } = req.body;
    
    await db.execute(`
        UPDATE wisata SET judul = :judul, lokasi = :lokasi, deskripsi = :deskripsi, harga = :harga
        WHERE id = :id AND agen_id = :agen_id
    `, { judul, lokasi, deskripsi, harga, id: req.params.id, agen_id: req.agent.id });
    
    res.json({ success: true });
});

router.delete('/agen/wisata/:id', verifyAgentToken, async (req, res) => {
    await db.execute(
        `UPDATE wisata SET status = 'deleted' WHERE id = :id AND agen_id = :agen_id`,
        { id: req.params.id, agen_id: req.agent.id }
    );
    res.json({ success: true });
});

// CRUD Trips untuk Agen
router.get('/agen/trips', verifyAgentToken, async (req, res) => {
    const trips = await db.query(
        `SELECT * FROM trips WHERE agen_id = :agen_id ORDER BY created_at DESC`,
        { agen_id: req.agent.id }
    );
    res.json(trips);
});

router.post('/agen/trips', verifyAgentToken, async (req, res) => {
    const { judul, deskripsi, harga } = req.body;
    
    const result = await db.execute(`
        INSERT INTO trips (agen_id, judul, deskripsi, harga, created_at)
        VALUES (:agen_id, :judul, :deskripsi, :harga, SYSDATE)
        RETURNING id INTO :id
    `, {
        agen_id: req.agent.id,
        judul, deskripsi, harga,
        id: { dir: oracledb.BIND_OUT, type: oracledb.NUMBER }
    });
    
    res.json({ success: true, id: result.outBinds.id });
});

router.delete('/agen/trips/:id', verifyAgentToken, async (req, res) => {
    await db.execute(
        `DELETE FROM trips WHERE id = :id AND agen_id = :agen_id`,
        { id: req.params.id, agen_id: req.agent.id }
    );
    res.json({ success: true });
});

// Booking untuk Agen
router.get('/agen/bookings', verifyAgentToken, async (req, res) => {
    const bookings = await db.query(`
        SELECT b.*, u.nama as user_name, u.email as user_email,
               COALESCE(w.judul, t.judul) as item_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        LEFT JOIN wisata w ON b.wisata_id = w.id AND w.agen_id = :agen_id
        LEFT JOIN trips t ON b.trip_id = t.id AND t.agen_id = :agen_id
        WHERE w.agen_id = :agen_id OR t.agen_id = :agen_id
        ORDER BY b.created_at DESC
    `, { agen_id: req.agent.id });
    
    res.json(bookings);
});

// Public endpoints untuk website
router.get('/public/agents', async (req, res) => {
    const agents = await db.query(`SELECT id, nama, nama_agen, email FROM agents WHERE status = 'active'`);
    res.json(agents);
});

router.get('/public/wisata', async (req, res) => {
    const wisata = await db.query(`SELECT w.*, a.nama_agen FROM wisata w JOIN agents a ON w.agen_id = a.id WHERE w.status = 'active'`);
    res.json(wisata);
});

router.get('/public/trips', async (req, res) => {
    const trips = await db.query(`SELECT t.*, a.nama_agen FROM trips t JOIN agents a ON t.agen_id = a.id`);
    res.json(trips);
});

router.get('/public/reviews', async (req, res) => {
    const reviews = await db.query(`SELECT * FROM reviews ORDER BY created_at DESC`);
    res.json(reviews);
});

module.exports = router;