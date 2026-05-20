<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ulasan — MobiTravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --forest:#1a3328; --gold:#e8a83e; --ivory:#faf8f3; --sand:#e8dfc8; --ink:#2e2e2e; --muted:#7a7a6e; --fd:'Playfair Display',serif; --fb:'DM Sans',sans-serif; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:var(--fb);background:var(--ivory)}
        .nav{padding:1rem 2rem;background:#fff;border-bottom:1px solid var(--sand);display:flex;justify-content:space-between}
        .nav-logo{font-family:var(--fd);font-size:1.3rem;font-weight:900;color:var(--forest)}.nav-logo span{color:var(--gold)}
        .nav-links a{margin-left:1.5rem;text-decoration:none;color:var(--ink)}
        .container{max-width:900px;margin:0 auto;padding:2rem}
        h1{font-family:var(--fd);font-size:2rem;color:var(--forest);margin-bottom:0.5rem}
        .sub{color:var(--muted);margin-bottom:2rem}
        .review-card{background:#fff;border:1px solid var(--sand);border-radius:1rem;padding:1.5rem;margin-bottom:1rem}
        .review-stars{color:var(--gold);margin-bottom:0.5rem;font-size:1.1rem}
        .review-text{color:var(--ink);line-height:1.6;margin-bottom:0.75rem}
        .review-user{font-weight:600;color:var(--forest)}
        .review-item{font-size:0.75rem;color:var(--muted);margin-top:0.25rem}
        .back{display:inline-block;margin-bottom:1rem;color:var(--forest)}
        .empty{text-align:center;padding:3rem;color:var(--muted)}
    </style>
</head>
<body>
    <div class="nav">
        <div class="nav-logo">Mobi<span>Travel</span></div>
        <div class="nav-links">
            <a href="/">Beranda</a>
            <a href="/agen-list">Agen</a>
            <a href="/destinasi">Destinasi</a>
            <a href="/login">Login</a>
        </div>
    </div>
    <div class="container">
        <a href="/" class="back">← Kembali</a>
        <h1>Ulasan Pengguna</h1>
        <p class="sub">Apa kata mereka tentang perjalanan bersama MobiTravel</p>
        <div id="reviews-list">
            <div class="review-card">Memuat data...</div>
        </div>
    </div>
    <script>
        fetch('http://localhost:5000/api/public/reviews')
            .then(res => res.json())
            .then(reviews => {
                if(reviews.length){
                    document.getElementById('reviews-list').innerHTML = reviews.map(r => `
                        <div class="review-card">
                            <div class="review-stars">${'★'.repeat(r.RATING || 5)}</div>
                            <div class="review-text">${r.KOMENTAR || r.komentar || 'Tidak ada komentar'}</div>
                            <div class="review-user">👤 ${r.USER_NAMA || r.user_nama || 'Pengguna'}</div>
                            <div class="review-item">📦 ${r.ITEM_NAMA || r.item_nama || 'Wisata'}</div>
                        </div>
                    `).join('');
                } else {
                    document.getElementById('reviews-list').innerHTML = '<div class="empty">Belum ada ulasan dari pengguna</div>';
                }
            })
            .catch(() => document.getElementById('reviews-list').innerHTML = '<div class="empty">Gagal memuat ulasan</div>');
    </script>
</body>
</html>