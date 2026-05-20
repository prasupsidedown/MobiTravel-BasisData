const express = require("express");
const cors = require("cors");
const dotenv = require("dotenv");
const path = require("path");
const db = require("./config/database");

dotenv.config();

const app = express();
const PORT = process.env.PORT || 5000;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Serve static files
app.use(express.static(path.join(__dirname)));

// Routes
const adminRoutes = require("./routes/adminRoutes");
const agentRoutes = require("./routes/agentRoutes");
app.use("/api/admin", adminRoutes);
app.use("/api", agentRoutes);

// Default route
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "admin-panel.html"));
});

// 404 handler
app.use((req, res) => {
  res.status(404).json({ error: "Endpoint tidak ditemukan" });
});

// Error handler
app.use((err, req, res, next) => {
  console.error("Server error:", err);
  res.status(500).json({ error: "Terjadi kesalahan server" });
});

// Tambahkan setelah app.use('/api/admin', adminRoutes);
console.log("Available routes:");
adminRoutes.stack.forEach((r) => {
  if (r.route) console.log(r.route.path);
});

// Start server
async function startServer() {
  try {
    await db.initPool();

    app.listen(PORT, () => {
      console.log(`
╔═══════════════════════════════════════════════════════════════╗
║     🚀 MobiTravel Admin Backend with Oracle 21c Started!     ║
╠═══════════════════════════════════════════════════════════════╣
║  Admin Panel: http://localhost:${PORT}                        ║
║  API:         http://localhost:${PORT}/api/admin             ║
╠═══════════════════════════════════════════════════════════════╣
║  Default Admin:                                              ║
║    Username: ${process.env.ADMIN_USERNAME}                   ║
║    Password: ${process.env.ADMIN_PASSWORD}                   ║
╚═══════════════════════════════════════════════════════════════╝
            `);
    });
  } catch (err) {
    console.error("Failed to start server:", err);
    process.exit(1);
  }
}

startServer();
