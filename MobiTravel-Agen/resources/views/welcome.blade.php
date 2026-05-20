<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobiTravel — Perjalanan Berasa Rumah</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --forest: #1a3328;
            --moss: #2d5a3d;
            --sage: #4e8060;
            --gold: #e8a83e;
            --cream: #f5f0e8;
            --ivory: #faf8f3;
            --sand: #e8dfc8;
            --ink: #2e2e2e;
            --muted: #7a7a6e;
            --font-display: 'Playfair Display', serif;
            --font-body: 'DM Sans', sans-serif;
            --font-mono: 'DM Mono', monospace;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            background: var(--ivory);
            color: var(--ink);
            overflow-x: hidden;
        }
        .nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 4rem;
            background: rgba(245,240,232,.92);
            backdrop-filter: blur(12px);
        }
        .nav__logo {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--forest);
        }
        .nav__logo span { color: var(--gold); }
        .nav__links { display: flex; gap: 2.5rem; list-style: none; }
        .nav__links a {
            font-size: .875rem;
            font-weight: 500;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--ink);
            text-decoration: none;
        }
        .nav__links a:hover { color: var(--sage); }
        .nav__cta {
            background: var(--gold);
            color: var(--forest) !important;
            padding: .5rem 1.25rem;
            border-radius: 2rem;
            font-weight: 700 !important;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(160deg, rgba(26,51,40,.92) 0%, rgba(45,90,61,.8) 100%), url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?w=1400&q=80') center/cover no-repeat;
            padding: 7rem 4rem 4rem;
        }
        .hero__content { max-width: 900px; }
        .hero__tag {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-mono);
            font-size: .75rem;
            letter-spacing: .12em;
            color: var(--gold);
            margin-bottom: 1.5rem;
        }
        .hero__tag::before { content: ''; width: 2.5rem; height: 1px; background: var(--gold); }
        .hero__title {
            font-family: var(--font-display);
            font-size: clamp(3rem, 7vw, 6rem);
            font-weight: 900;
            line-height: 1.0;
            color: var(--cream);
            margin-bottom: 1.5rem;
        }
        .hero__title em { font-style: italic; color: var(--gold); }
        .hero__sub {
            font-size: 1.125rem;
            line-height: 1.7;
            color: rgba(245,240,232,.8);
            max-width: 520px;
            margin-bottom: 2.5rem;
        }
        .btn {
            display: inline-flex;
            padding: .875rem 2rem;
            border-radius: 3rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn--primary { background: var(--gold); color: var(--forest); }
        .btn--outline { background: transparent; border: 1.5px solid rgba(255,255,255,.5); color: var(--cream); }
        .hero__actions { display: flex; gap: 1rem; flex-wrap: wrap; }

        /* Section Umum */
        section { padding: 5rem 4rem; }
        .section-tag {
            font-family: var(--font-mono);
            font-size: .75rem;
            letter-spacing: .12em;
            color: var(--sage);
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: .75rem;
        }
        .section-tag::before { content: ''; width: 2rem; height: 1px; background: var(--sage); }
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            color: var(--forest);
            margin-bottom: 2rem;
        }

        /* Grid */
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .card {
            background: #fff;
            border: 1.5px solid var(--sand);
            border-radius: 1rem;
            overflow: hidden;
            transition: transform .2s;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 28px rgba(26,51,40,.1); }
        .card-img { width: 100%; height: 180px; object-fit: cover; background: var(--sand); }
        .card-body { padding: 1.25rem; }
        .card-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: var(--forest); margin-bottom: .25rem; }
        .card-meta { font-size: .75rem; color: var(--muted); margin-bottom: .5rem; }
        .card-price { font-weight: 700; color: var(--gold); margin-top: .5rem; }
        .badge { display: inline-block; background: var(--cream); padding: .2rem .6rem; border-radius: 2rem; font-size: .7rem; margin-top: .5rem; }

        .footer {
            background: #1c1c1c;
            padding: 4rem;
            text-align: center;
            color: rgba(255,255,255,.45);
        }
        @media (max-width: 1024px) { .nav { padding: 1rem 2rem; } section { padding: 3rem 2rem; } .hero { padding: 6rem 2rem 3rem; } }
        @media (max-width: 640px) { .nav__links { gap: 1rem; } .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="nav__logo">Mobi<span>Travel</span></div>
        <ul class="nav__links">
            <li><a href="/">Beranda</a></li>
            <li><a href="/agen-list">Agen</a></li>
            <li><a href="/destinasi">Destinasi</a></li>
            <li><a href="/ulasan">Ulasan</a></li>
            @if(session('agen_token'))
                <li><a href="/dashboard" style="background:var(--forest);color:var(--cream);padding:0.4rem 1rem;border-radius:2rem">Dashboard</a></li>
            @else
                <li><a href="/login" class="nav__cta">Login</a></li>
            @endif
        </ul>
    </nav>

    <section class="hero">
        <div class="hero__content">
            <div class="hero__tag">Platform Travel Lokal Indonesia</div>
            <h1 class="hero__title">Pergi Jauh,<br><em>Pulang ke Rumah</em></h1>
            <p class="hero__sub">Temukan agen travel lokal terpercaya di kotamu. Wisata keluarga, pulang kampung dengan nyaman — tersedia supir berpengalaman agar kamu tak kelelahan di jalan.</p>
            <div class="hero__actions">
                <a href="/destinasi" class="btn btn--primary">Cari Perjalanan</a>
                <a href="/register/agen" class="btn btn--outline">Daftar Agen</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>© 2024 MobiTravel — Platform Agen Travel Lokal Indonesia</p>
    </footer>
</body>
</html>