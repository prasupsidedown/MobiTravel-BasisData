const db = require('../config/database');

async function logActivity(adminId, action, targetType = null, targetId = null, req = null) {
    const data = {
        admin_id: adminId,
        action: action,
        target_type: targetType,
        target_id: targetId,
        ip_address: req ? req.ip : null,
        user_agent: req ? req.headers['user-agent'] : null
    };
    
    try {
        await db.execute(`
            INSERT INTO admin_logs (admin_id, action, target_type, target_id, ip_address, user_agent)
            VALUES (:admin_id, :action, :target_type, :target_id, :ip_address, :user_agent)
        `, data);
    } catch (err) {
        console.error('Failed to log activity:', err);
    }
}

module.exports = { logActivity };