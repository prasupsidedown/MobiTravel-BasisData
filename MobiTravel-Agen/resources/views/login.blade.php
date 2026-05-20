<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Agen — MobiTravel</title>
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
            --danger: #dc2626;
            --success: #16a34a;
            --font-display: 'Playfair Display', serif;
            --font-body: 'DM Sans', sans-serif;
            --font-mono: 'DM Mono', monospace;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            background: linear-gradient(160deg, rgba(26,51,40,.92) 0%, rgba(45,90,61,.8) 100%), url('https://images.unsplash.com/photo-1588392382834-a891154bca4d?w=1400&q=80') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 2.25rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 32px 80px rgba(0,0,0,.22);
        }
        .login-logo {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--forest);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .login-logo span { color: var(--gold); }
        .login-sub {
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }
        .badge-agen {
            display: inline-block;
            background: var(--forest);
            color: var(--gold);
            padding: 0.3rem 1rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            width: 100%;
        }
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .alert-success { background: rgba(22,163,74,.1); border: 1px solid rgba(22,163,74,.2); color: var(--success); }
        .alert-error { background: rgba(220,38,38,.1); border: 1px solid rgba(220,38,38,.2); color: var(--danger); }
        .form-group { margin-bottom: 1rem; }
        .form-group label {
            display: block;
            font-family: var(--font-mono);
            font-size: 0.65rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }
        .form-group input {
            width: 100%;
            border: 1.5px solid var(--sand);
            border-radius: 0.6rem;
            padding: 0.75rem 1rem;
            font-family: var(--font-body);
            font-size: 0.9375rem;
            color: var(--ink);
            background: var(--ivory);
            outline: none;
        }
        .form-group input:focus { border-color: var(--sage); }
        .btn-sub {
            width: 100%;
            background: var(--forest);
            color: var(--cream);
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .btn-sub:hover { background: var(--moss); }
        .card-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.82rem;
            color: var(--muted);
        }
        .card-footer a { color: var(--sage); text-decoration: none; }
        .card-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">Mobi<span>Travel</span></div>
        <div class="login-sub">Masuk ke Dashboard Agen</div>
        <div class="badge-agen">🏢 AGEN PANEL</div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <form action="/login/agen" method="POST">
            @csrf
            <div class="form-group">
                <label>EMAIL AGEN</label>
                <input type="email" name="email" placeholder="email@agen.com" required>
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-sub">Masuk ke Dashboard →</button>
        </form>

        <div class="card-footer">
            Ingin menjadi agen? <a href="/register/agen">Daftar di sini</a>
        </div>
    </div>
</body>
</html>