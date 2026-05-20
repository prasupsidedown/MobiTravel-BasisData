const db = require('../config/database');

class ActivityLog {
    static async create(data) {
        const sql = `
            INSERT INTO admin_logs (admin_id, action, target_type, target_id, ip_address, user_agent)
            VALUES (:admin_id, :action, :target_type, :target_id, :ip_address, :user_agent)
        `;
        return await db.execute(sql, data);
    }
    
    static async getLogs(adminId = null, limit = 100) {
        let sql = `
            SELECT l.*, a.nama as admin_name
            FROM admin_logs l
            LEFT JOIN admin_users a ON l.admin_id = a.id
            ORDER BY l.created_at DESC
        `;
        if (adminId) {
            sql = `
                SELECT l.*, a.nama as admin_name
                FROM admin_logs l
                LEFT JOIN admin_users a ON l.admin_id = a.id
                WHERE l.admin_id = :adminId
                ORDER BY l.created_at DESC
            `;
            return await db.query(sql, { adminId });
        }
        return await db.query(sql);
    }
}

module.exports = ActivityLog;