<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Agen — MobiTravel</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
    --forest:#1a3328;--moss:#2d5a3d;--sage:#4e8060;--mist:#a8c5b0;
    --cream:#f5f0e8;--ivory:#faf8f3;--sand:#e8dfc8;--terra:#c17f3b;
    --gold:#e8a83e;--charcoal:#1c1c1c;--ink:#2e2e2e;--muted:#7a7a6e;
    --danger:#dc2626;--success:#16a34a;--warn:#d97706;
    --fd:'Playfair Display',serif;--fb:'DM Sans',sans-serif;--fm:'DM Mono',monospace;
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
body{font-family:var(--fb);background:var(--ivory);color:var(--ink);display:grid;grid-template-columns:260px 1fr;min-height:100vh}

/* SIDEBAR */
.sb{background:var(--forest);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
.sb-logo{padding:1.75rem 1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.07)}
.sb-logo a{font-family:var(--fd);font-size:1.4rem;font-weight:900;color:var(--cream);text-decoration:none}
.sb-logo a span{color:var(--gold)}
.sb-pill{display:inline-block;background:rgba(232,168,62,.12);color:var(--gold);font-family:var(--fm);font-size:.6rem;padding:.2rem .6rem;border-radius:2rem;margin-top:.35rem}
.sb-user{padding:1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.05);display:flex;align-items:center;gap:.75rem}
.sb-av{width:2.4rem;height:2.4rem;border-radius:50%;background:rgba(168,197,176,.18);display:flex;align-items:center;justify-content:center;font-family:var(--fd);font-weight:700;color:var(--mist);font-size:.95rem}
.sb-uname{font-size:.85rem;font-weight:600;color:var(--cream)}
.sb-urole{font-size:.68rem;color:rgba(168,197,176,.5);font-family:var(--fm)}
.sb-sec{padding:1rem 1.5rem .4rem;font-family:var(--fm);font-size:.62rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(168,197,176,.35)}
.sb-a{display:flex;align-items:center;gap:.7rem;padding:.65rem 1.5rem;color:rgba(245,240,232,.55);font-size:.85rem;cursor:pointer;border-left:3px solid transparent;text-decoration:none}
.sb-a:hover{color:var(--cream);background:rgba(255,255,255,.04)}
.sb-a.active{color:var(--cream);background:rgba(255,255,255,.06);border-left-color:var(--gold)}
.sb-a svg{width:17px;height:17px}
.sb-badge{margin-left:auto;background:var(--gold);color:var(--forest);font-family:var(--fm);font-size:.6rem;font-weight:700;padding:.15rem .45rem;border-radius:2rem}
.sb-foot{margin-top:auto;padding:1rem 1.5rem;border-top:1px solid rgba(255,255,255,.05)}
.btn-out{width:100%;background:rgba(220,38,38,.1);color:#fca5a5;border:1px solid rgba(220,38,38,.18);border-radius:.5rem;padding:.6rem;font-family:var(--fb);font-size:.85rem;cursor:pointer}
.btn-out:hover{background:rgba(220,38,38,.2)}

/* MAIN */
.main{display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#fff;border-bottom:1px solid var(--sand);padding:1.1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.tb-left h1{font-family:var(--fd);font-size:1.15rem;font-weight:700;color:var(--forest)}
.tb-left p{font-size:.75rem;color:var(--muted);margin-top:.1rem;font-family:var(--fm)}
.btn-add{background:var(--forest);color:var(--cream);border:none;border-radius:.5rem;padding:.6rem 1.1rem;font-family:var(--fb);font-size:.85rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:.4rem}
.btn-add:hover{background:var(--moss)}
.content{padding:1.75rem 2rem;flex:1}

/* ALERT */
.alert{padding:.8rem 1.1rem;border-radius:.65rem;font-size:.85rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.6rem}
.alert-s{background:rgba(22,163,74,.07);border:1px solid rgba(22,163,74,.2);color:var(--success)}
.alert-e{background:rgba(220,38,38,.07);border:1px solid rgba(220,38,38,.2);color:var(--danger)}

/* STATS */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.75rem}
.sc{background:#fff;border:1.5px solid var(--sand);border-radius:.85rem;padding:1.25rem;transition:transform .2s}
.sc:hover{transform:translateY(-3px)}
.sc-lbl{font-family:var(--fm);font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem}
.sc-val{font-family:var(--fd);font-size:2rem;font-weight:900}
.sc.g .sc-val{color:var(--sage)}.sc.o .sc-val{color:var(--terra)}.sc.t .sc-val{color:var(--terra)}.sc.b .sc-val{color:#3b82f6}
.sc-sub{font-size:.72rem;color:var(--muted);margin-top:.3rem}

/* TABS */
.tabs{display:flex;gap:.25rem;margin-bottom:1.5rem;border-bottom:1px solid var(--sand);flex-wrap:wrap}
.tab{padding:.6rem 1.1rem;font-size:.85rem;font-weight:500;color:var(--muted);cursor:pointer;border:none;border-bottom:2px solid transparent;background:none}
.tab:hover{color:var(--forest)}
.tab.active{color:var(--forest);border-bottom-color:var(--gold);font-weight:600}
.panel{display:none}.panel.active{display:block}

/* GRID & CARD */
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:1.1rem}
.card{background:#fff;border:1.5px solid var(--sand);border-radius:.85rem;overflow:hidden}
.card:hover{transform:translateY(-4px);box-shadow:0 12px 28px rgba(26,51,40,.1)}
.card-head{background:linear-gradient(135deg,var(--forest) 0%,var(--moss) 100%);padding:1.1rem 1.25rem;position:relative}
.card-head.wisata{background:linear-gradient(135deg,#1e3a5f 0%,#2d5a8e 100%)}
.card-id{position:absolute;top:.75rem;right:.75rem;background:rgba(255,255,255,.1);color:rgba(245,240,232,.5);font-family:var(--fm);font-size:.6rem;padding:.15rem .45rem;border-radius:2rem}
.card-type{display:inline-block;background:rgba(255,255,255,.12);color:rgba(245,240,232,.7);font-size:.62rem;font-family:var(--fm);padding:.15rem .5rem;border-radius:2rem;margin-bottom:.4rem}
.card-title{font-family:var(--fd);font-size:1.05rem;font-weight:700;color:var(--cream);margin-bottom:.25rem}
.card-price{font-family:var(--fm);font-size:.75rem;color:var(--gold)}
.card-body{padding:1.1rem 1.25rem}
.card-desc{font-size:.82rem;color:var(--muted);line-height:1.6;margin-bottom:.85rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.card-meta{font-family:var(--fm);font-size:.65rem;color:var(--muted);margin-bottom:.85rem}
.card-acts{display:flex;gap:.5rem}
.btn-e{flex:1;background:rgba(78,128,96,.07);color:var(--sage);border:1px solid rgba(78,128,96,.18);border-radius:.45rem;padding:.5rem;font-size:.78rem;font-weight:600;cursor:pointer}
.btn-d{flex:1;background:rgba(220,38,38,.05);color:var(--danger);border:1px solid rgba(220,38,38,.14);border-radius:.45rem;padding:.5rem;font-size:.78rem;font-weight:600;cursor:pointer}

/* BOOKING */
.bk-row{background:#fff;border:1.5px solid var(--sand);border-radius:.75rem;padding:1rem 1.25rem;display:flex;justify-content:space-between;align-items:center;margin-bottom:.6rem}
.bk-title{font-weight:600;font-size:.9rem;color:var(--forest)}
.bk-meta{font-family:var(--fm);font-size:.68rem;color:var(--muted);margin-top:.2rem}
.bk-st{display:inline-block;padding:.25rem .75rem;border-radius:2rem;font-size:.72rem;font-weight:600}
.bk-st.pending{background:rgba(217,119,6,.1);color:var(--warn)}
.bk-st.confirmed{background:rgba(22,163,74,.1);color:var(--success)}
.bk-st.done{background:rgba(100,116,139,.1);color:#64748b}

/* REVENUE */
.rev-card{background:#fff;border:1.5px solid var(--sand);border-radius:.85rem;padding:1.5rem}
.rev-amount{font-family:var(--fd);font-size:2.5rem;font-weight:900;color:var(--forest)}
.rev-table{width:100%;border-collapse:collapse;margin-top:1rem}
.rev-table th{text-align:left;font-family:var(--fm);font-size:.65rem;color:var(--muted);padding:.6rem .75rem;border-bottom:1px solid var(--sand)}
.rev-table td{padding:.75rem;font-size:.85rem;border-bottom:1px solid rgba(232,223,200,.5)}
.rev-pos{color:var(--success);font-weight:600}

/* AKUN */
.akun-card{background:#fff;border:1.5px solid var(--sand);border-radius:.85rem;padding:1.5rem}
.akun-hd{display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem}
.akun-av{width:4rem;height:4rem;border-radius:50%;background:var(--forest);display:flex;align-items:center;justify-content:center;font-family:var(--fd);font-size:1.5rem;font-weight:700;color:var(--cream)}
.akun-name{font-family:var(--fd);font-size:1.2rem;font-weight:700;color:var(--forest)}
.akun-email{font-size:.82rem;color:var(--muted)}

/* EMPTY & FORMS */
.empty{text-align:center;padding:3rem;background:#fff;border:1.5px dashed var(--sand);border-radius:.85rem}
.fg{margin-bottom:1rem}
.fg label{display:block;font-family:var(--fm);font-size:.65rem;color:var(--muted);margin-bottom:.4rem}
.fg input,.fg select,.fg textarea{width:100%;border:1.5px solid var(--sand);border-radius:.5rem;padding:.65rem .9rem;font-family:var(--fb);font-size:.9rem;background:var(--ivory)}
.btn-sub{width:100%;background:var(--forest);color:var(--cream);border:none;border-radius:.65rem;padding:.8rem;font-family:var(--fd);font-size:.95rem;font-weight:700;cursor:pointer}
.btn-save{background:var(--forest);color:var(--cream);border:none;border-radius:.5rem;padding:.7rem 1.5rem;font-weight:600;cursor:pointer}

/* MODAL */
.ov{position:fixed;inset:0;background:rgba(26,51,40,.55);backdrop-filter:blur(5px);z-index:200;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .22s}
.ov.open{opacity:1;pointer-events:all}
.modal{background:#fff;border-radius:1rem;width:100%;max-width:500px;padding:1.75rem;max-height:88vh;overflow-y:auto}
.modal-h{display:flex;justify-content:space-between;margin-bottom:1.25rem}
.modal-t{font-family:var(--fd);font-size:1.1rem;font-weight:700;color:var(--forest)}
.modal-x{width:1.9rem;height:1.9rem;border-radius:50%;border:1px solid var(--sand);background:none;cursor:pointer}
.confirm-acts{display:flex;gap:.6rem;margin-top:1rem}
.btn-cancel{flex:1;background:var(--ivory);border:1px solid var(--sand);border-radius:.65rem;padding:.7rem}
.btn-del{flex:1;background:var(--danger);color:#fff;border:none;border-radius:.65rem;padding:.7rem;cursor:pointer}

@media(max-width:1024px){body{grid-template-columns:1fr}.sb{display:none}.stats{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.stats{grid-template-columns:1fr}.content{padding:1.25rem}}
</style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sb">
    <div class="sb-logo"><a href="/"><span>Mobi</span>Travel</a><div class="sb-pill">Agen Panel</div></div>
    <div class="sb-user">
        <div class="sb-av">{{ strtoupper(substr(session('agen_nama','A'),0,1)) }}</div>
        <div><div class="sb-uname">{{ session('agen_nama','Agen') }}</div><div class="sb-urole">{{ session('agen_nama_agen','—') }}</div></div>
    </div>
    <div class="sb-sec">Menu</div>
    <a class="sb-a active" href="#" onclick="showTab('dashboard',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a>
    <a class="sb-a" href="#" onclick="showTab('trip',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Trip Saya</a>
    <a class="sb-a" href="#" onclick="showTab('wisata',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>Wisata Saya</a>
    <a class="sb-a" href="#" onclick="showTab('booking',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Booking Masuk<span class="sb-badge" id="booking-badge">0</span></a>
    <a class="sb-a" href="#" onclick="showTab('penghasilan',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Pendapatan</a>
    <a class="sb-a" href="#" onclick="showTab('akun',this)"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>Akun Saya</a>
    <div class="sb-foot"><form action="/logout" method="POST">@csrf<button type="submit" class="btn-out">Keluar</button></form></div>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div class="tb-left"><h1 id="tb-title">Dashboard</h1><p id="tb-sub">Ringkasan aktivitas agen Anda</p></div>
        <button class="btn-add" id="btn-global" style="display:none" onclick="openOv('ov-trip')"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>Tambah Trip</button>
    </div>
    <div class="content">
        @if(session('success'))<div class="alert alert-s">✅ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-e">❌ {{ session('error') }}</div>@endif

        {{-- DASHBOARD --}}
        <div class="panel active" id="panel-dashboard">
            <div class="stats">
                <div class="sc g"><div class="sc-lbl">Total Trip</div><div class="sc-val" id="stat-trips">0</div><div class="sc-sub">Paket aktif</div></div>
                <div class="sc o"><div class="sc-lbl">Total Wisata</div><div class="sc-val" id="stat-wisata">0</div><div class="sc-sub">Destinasi aktif</div></div>
                <div class="sc t"><div class="sc-lbl">Booking Masuk</div><div class="sc-val" id="stat-bookings">0</div><div class="sc-sub">Total booking</div></div>
                <div class="sc b"><div class="sc-lbl">Pendapatan</div><div class="sc-val" id="stat-revenue" style="font-size:1.2rem">Rp 0</div><div class="sc-sub">Confirmed/Done</div></div>
            </div>
            <div class="rev-card"><div style="display:flex;justify-content:space-between;margin-bottom:1rem"><div style="font-weight:700">Booking Terbaru</div><button class="btn-refresh" style="background:var(--ivory);border:1px solid var(--sand);padding:0.3rem 0.8rem;border-radius:0.5rem;cursor:pointer" onclick="location.reload()">🔄 Refresh</button></div><div id="recent-bookings"></div></div>
        </div>

        {{-- TRIP PANEL --}}
        <div class="panel" id="panel-trip"><div class="grid" id="trips-list"></div></div>

        {{-- WISATA PANEL --}}
        <div class="panel" id="panel-wisata"><div class="grid" id="wisata-list"></div></div>

        {{-- BOOKING PANEL --}}
        <div class="panel" id="panel-booking"><div id="bookings-list"></div></div>

        {{-- PENGHASILAN PANEL --}}
        <div class="panel" id="panel-penghasilan">
            <div class="rev-card"><div class="rev-amount" id="total-revenue">Rp 0</div><div style="font-size:.8rem;color:var(--success);margin-bottom:.5rem">↑ Dari booking confirmed/done</div>
            <table class="rev-table"><thead><tr><th>Item</th><th>User</th><th>Tanggal</th><th>Nominal</th></tr></thead><tbody id="revenue-table"></tbody></table></div>
        </div>

        {{-- AKUN PANEL --}}
        <div class="panel" id="panel-akun">
            <div class="akun-card">
                <div class="akun-hd"><div class="akun-av">{{ strtoupper(substr(session('agen_nama','A'),0,1)) }}</div><div><div class="akun-name" id="akun-nama">{{ session('agen_nama','—') }}</div><div class="akun-email" id="akun-email">{{ session('agen_email','—') }}</div></div></div>
                <form id="form-update-akun">@csrf
                    <div class="fg"><label>Nama Lengkap</label><input type="text" name="nama" id="input-nama" value="{{ session('agen_nama') }}"></div>
                    <div class="fg"><label>Nama Agen / Brand</label><input type="text" name="nama_agen" id="input-nama-agen" value="{{ session('agen_nama_agen') }}"></div>
                    <div class="fg"><label>Email</label><input type="email" name="email" id="input-email" value="{{ session('agen_email') }}"></div>
                    <div class="fg"><label>Password Baru</label><input type="password" name="password" placeholder="Kosongkan jika tidak diganti"></div>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="ov" id="ov-trip" onclick="closeBg(event,'ov-trip')"><div class="modal"><div class="modal-h"><div class="modal-t">Tambah Trip</div><button class="modal-x" onclick="closeOv('ov-trip')">✕</button></div><form id="form-tambah-trip">@csrf<div class="fg"><label>Judul Trip</label><input type="text" name="judul" required></div><div class="fg"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div><div class="fg"><label>Harga (Rp)</label><input type="number" name="harga" required></div><button type="submit" class="btn-sub">Simpan →</button></form></div></div>

<div class="ov" id="ov-edit-trip" onclick="closeBg(event,'ov-edit-trip')"><div class="modal"><div class="modal-h"><div class="modal-t">Edit Trip</div><button class="modal-x" onclick="closeOv('ov-edit-trip')">✕</button></div><form id="form-edit-trip">@csrf<input type="hidden" name="id" id="edit-trip-id"><div class="fg"><label>Judul</label><input type="text" name="judul" id="edit-trip-judul" required></div><div class="fg"><label>Deskripsi</label><textarea name="deskripsi" id="edit-trip-deskripsi"></textarea></div><div class="fg"><label>Harga</label><input type="number" name="harga" id="edit-trip-harga" required></div><button type="submit" class="btn-sub">Update →</button></form></div></div>

<div class="ov" id="ov-wisata" onclick="closeBg(event,'ov-wisata')"><div class="modal"><div class="modal-h"><div class="modal-t">Tambah Wisata</div><button class="modal-x" onclick="closeOv('ov-wisata')">✕</button></div><form id="form-tambah-wisata">@csrf<div class="fg"><label>Nama Destinasi</label><input type="text" name="judul" required></div><div class="fg"><label>Lokasi</label><input type="text" name="lokasi"></div><div class="fg"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div><div class="fg"><label>Harga (Rp)</label><input type="number" name="harga" required></div><div class="fg"><label>Kategori</label><select name="kategori"><option>Alam</option><option>Budaya</option><option>Kuliner</option><option>Bahari</option><option>Petualangan</option></select></div><button type="submit" class="btn-sub">Simpan →</button></form></div></div>

<div class="ov" id="ov-edit-wisata" onclick="closeBg(event,'ov-edit-wisata')"><div class="modal"><div class="modal-h"><div class="modal-t">Edit Wisata</div><button class="modal-x" onclick="closeOv('ov-edit-wisata')">✕</button></div><form id="form-edit-wisata">@csrf<input type="hidden" name="id" id="edit-wisata-id"><div class="fg"><label>Nama</label><input type="text" name="judul" id="edit-wisata-judul" required></div><div class="fg"><label>Lokasi</label><input type="text" name="lokasi" id="edit-wisata-lokasi"></div><div class="fg"><label>Deskripsi</label><textarea name="deskripsi" id="edit-wisata-deskripsi"></textarea></div><div class="fg"><label>Harga</label><input type="number" name="harga" id="edit-wisata-harga" required></div><button type="submit" class="btn-sub">Update →</button></form></div></div>

<div class="ov" id="ov-hapus" onclick="closeBg(event,'ov-hapus')"><div class="modal"><div class="modal-h"><div class="modal-t">Konfirmasi Hapus</div><button class="modal-x" onclick="closeOv('ov-hapus')">✕</button></div><p class="confirm-p">Yakin ingin menghapus <strong id="hapus-nama"></strong>?</p><div class="confirm-acts"><button class="btn-cancel" onclick="closeOv('ov-hapus')">Batal</button><form id="f-hapus" method="POST" style="flex:1">@csrf<button type="submit" class="btn-del">Ya, Hapus</button></form></div></div></div>

<script>
const API_URL = 'http://localhost:5000/api';
let token = '{{ session('agen_token') }}';
let currentDeleteId = null;
let currentDeleteType = null;

async function apiCall(endpoint, method = 'GET', data = null) {
    const options = { method, headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' } };
    if (data) options.body = JSON.stringify(data);
    const res = await fetch(`${API_URL}${endpoint}`, options);
    return res.json();
}

async function loadData() {
    try {
        const [trips, wisata, bookings] = await Promise.all([
            apiCall('/agen/trips'), apiCall('/agen/wisata'), apiCall('/agen/bookings')
        ]);
        const tripsArr = Array.isArray(trips) ? trips : [];
        const wisataArr = Array.isArray(wisata) ? wisata : [];
        const bookingsArr = Array.isArray(bookings) ? bookings : [];
        
        document.getElementById('stat-trips').textContent = tripsArr.length;
        document.getElementById('stat-wisata').textContent = wisataArr.length;
        document.getElementById('stat-bookings').textContent = bookingsArr.length;
        document.getElementById('booking-badge').textContent = bookingsArr.length;
        
        let totalRevenue = 0;
        bookingsArr.forEach(b => { if (b.STATUS === 'confirmed' || b.STATUS === 'done') totalRevenue += Number(b.HARGA || 0); });
        document.getElementById('stat-revenue').innerHTML = `Rp ${totalRevenue.toLocaleString('id-ID')}`;
        document.getElementById('total-revenue').innerHTML = `Rp ${totalRevenue.toLocaleString('id-ID')}`;
        
        // Render Trips
        const tripsHtml = tripsArr.length ? tripsArr.map(t => `<div class="card"><div class="card-head"><div class="card-id">#${t.ID}</div><div class="card-type">Trip</div><div class="card-title">${t.JUDUL}</div><div class="card-price">Rp ${Number(t.HARGA).toLocaleString('id-ID')}</div></div><div class="card-body"><div class="card-desc">${t.DESKRIPSI || 'Tidak ada deskripsi'}</div><div class="card-acts"><button class="btn-e" onclick="editTrip(${t.ID}, '${t.JUDUL.replace(/'/g, "\\'")}', '${(t.DESKRIPSI || '').replace(/'/g, "\\'")}', ${t.HARGA})">✏️ Edit</button><button class="btn-d" onclick="openHapus(${t.ID}, '${t.JUDUL.replace(/'/g, "\\'")}', 'trip')">🗑️ Hapus</button></div></div></div>`).join('') : '<div class="empty"><div class="empty-ic">🗺️</div><div class="empty-t">Belum ada trip</div><button class="btn-add" onclick="openOv(\'ov-trip\')">+ Tambah Trip</button></div>';
        document.getElementById('trips-list').innerHTML = tripsHtml;
        
        // Render Wisata
        const wisataHtml = wisataArr.length ? wisataArr.map(w => `<div class="card"><div class="card-head wisata"><div class="card-id">#${w.ID}</div><div class="card-type">Wisata</div><div class="card-title">${w.JUDUL}</div><div class="card-price">📍 ${w.LOKASI || '-'}</div></div><div class="card-body"><div class="card-desc">${w.DESKRIPSI || 'Tidak ada deskripsi'}</div><div class="card-meta">💰 Rp ${Number(w.HARGA).toLocaleString('id-ID')}</div><div class="card-acts"><button class="btn-e" onclick="editWisata(${w.ID}, '${w.JUDUL.replace(/'/g, "\\'")}', '${(w.LOKASI || '').replace(/'/g, "\\'")}', '${(w.DESKRIPSI || '').replace(/'/g, "\\'")}', ${w.HARGA})">✏️ Edit</button><button class="btn-d" onclick="openHapus(${w.ID}, '${w.JUDUL.replace(/'/g, "\\'")}', 'wisata')">🗑️ Hapus</button></div></div></div>`).join('') : '<div class="empty"><div class="empty-ic">🏝️</div><div class="empty-t">Belum ada wisata</div><button class="btn-add" onclick="openOv(\'ov-wisata\')">+ Tambah Wisata</button></div>';
        document.getElementById('wisata-list').innerHTML = wisataHtml;
        
        // Render Bookings
        const bookingsHtml = bookingsArr.length ? bookingsArr.map(b => `<div class="bk-row"><div><div class="bk-title">${b.ITEM_NAME || '-'}</div><div class="bk-meta">👤 ${b.USER_NAME || 'User'} • 💰 Rp ${Number(b.HARGA).toLocaleString('id-ID')}</div></div><span class="bk-st ${b.STATUS}">${b.STATUS}</span></div>`).join('') : '<div class="empty"><div class="empty-ic">📋</div><div class="empty-t">Belum ada booking</div></div>';
        document.getElementById('bookings-list').innerHTML = bookingsHtml;
        document.getElementById('recent-bookings').innerHTML = bookingsArr.slice(0,5).map(b => `<div class="bk-row"><div><div class="bk-title">${b.ITEM_NAME || '-'}</div><div class="bk-meta">👤 ${b.USER_NAME || 'User'}</div></div><span class="bk-st ${b.STATUS}">${b.STATUS}</span></div>`).join('') || '<div class="empty">Belum ada booking</div>';
        
        // Render Revenue Table
        const revenueHtml = bookingsArr.filter(b => b.STATUS === 'confirmed' || b.STATUS === 'done').map(b => `<tr><td>${b.ITEM_NAME || '-'}</td><td>${b.USER_NAME || 'User'}</td><td>${b.CREATED_AT ? new Date(b.CREATED_AT).toLocaleDateString('id-ID') : '-'}</td><td class="rev-pos">+ Rp ${Number(b.HARGA).toLocaleString('id-ID')}</td></tr>`).join('');
        document.getElementById('revenue-table').innerHTML = revenueHtml || '<tr><td colspan="4" class="empty">Belum ada transaksi</td></tr>';
    } catch(e) { console.error(e); }
}

// Tab functions
const tabCfg = { dashboard:{title:'Dashboard',sub:'Ringkasan aktivitas agen',btn:null}, trip:{title:'Trip Saya',sub:'Kelola paket trip',btn:'Tambah Trip',ov:'ov-trip'}, wisata:{title:'Wisata Saya',sub:'Kelola destinasi wisata',btn:'Tambah Wisata',ov:'ov-wisata'}, booking:{title:'Booking Masuk',sub:'Booking dari user',btn:null}, penghasilan:{title:'Pendapatan',sub:'Rekap pendapatan',btn:null}, akun:{title:'Akun Saya',sub:'Kelola informasi akun',btn:null} };
function showTab(name, el) {
    document.querySelectorAll('.panel').forEach(p=>p.classList.remove('active'));
    document.querySelectorAll('.sb-a').forEach(t=>t.classList.remove('active'));
    document.getElementById('panel-'+name).classList.add('active');
    if(el) el.classList.add('active');
    const cfg = tabCfg[name];
    if(cfg){
        document.getElementById('tb-title').textContent = cfg.title;
        document.getElementById('tb-sub').textContent = cfg.sub;
        const btn = document.getElementById('btn-global');
        if(cfg.btn){ btn.style.display='flex'; btn.innerHTML=`<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>${cfg.btn}`; btn.onclick=()=>openOv(cfg.ov); }
        else btn.style.display='none';
    }
}

function openOv(id){ document.getElementById(id).classList.add('open'); }
function closeOv(id){ document.getElementById(id).classList.remove('open'); }
function closeBg(e,id){ if(e.target===document.getElementById(id)) closeOv(id); }

function openHapus(id, nama, type){ currentDeleteId = id; currentDeleteType = type; document.getElementById('hapus-nama').textContent = nama; document.getElementById('f-hapus').action = `/${type}/hapus/${id}`; openOv('ov-hapus'); }

function editTrip(id, judul, desc, harga){ document.getElementById('edit-trip-id').value = id; document.getElementById('edit-trip-judul').value = judul; document.getElementById('edit-trip-deskripsi').value = desc; document.getElementById('edit-trip-harga').value = harga; openOv('ov-edit-trip'); }
function editWisata(id, judul, lokasi, desc, harga){ document.getElementById('edit-wisata-id').value = id; document.getElementById('edit-wisata-judul').value = judul; document.getElementById('edit-wisata-lokasi').value = lokasi; document.getElementById('edit-wisata-deskripsi').value = desc; document.getElementById('edit-wisata-harga').value = harga; openOv('ov-edit-wisata'); }

// Form submits
document.getElementById('form-tambah-trip')?.addEventListener('submit', async (e) => { e.preventDefault(); const form = e.target; const res = await fetch('/trip/tambah', { method:'POST', body:new FormData(form), headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} }); if(res.ok) location.reload(); });
document.getElementById('form-edit-trip')?.addEventListener('submit', async (e) => { e.preventDefault(); const form = e.target; const res = await fetch('/trip/edit', { method:'POST', body:new FormData(form), headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} }); if(res.ok) location.reload(); });
document.getElementById('form-tambah-wisata')?.addEventListener('submit', async (e) => { e.preventDefault(); const form = e.target; const res = await fetch('/wisata/tambah', { method:'POST', body:new FormData(form), headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} }); if(res.ok) location.reload(); });
document.getElementById('form-edit-wisata')?.addEventListener('submit', async (e) => { e.preventDefault(); const form = e.target; const res = await fetch('/wisata/edit', { method:'POST', body:new FormData(form), headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} }); if(res.ok) location.reload(); });
document.getElementById('form-update-akun')?.addEventListener('submit', async (e) => { e.preventDefault(); const form = e.target; const res = await fetch('/agen/akun/update', { method:'POST', body:new FormData(form), headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} }); if(res.ok) location.reload(); });

loadData();
</script>
</body>
</html>