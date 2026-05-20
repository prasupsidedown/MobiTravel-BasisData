const db = require('../config/database');
const bcrypt = require('bcryptjs');
const { generateToken } = require('../middleware/auth');

// Login admin
async function login(req, res) {
    const { username, password } = req.body;
    
    console.log('Login attempt:', username);
    
    try {
        const admin = await db.getOne(
            `SELECT id, username, password, role FROM admin_users WHERE username = :username`,
            { username }
        );
        
        if (!admin) {
            console.log('Admin not found:', username);
            return res.status(401).json({ error: 'Username atau password salah' });
        }
        
        const isValid = await bcrypt.compare(password, admin.PASSWORD);
        
        if (!isValid) {
            console.log('Invalid password for:', username);
            return res.status(401).json({ error: 'Username atau password salah' });
        }
        
        const token = generateToken(admin);
        
        // Log aktivitas login
        await db.execute(`
            INSERT INTO activity_logs (admin_id, role, method, endpoint, action, status, ip_address, user_agent)
            VALUES (:admin_id, :role, 'POST', '/api/admin/login', 'login', 200, :ip, :ua)
        `, {
            admin_id: admin.ID,
            role: admin.ROLE,
            ip: req.ip || req.socket.remoteAddress,
            ua: req.headers['user-agent'] || '-'
        }).catch(err => console.log('Log error:', err.message));
        
        res.json({ token, admin: { id: admin.ID, username: admin.USERNAME, role: admin.ROLE } });
        
    } catch (err) {
        console.error('Login error:', err);
        res.status(500).json({ error: 'Terjadi kesalahan server: ' + err.message });
    }
}

// Get all users
async function getUsers(req, res) {
    try {
        const users = await db.query(`
            SELECT id, nama, email, hp, kota, created_at 
            FROM users 
            ORDER BY created_at DESC
        `);
        res.json(users);
    } catch (err) {
        console.error('Get users error:', err);
        res.status(500).json({ error: 'Gagal memuat data user' });
    }
}

// Delete user
async function deleteUser(req, res) {
    const { id } = req.params;
    
    try {
        await db.execute(`DELETE FROM users WHERE id = :id`, { id });
        res.json({ success: true });
    } catch (err) {
        console.error('Delete user error:', err);
        res.status(500).json({ error: 'Gagal menghapus user' });
    }
}

// Get all agents
async function getAgents(req, res) {
    try {
        const agents = await db.query(`
            SELECT id, nama, nama_agen, email, status, created_at 
            FROM agents 
            ORDER BY created_at DESC
        `);
        res.json(agents);
    } catch (err) {
        console.error('Get agents error:', err);
        res.status(500).json({ error: 'Gagal memuat data agen' });
    }
}

// Delete agent
async function deleteAgent(req, res) {
    const { id } = req.params;
    
    try {
        await db.execute(`DELETE FROM agents WHERE id = :id`, { id });
        res.json({ success: true });
    } catch (err) {
        console.error('Delete agent error:', err);
        res.status(500).json({ error: 'Gagal menghapus agen' });
    }
}

// Get all trips
async function getTrips(req, res) {
    try {
        const trips = await db.query(`
            SELECT id, judul, deskripsi, harga, agen_id, created_at 
            FROM trips 
            ORDER BY created_at DESC
        `);
        res.json(trips);
    } catch (err) {
        console.error('Get trips error:', err);
        res.status(500).json({ error: 'Gagal memuat data trip' });
    }
}

// Delete trip
async function deleteTrip(req, res) {
    const { id } = req.params;
    
    try {
        await db.execute(`DELETE FROM trips WHERE id = :id`, { id });
        res.json({ success: true });
    } catch (err) {
        console.error('Delete trip error:', err);
        res.status(500).json({ error: 'Gagal menghapus trip' });
    }
}

// Get all logs
async function getLogs(req, res) {
    try {
        const logs = await db.query(`
            SELECT * FROM activity_logs 
            ORDER BY created_at DESC 
            FETCH FIRST 100 ROWS ONLY
        `);
        
        const countResult = await db.query(`SELECT COUNT(*) as total FROM activity_logs`);
        const total = countResult[0]?.TOTAL || 0;
        
        res.json({ logs, total });
    } catch (err) {
        console.error('Get logs error:', err);
        res.status(500).json({ error: 'Gagal memuat log' });
    }
}

module.exports = {
    login,
    getUsers,
    deleteUser,
    getAgents,
    deleteAgent,
    getTrips,
    deleteTrip,
    getLogs
};