<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Agen — MobiTravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --forest: #1a3328;
            --moss: #2d5a3d;
            --sage: #4e8060;
            --gold: #e8a83e;
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
            background: var(--ivory);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid var(--sand);
        }
        .logo {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--forest);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .logo span { color: var(--gold); }
        .title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .sub {
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.6rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .alert-success { background: rgba(22,163,74,.1); border: 1px solid rgba(22,163,74,.2); color: var(--success); }
        .alert-error { background: rgba(220,38,38,.1); border: 1px solid rgba(220,38,38,.2); color: var(--danger); }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
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
        .form-group input, .form-group select, .form-group textarea {
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
        .form-group input:focus, .form-group select:focus { border-color: var(--sage); }
        .form-group textarea { resize: vertical; min-height: 80px; }
        .btn-sub {
            width: 100%;
            background: var(--forest);
            color: white;
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
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }
        .login-link a { color: var(--sage); text-decoration: none; }
        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
            .card { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">Mobi<span>Travel</span></div>
            <div class="title">Daftar Agen Travel</div>
            <div class="sub">Isi formulir berikut untuk menjadi agen MobiTravel</div>

            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ url('/register/agen') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Agen / Brand *</label>
                        <input type="text" name="nama_agen" value="{{ old('nama_agen') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>No HP / WhatsApp *</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat *</label>
                    <textarea name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kota *</label>
                        <input type="text" name="kota" value="{{ old('kota') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi *</label>
                        <select name="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                            <option value="Jawa Barat" {{ old('provinsi') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                            <option value="Jawa Tengah" {{ old('provinsi') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                            <option value="Jawa Timur" {{ old('provinsi') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                            <option value="DKI Jakarta" {{ old('provinsi') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                            <option value="Banten" {{ old('provinsi') == 'Banten' ? 'selected' : '' }}>Banten</option>
                            <option value="DI Yogyakarta" {{ old('provinsi') == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                            <option value="Bali" {{ old('provinsi') == 'Bali' ? 'selected' : '' }}>Bali</option>
                            <option value="Sumatera Utara" {{ old('provinsi') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                            <option value="Sumatera Barat" {{ old('provinsi') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                            <option value="Riau" {{ old('provinsi') == 'Riau' ? 'selected' : '' }}>Riau</option>
                            <option value="Kalimantan Selatan" {{ old('provinsi') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                            <option value="Sulawesi Selatan" {{ old('provinsi') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Usaha *</label>
                        <select name="jenis_usaha" required>
                            <option value="">Pilih Jenis Usaha</option>
                            <option value="Biro Perjalanan Wisata" {{ old('jenis_usaha') == 'Biro Perjalanan Wisata' ? 'selected' : '' }}>Biro Perjalanan Wisata</option>
                            <option value="Rental Kendaraan + Supir" {{ old('jenis_usaha') == 'Rental Kendaraan + Supir' ? 'selected' : '' }}>Rental Kendaraan + Supir</option>
                            <option value="Tour Guide" {{ old('jenis_usaha') == 'Tour Guide' ? 'selected' : '' }}>Tour Guide</option>
                            <option value="Paket Wisata Keluarga" {{ old('jenis_usaha') == 'Paket Wisata Keluarga' ? 'selected' : '' }}>Paket Wisata Keluarga</option>
                            <option value="Travel Haji/Umrah" {{ old('jenis_usaha') == 'Travel Haji/Umrah' ? 'selected' : '' }}>Travel Haji/Umrah</option>
                            <option value="Event Organizer Travel" {{ old('jenis_usaha') == 'Event Organizer Travel' ? 'selected' : '' }}>Event Organizer Travel</option>
                            <option value="Lainnya" {{ old('jenis_usaha') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Usaha</label>
                        <textarea name="deskripsi_usaha" rows="2" placeholder="Ceritakan sedikit tentang usaha travel Anda...">{{ old('deskripsi_usaha') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn-sub">Daftar Sebagai Agen →</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a>
            </div>
        </div>
    </div>

    <script>
        // Hilangkan alert setelah 5 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>