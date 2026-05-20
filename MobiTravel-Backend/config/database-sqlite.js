const sqlite3 = require("sqlite3").verbose();
const path = require("path");

const dbPath = path.join(__dirname, "..", "database.sqlite");

// Buat/buka database SQLite
const db = new sqlite3.Database(dbPath, (err) => {
  if (err) {
    console.error("Error membuka SQLite database:", err.message);
  } else {
    console.log("✅ SQLite Database connected:", dbPath);
    initTables();
  }
});

async function initTables() {
  // Buat tabel agents
  db.run(
    `
    CREATE TABLE IF NOT EXISTS agents (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      nama TEXT NOT NULL,
      nama_agen TEXT NOT NULL,
      email TEXT UNIQUE NOT NULL,
      password TEXT NOT NULL,
      no_hp TEXT,
      alamat TEXT,
      kota TEXT,
      provinsi TEXT,
      jenis_usaha TEXT,
      status TEXT DEFAULT 'pending',
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
  `,
    (err) => {
      if (err) {
        console.error("Error creating agents table:", err.message);
      } else {
        console.log("📋 Table agents ready");
      }
    },
  );
}

// Query wrapper - returns promise
function query(sql, params = []) {
  return new Promise((resolve, reject) => {
    db.all(sql, params, (err, rows) => {
      if (err) {
        reject(err);
      } else {
        resolve(rows || []);
      }
    });
  });
}

// Execute wrapper - returns promise
function execute(sql, params = {}) {
  return new Promise((resolve, reject) => {
    // Convert object params to array for sqlite3
    const keys = Object.keys(params);
    const values = keys.map((k) => params[k]);

    db.run(sql, values, function (err) {
      if (err) {
        reject(err);
      } else {
        resolve({ lastID: this.lastID, changes: this.changes });
      }
    });
  });
}

module.exports = {
  query,
  execute,
  db,
};
