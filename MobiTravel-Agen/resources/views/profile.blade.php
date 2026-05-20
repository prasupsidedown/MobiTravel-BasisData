<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil — MobiTravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --forest:#1a3328; --gold:#e8a83e; --ivory:#faf8f3; --sand:#e8dfc8; --ink:#2e2e2e; --muted:#7a7a6e; --fd:'Playfair Display',serif; --fb:'DM Sans',sans-serif; --fm:'DM Mono',monospace; }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:var(--fb);background:var(--ivory);padding:2rem}
        .container{max-width:600px;margin:0 auto}
        .card{background:#fff;border-radius:1.5rem;padding:2rem;border:1px solid var(--sand)}
        .logo{font-family:var(--fd);font-size:1.75rem;font-weight:900;color:var(--forest);text-align:center;margin-bottom:1rem}
        .logo span{color:var(--gold)}
        .title{font-family:var(--fd);font-size:1.5rem;font-weight:700;text-align:center;margin-bottom:0.5rem}
        .sub{text-align:center;color:var(--muted);margin-bottom:1.5rem}
        .alert{padding:0.75rem 1rem;border-radius:0.6rem;margin-bottom:1rem}
        .alert-success{background:rgba(22,163,74,.1);color:#16a34a}
        .alert-error{background:rgba(220,38,38,.1);color:#dc2626}
        .form-group{margin-bottom:1rem}
        .form-group label{display:block;font-family:var(--fm);font-size:0.65rem;color:var(--muted);margin-bottom:0.4rem}
        .form-group input{width:100%;border:1.5px solid var(--sand);border-radius:0.6rem;padding:0.75rem;background:var(--ivory)}
        .btn-save{width:100%;background:var(--forest);color:#fff;border:none;border-radius:0.75rem;padding:0.875rem;font-weight:600;cursor:pointer}
        .btn-save:hover{background:#2d5a3d}
        .back-link{display:block;text-align:center;margin-top:1rem;color:var(--muted)}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">Mobi<span>Travel</span></div>
            <div class="title">Profil Saya</div>
            <div class="sub">Kelola informasi akun Anda</div>
            @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-error">❌ {{ session('error') }}</div>@endif
            <form action="/profil/update" method="POST">
                @csrf
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" value="{{ session('user_nama', session('agen_nama', '')) }}"></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ session('user_email', session('agen_email', '')) }}"></div>
                <div class="form-group"><label>No HP</label><input type="text" name="hp" value="{{ session('user_hp', '') }}"></div>
                <div class="form-group"><label>Kota</label><input type="text" name="kota" value="{{ session('user_kota', '') }}"></div>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </form>
            <a href="/" class="back-link">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>