@extends('layouts.siswa')

@section('content')
<div style="max-width:1000px;margin:auto;padding:20px;">

    <h2 style="margin-bottom:20px;">📋 Riwayat Peminjaman Saya</h2>

    @if($peminjamans->isEmpty())
        <div style="text-align:center;padding:40px;color:#9ca3af;">
            <div style="font-size:40px;">📭</div>
            <p>Belum ada riwayat peminjaman</p>
        </div>
    @else
        <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th style="padding:12px;text-align:left;">Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas</th>
                        <th>Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $p)
                    <tr style="border-top:1px solid #e5e7eb;">
                        <td style="padding:12px;">
                            <div style="font-weight:600;">
                                {{ $p->buku->judul_buku }}
                            </div>
                            <div style="font-size:12px;color:#9ca3af;">
                                {{ $p->buku->pengarang }}
                            </div>
                        </td>

                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>

                        <td>
                            @php $tgl = \Carbon\Carbon::parse($p->target_pengembalian); @endphp
                            <span style="color:{{ $tgl->isPast() && $p->status !== 'Sudah Kembali' ? '#e11d48' : 'inherit' }}">
                                {{ $tgl->format('d M Y') }}
                            </span>
                        </td>

                        <td>
                            {{ $p->pengembalian->tanggal_kembali ?? '-' }}
                        </td>

                        <td>
                            @if($p->pengembalian)
                                Rp {{ number_format($p->pengembalian->denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($p->status === 'Menunggu')
                                <span style="background:#fef9c3;padding:4px 10px;border-radius:999px;font-size:12px;">⏳ Menunggu</span>
                            @elseif($p->status === 'Dipinjam')
                                <span style="background:#e0f2fe;padding:4px 10px;border-radius:999px;font-size:12px;">📖 Dipinjam</span>
                            @else
                                <span style="background:#dcfce7;padding:4px 10px;border-radius:999px;font-size:12px;">✅ Kembali</span>
                            @endif
                        </td>

                        <td>
                            @if($p->status === 'Dipinjam')
                               <a href="{{ route('siswa.peminjaman.formKembali', $p->id_peminjaman) }}"
                                   style="padding:6px 12px;background:#fde68a;border-radius:8px;font-size:12px;text-decoration:none;color:#000;">
                                    🔄 Kembalikan
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection