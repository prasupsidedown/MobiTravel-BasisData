<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Destinasi — MobiTravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
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
        .card{background:#fff;border:1px solid var(--sand);border-radius:1rem;overflow:hidden}
        .card-img{height:160px;background:var(--sand);display:flex;align-items:center;justify-content:center;color:var(--muted)}
        .card-body{padding:1.25rem}
        .card-title{font-family:var(--fd);font-size:1.1rem;font-weight:700;color:var(--forest)}
        .card-price{color:var(--gold);font-weight:700;margin-top:0.5rem}
        .card-agen{font-size:0.75rem;color:var(--muted);margin-top:0.25rem}
        .back{display:inline-block;margin-bottom:1rem;color:var(--forest)}
    </style>
</head>
<body>
    <div class="nav">
        <div class="nav-logo">Mobi<span>Travel</span></div>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/agen-list">Agen</a>
            <a href="/ulasan">Ulasan</a>
            <a href="/login">Login</a>
        </div>
    </div>
    <div class="container">
        <a href="/" class="back">← Kembali</a>
        <h1>Destinasi Wisata</h1>
        <p class="sub">Temukan paket wisata dari agen terpercaya</p>
        <div class="grid" id="destinasi-list">
            <div class="card">Memuat data...</div>
        </div>
    </div>
    <script>
        Promise.all([
            fetch('http://localhost:5000/api/public/wisata').then(r=>r.json()),
            fetch('http://localhost:5000/api/public/trips').then(r=>r.json())
        ]).then(([wisata, trips]) => {
            const all = [...(wisata||[]).map(w=>({...w, type:'wisata'})), ...(trips||[]).map(t=>({...t, type:'trip'}))];
            if(all.length){
                document.getElementById('destinasi-list').innerHTML = all.map(d => `
                    <div class="card">
                        <div class="card-img">🏝️ ${d.JUDUL?.charAt(0) || '📍'}</div>
                        <div class="card-body">
                            <div class="card-title">${d.JUDUL}</div>
                            <div class="card-agen">👤 ${d.AGEN_NAMA || d.agen_nama || 'Agen'}</div>
                            <div class="card-price">Rp ${Number(d.HARGA).toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                `).join('');
            } else {
                document.getElementById('destinasi-list').innerHTML = '<div class="card">Belum ada destinasi</div>';
            }
        }).catch(() => document.getElementById('destinasi-list').innerHTML = '<div class="card">Gagal memuat data</div>');
    </script>
</body>
</html>