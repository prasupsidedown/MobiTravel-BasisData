const express = require('express');
const router = express.Router();
const { loginAdmin, logoutAdmin } = require('../middleware/adminAuth');
const { logActivity } = require('../middleware/activityLogger');

// Halaman login
router.get('/login', (req, res) => {
    if (req.session.admin) {
        return res.redirect('/admin/dashboard');
    }
    res.render('login', { title: 'Login Admin', error: null });
});

// Proses login
router.post('/login', async (req, res) => {
    const { email, password } = req.body;
    
    const result = await loginAdmin(email, password, req);
    
    if (!result.success) {
        return res.render('login', { title: 'Login Admin', error: result.message });
    }
    
    await logActivity(result.admin.ID, 'login', null, null, req);
    
    res.redirect('/admin/dashboard');
});

// Logout
router.get('/logout', async (req, res) => {
    if (req.session.admin) {
        await logActivity(req.session.admin.id, 'logout', null, null, req);
    }
    req.session.destroy();
    res.redirect('/login');
});

// Halaman utama redirect
router.get('/', (req, res) => {
    if (req.session.admin) {
        return res.redirect('/admin/dashboard');
    }
    res.redirect('/login');
});

module.exports = router;