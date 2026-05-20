const db = require('../config/database');
const bcrypt = require('bcryptjs');

// Middleware untuk cek apakah admin sudah login
function isAuthenticated(req, res, next) {
    if (req.session && req.session.admin) {
        return next();
    }
    
    // Jika request API, kirim JSON
    if (req.path.startsWith('/api/')) {
        return res.status(401).json({ error: 'Unauthorized' });
    }
    
    // Redirect ke login untuk halaman web
    res.redirect('/login');
}

// Middleware untuk cek role superadmin
function isSuperAdmin(req, res, next) {
    if (req.session && req.session.admin && req.session.admin.role === 'superadmin') {
        return next();
    }
    
    if (req.path.startsWith('/api/')) {
        return res.status(403).json({ error: 'Forbidden' });
    }
    
    res.status(403).render('error', {
        title: '403 - Access Denied',
        message: 'Anda tidak memiliki akses ke halaman ini.'
    });
}

// Fungsi login
async function loginAdmin(email, password, req) {
    const admin = await db.getOne(
        `SELECT id, email, password, nama, role, status 
         FROM admin_users 
         WHERE email = :email AND status = 'active'`,
        { email }
    );
    
    if (!admin) {
        return { success: false, message: 'Email tidak ditemukan' };
    }
    
    const isValid = await bcrypt.compare(password, admin.PASSWORD);
    
    if (!isValid) {
        return { success: false, message: 'Password salah' };
    }
    
    // Set session
    req.session.admin = {
        id: admin.ID,
        email: admin.EMAIL,
        nama: admin.NAMA,
        role: admin.ROLE
    };
    
    return { success: true, admin };
}

// Fungsi logout
function logoutAdmin(req) {
    req.session.destroy();
}

module.exports = {
    isAuthenticated,
    isSuperAdmin,
    loginAdmin,
    logoutAdmin
};