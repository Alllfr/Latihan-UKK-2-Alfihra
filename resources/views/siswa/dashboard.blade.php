<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa — Perpustakaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --pink:   #fbcfe8;
            --blue:   #a5d8ff;
            --mint:   #a7f3d0;
            --yellow: #fde68a;
            --purple: #c4b5fd;
            --text:   #374151;
            --muted:  #9ca3af;
            --border: #e5e7eb;
            --white:  #ffffff;
            --bg:     #f8fafc;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-logo { display: flex; align-items: center; gap: 10px; }

        .topbar-logo .t-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--pink), var(--blue));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .topbar-logo .t-name { font-size: 15px; font-weight: 700; }

        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 99px;
            padding: 5px 14px 5px 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .user-chip .chip-avatar {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--blue));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
        }

        .btn-logout {
            background: #fff1f2;
            color: #e11d48;
            border: none;
            border-radius: 10px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-logout:hover { background: #ffe4e6; }

        /* BOTTOM NAV mobile */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 8px 0 12px;
            z-index: 60;
        }

        .bottom-nav-inner {
            display: flex;
            justify-content: space-around;
        }

        .bn-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            padding: 4px 16px;
            border-radius: 12px;
            transition: color 0.15s, background 0.15s;
        }

        .bn-item .bn-icon { font-size: 20px; }
        .bn-item.active { color: var(--text); background: var(--bg); }

        /* CONTENT */
        .content { padding: 24px; max-width: 900px; margin: 0 auto; }

        .greeting {
            margin-bottom: 24px;
            animation: fadeSlide 0.4s ease;
        }

        .greeting h1 { font-size: 22px; font-weight: 800; }
        .greeting p  { font-size: 13.5px; color: var(--muted); margin-top: 4px; }

        .stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fadeSlide 0.4s ease both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }

        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }

        .stat-card .s-icon { font-size: 28px; margin-bottom: 8px; }
        .stat-card .s-val  { font-size: 26px; font-weight: 800; }
        .stat-card .s-label { font-size: 12px; color: var(--muted); margin-top: 3px; }

        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 28px;
        }

        .qa-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            text-decoration: none;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fadeSlide 0.4s ease both;
        }

        .qa-card:nth-child(1) { animation-delay: 0.2s; }
        .qa-card:nth-child(2) { animation-delay: 0.25s; }

        .qa-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.07); }

        .qa-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .qa-icon.pink   { background: #fce7f3; }
        .qa-icon.blue   { background: #e0f2fe; }

        .qa-title { font-size: 14px; font-weight: 700; }
        .qa-sub   { font-size: 12px; color: var(--muted); margin-top: 3px; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .section-title { font-size: 15px; font-weight: 700; }

        .btn-sm {
            padding: 6px 13px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--text);
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-sm:hover { background: var(--border); }

        .table-wrap {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--bg); border-bottom: 1px solid var(--border); }

        th {
            padding: 11px 16px;
            text-align: left;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 13px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.12s; }
        tbody tr:hover { background: var(--bg); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-yellow { background: #fef9c3; color: #a16207; }
        .badge-blue   { background: #e0f2fe; color: #0369a1; }
        .badge-green  { background: #dcfce7; color: #15803d; }
        .badge-red    { background: #fff1f2; color: #e11d48; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
        }

        .empty-state .e-icon { font-size: 38px; margin-bottom: 8px; }
        .empty-state .e-text { font-size: 13.5px; }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeSlide 0.3s ease;
        }

        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .stat-row { grid-template-columns: 1fr 1fr; }
            .quick-actions { grid-template-columns: 1fr; }
            .topbar .user-chip .chip-name { display: none; }
            .bottom-nav { display: block; }
            .content { padding-bottom: 80px; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-logo">
        <div class="t-icon">📚</div>
        <span class="t-name">Perpustakaan</span>
    </div>
    <div class="topbar-right">
        <div class="user-chip">
            <div class="chip-avatar">👤</div>
            <span class="chip-name">{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="greeting">
        <h1>Halo, {{ Str::before(Auth::user()->name, ' ') }} 👋</h1>
        <p id="greetDate">Selamat datang di Perpustakaan Sekolah</p>
    </div>

    <div class="stat-row">
        <div class="stat-card">
            <div class="s-icon">📋</div>
            <div class="s-val">{{ $totalDipinjam }}</div>
            <div class="s-label">Sedang Dipinjam</div>
        </div>
        <div class="stat-card">
            <div class="s-icon">⏳</div>
            <div class="s-val">{{ $totalMenunggu }}</div>
            <div class="s-label">Menunggu</div>
        </div>
        <div class="stat-card">
            <div class="s-icon">✅</div>
            <div class="s-val">{{ $totalKembali }}</div>
            <div class="s-label">Sudah Kembali</div>
        </div>
    </div>

    <div class="quick-actions">
        <a href="{{ route('siswa.buku.index') }}" class="qa-card">
            <div class="qa-icon pink">➕</div>
            <div>
                <div class="qa-title">Pinjam Buku</div>
                <div class="qa-sub">Cari dan ajukan peminjaman</div>
            </div>
        </a>
        <a href="{{ route('siswa.peminjaman.index') }}" class="qa-card">
            <div class="qa-icon blue">📋</div>
            <div>
                <div class="qa-title">Riwayat Saya</div>
                <div class="qa-sub">Lihat semua peminjaman</div>
            </div>
        </a>
    </div>

    <div class="section-header">
        <span class="section-title">📖 Peminjaman Aktif</span>
        <a href="{{ route('siswa.peminjaman.index') }}" class="btn-sm">Lihat Semua</a>
    </div>

    <div class="table-wrap">
        @if($peminjamans->isEmpty())
            <div class="empty-state">
                <div class="e-icon">📭</div>
                <div class="e-text">Belum ada peminjaman aktif</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $p)
                    <tr>
                        <td>
                            <div style="font-weight:600">{{ Str::limit($p->buku->judul_buku, 30) }}</div>
                            <div style="font-size:12px;color:var(--muted)">{{ $p->buku->pengarang }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>
                            @php $tgl = \Carbon\Carbon::parse($p->target_pengembalian); @endphp
                            <span style="font-weight:500;color:{{ $tgl->isPast() && $p->status !== 'Sudah Kembali' ? '#e11d48' : 'inherit' }}">
                                {{ $tgl->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            @if($p->status === 'Menunggu')
                                <span class="badge badge-yellow">⏳ Menunggu</span>
                            @elseif($p->status === 'Dipinjam')
                                <span class="badge badge-blue">📖 Dipinjam</span>
                            @else
                                <span class="badge badge-green">✅ Kembali</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

<nav class="bottom-nav">
    <div class="bottom-nav-inner">
        <a href="{{ route('siswa.dashboard') }}" class="bn-item active">
            <span class="bn-icon">🏠</span>
            <span>Home</span>
        </a>
        <a href="{{ route('siswa.buku.index') }}" class="bn-item">
            <span class="bn-icon">➕</span>
            <span>Pinjam</span>
        </a>
        <a href="{{ route('siswa.peminjaman.index') }}" class="bn-item">
            <span class="bn-icon">📋</span>
            <span>Riwayat</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display:contents">
            @csrf
            <button type="submit" class="bn-item" style="background:none;border:none;cursor:pointer;font-family:inherit">
                <span class="bn-icon">🚪</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</nav>

<script>
    const now = new Date();
    const opts = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
    document.getElementById('greetDate').textContent = now.toLocaleDateString('id-ID', opts);
</script>

</body>
</html>