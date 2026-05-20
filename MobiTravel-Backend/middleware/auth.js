const jwt = require('jsonwebtoken');

const JWT_SECRET = process.env.JWT_SECRET || 'mobitravel_rahasia_2024';

function verifyToken(req, res, next) {
    const authHeader = req.headers['authorization'];
    const token = authHeader && authHeader.split(' ')[1];
    
    if (!token) {
        return res.status(401).json({ error: 'Token tidak ditemukan' });
    }
    
    try {
        const decoded = jwt.verify(token, JWT_SECRET);
        req.admin = decoded;
        next();
    } catch (err) {
        return res.status(403).json({ error: 'Token tidak valid' });
    }
}

function generateToken(admin) {
    return jwt.sign(
        { id: admin.ID, username: admin.USERNAME, role: admin.ROLE },
        JWT_SECRET,
        { expiresIn: '24h' }
    );
}

module.exports = { verifyToken, generateToken };