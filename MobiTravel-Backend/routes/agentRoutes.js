const express = require("express");
const router = express.Router();
const db = require("../config/database");

// ============ REGISTRASI AGEN ============
router.post("/register/agen", async (req, res) => {
  const {
    nama,
    nama_agen,
    email,
    password,
    no_hp,
    alamat,
    kota,
    provinsi,
    jenis_usaha,
  } = req.body;

  try {
    // Cek email sudah ada atau belum
    const existing = await db.query(
      `SELECT id FROM agents WHERE email = :email`,
      { email: email },
    );
    if (existing && existing.length > 0) {
      return res
        .status(400)
        .json({ success: false, error: "Email sudah terdaftar" });
    }

    // Insert agen baru (tanpa RETURNING INTO untuk menghindari binding issue)
    await db.execute(
      `
            INSERT INTO agents (nama, nama_agen, email, password, no_hp, alamat, kota, provinsi, jenis_usaha, status)
            VALUES (:nama, :nama_agen, :email, :password, :no_hp, :alamat, :kota, :provinsi, :jenis_usaha, 'pending')
        `,
      {
        nama: nama,
        nama_agen: nama_agen,
        email: email,
        password: password,
        no_hp: no_hp,
        alamat: alamat,
        kota: kota,
        provinsi: provinsi,
        jenis_usaha: jenis_usaha,
      },
    );

    res.json({
      success: true,
      message: "Pendaftaran berhasil! Menunggu verifikasi admin.",
    });
  } catch (err) {
    console.error("Register error:", err);
    res.status(500).json({ success: false, error: err.message });
  }
});

// API untuk sinkronisasi dari Laravel (Agen menambah wisata)
router.post("/sync/wisata", async (req, res) => {
  const { action, data } = req.body;

  try {
    if (action === "create") {
      await db.execute(
        `
                INSERT INTO wisata (id, agen_id, judul, lokasi, deskripsi, harga, kategori, status, created_at)
                VALUES (:id, :agen_id, :judul, :lokasi, :deskripsi, :harga, :kategori, 'active', SYSDATE)
            `,
        data,
      );
    } else if (action === "update") {
      await db.execute(
        `
                UPDATE wisata SET judul = :judul, lokasi = :lokasi, deskripsi = :deskripsi, harga = :harga
                WHERE id = :id
            `,
        data,
      );
    } else if (action === "delete") {
      await db.execute(`UPDATE wisata SET status = 'deleted' WHERE id = :id`, {
        id: data.id,
      });
    }

    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// API untuk Flutter mendapatkan daftar wisata
router.get("/api/wisata", async (req, res) => {
  try {
    const result = await db.query(`
            SELECT w.*, a.nama_agen, a.nama as agen_nama
            FROM wisata w
            JOIN agents a ON w.agen_id = a.id
            WHERE w.status = 'active'
            ORDER BY w.created_at DESC
        `);
    res.json(result);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// API untuk booking dari Flutter
router.post("/api/booking", async (req, res) => {
  const { user_id, wisata_id, trip_id, harga } = req.body;

  try {
    const result = await db.execute(
      `
            INSERT INTO bookings (user_id, wisata_id, trip_id, status, harga, created_at)
            VALUES (:user_id, :wisata_id, :trip_id, 'pending', :harga, SYSDATE)
            RETURNING id INTO :id
        `,
      {
        user_id,
        wisata_id,
        trip_id,
        harga,
        id: { dir: oracledb.BIND_OUT, type: oracledb.NUMBER },
      },
    );

    res.json({ success: true, booking_id: result.outBinds.id });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
