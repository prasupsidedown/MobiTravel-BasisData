<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Agen — MobiTravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --forest:#1a3328; --gold:#e8a83e; --ivory:#faf8f3; --sand:#e8dfc8; --ink:#2e2e2e; --muted:#7a7a6e; --fd:'Playfair Display',serif; --fb:'DM Sans',sans-serif; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:var(--fb);background:var(--ivory)}
        .nav{padding:1rem 2rem;background:#fff;border-bottom:1px solid var(--sand);display:flex;justify-content:space-between}
        .nav-logo{font-family:var(--fd);font-size:1.3rem;font-weight:900;color:var(--forest)}.nav-logo span{color:var(--gold)}
        .nav-links a{margin-left:1.5rem;text-decoration:none;color:var(--ink)}
        .container{max-width:1200px;margin:0 auto;padding:2rem}
        h1{font-family:var(--fd);font-size:2rem;color:var(--forest);margin-bottom:0.5rem}
        .sub{color:var(--muted);margin-bottom:2rem}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem}
        .card{background:#fff;border:1px solid var(--sand);border-radius:1rem;padding:1.5rem}
        .card h3{font-family:var(--fd);color:var(--forest);margin-bottom:0.5rem}
        .card p{color:var(--muted);margin-bottom:0.25rem}
        .badge{display:inline-block;background:var(--forest);color:#fff;padding:0.2rem 0.8rem;border-radius:2rem;font-size:0.7rem;margin-top:0.5rem}
        .back{display:inline-block;margin-bottom:1rem;color:var(--forest)}
    </style>
</head>
<body>
    <div class="nav">
        <div class="nav-logo">Mobi<span>Travel</span></div>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/destinasi">Destinasi</a>
            <a href="/ulasan">Ulasan</a>
            <a href="/login">Login</a>
        </div>
    </div>
    <div class="container">
        <a href="/" class="back">← Kembali</a>
        <h1>Daftar Agen Travel</h1>
        <p class="sub">Agen travel lokal terpercaya di seluruh Indonesia</p>
        <div class="grid" id="agents-list">
            <div class="card">Memuat data...</div>
        </div>
    </div>
    <script>
        fetch('http://localhost:5000/api/public/agents')
            .then(res => res.json())
            .then(agents => {
                if(agents.length){
                    document.getElementById('agents-list').innerHTML = agents.map(a => `
                        <div class="card">
                            <h3>${a.NAMA_AGEN || a.nama_agen}</h3>
                            <p>📧 ${a.EMAIL || a.email}</p>
                            <p>👤 ${a.NAMA || a.nama}</p>
                            <div class="badge">${a.TOTAL_WISATA || 0} Paket Wisata</div>
                        </div>
                    `).join('');
                } else {
                    document.getElementById('agents-list').innerHTML = '<div class="card">Belum ada agen terdaftar</div>';
                }
            })
            .catch(() => document.getElementById('agents-list').innerHTML = '<div class="card">Gagal memuat data</div>');
    </script>
</body>
</html>