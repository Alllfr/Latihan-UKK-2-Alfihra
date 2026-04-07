<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Perpustakaan</title>
    <style>
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fadeSlide 0.4s ease both;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.07);
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .stat-icon.pink   { background: #fce7f3; }
        .stat-icon.blue   { background: #e0f2fe; }
        .stat-icon.mint   { background: #d1fae5; }
        .stat-icon.yellow { background: #fef9c3; }

        .stat-val  { font-size: 28px; font-weight: 800; line-height: 1; }
        .stat-label { font-size: 12.5px; color: var(--muted); margin-top: 4px; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .section-title { font-size: 16px; font-weight: 700; }

        .btn-sm {
            padding: 7px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.15s, transform 0.1s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-sm:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-sm:active { transform: translateY(0); }

        .btn-primary { background: linear-gradient(135deg, var(--pink), var(--blue)); color: var(--text); }
        .btn-ghost   { background: var(--bg); color: var(--text); border: 1px solid var(--border); }

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
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
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

        .badge-yellow  { background: #fef9c3; color: #a16207; }
        .badge-blue    { background: #e0f2fe; color: #0369a1; }
        .badge-green   { background: #dcfce7; color: #15803d; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
        }

        .empty-state .e-icon { font-size: 40px; margin-bottom: 10px; }
        .empty-state .e-text { font-size: 14px; }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .stat-grid { grid-template-columns: 1fr 1fr; } }
    </style>
</head>
<body>

@include('partials.sidebar-admin', ['menuBadge' => $totalMenunggu])

<div class="main-wrap" id="mainWrap">
    <div class="topbar">
        <div class="topbar-left">
            <button class="btn-toggle" onclick="toggleSidebar()">☰</button>
            <span class="topbar-title">Dashboard</span>
        </div>
        <div class="topbar-right">
            <span class="topbar-date" id="topbarDate"></span>
        </div>
    </div>

    <div class="page-content">

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon pink">📚</div>
                <div>
                    <div class="stat-val" id="countBuku">{{ $totalBuku }}</div>
                    <div class="stat-label">Total Buku</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">🎓</div>
                <div>
                    <div class="stat-val">{{ $totalSiswa }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon mint">📋</div>
                <div>
                    <div class="stat-val">{{ $totalDipinjam }}</div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">⏳</div>
                <div>
                    <div class="stat-val">{{ $totalMenunggu }}</div>
                    <div class="stat-label">Menunggu Persetujuan</div>
                </div>
            </div>
        </div>

        <div class="two-col">
            <div>
                <div class="section-header">
                    <span class="section-title">⏳ Permintaan Menunggu</span>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn-sm btn-ghost">Lihat Semua</a>
                </div>
                <div class="table-wrap">
                    @if($menunggu->isEmpty())
                        <div class="empty-state">
                            <div class="e-icon">🎉</div>
                            <div class="e-text">Tidak ada permintaan menunggu</div>
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menunggu as $p)
                                <tr>
                                    <td>{{ $p->user->name }}</td>
                                    <td>{{ Str::limit($p->buku->judul_buku, 28) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.peminjaman.approve', $p->id_peminjaman) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-sm btn-primary">✓ Setujui</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div>
                <div class="section-header">
                    <span class="section-title">📋 Dipinjam Terbaru</span>
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn-sm btn-ghost">Lihat Semua</a>
                </div>
                <div class="table-wrap">
                    @if($dipinjam->isEmpty())
                        <div class="empty-state">
                            <div class="e-icon">📭</div>
                            <div class="e-text">Belum ada peminjaman aktif</div>
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Buku</th>
                                    <th>Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dipinjam as $p)
                                <tr>
                                    <td>{{ $p->user->name }}</td>
                                    <td>{{ Str::limit($p->buku->judul_buku, 24) }}</td>
                                    <td>
                                        @php $tgl = \Carbon\Carbon::parse($p->target_pengembalian); @endphp
                                        <span class="badge {{ $tgl->isPast() ? 'badge-red' : ($tgl->diffInDays(now()) <= 2 ? 'badge-yellow' : 'badge-blue') }}">
                                            {{ $tgl->format('d M') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function updateDate() {
        const now = new Date();
        const opts = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
        document.getElementById('topbarDate').textContent = now.toLocaleDateString('id-ID', opts);
    }
    updateDate();
</script>

</body>
</html>