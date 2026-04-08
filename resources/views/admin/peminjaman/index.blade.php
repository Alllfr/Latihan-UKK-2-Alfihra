@extends('layouts.admin')

@section('title','Data Peminjaman')

@section('content')

<style>
.table-wrap{overflow-x:auto;background:#fff;border-radius:20px;padding:20px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:left;font-size:14px}
th{background:#f9fafb;font-weight:700}
tr:not(:last-child){border-bottom:1px solid #eee}

.topbar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.input{padding:8px 10px;border-radius:10px;border:1px solid #e5e7eb;font-size:13px}

.badge{padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600}
.badge-yellow{background:#fef9c3}
.badge-blue{background:#e0f2fe}
.badge-green{background:#dcfce7}

.actions{display:flex;gap:6px}

.btn{
padding:6px 12px;border:none;border-radius:10px;
background:linear-gradient(135deg,#fbcfe8,#a5d8ff);
cursor:pointer;font-size:12px;font-weight:600;text-decoration:none;color:#111;
}

.btn-danger{background:#fee2e2;color:#991b1b}
</style>

<form method="GET" class="topbar">

<input type="text" name="search" class="input"
placeholder="Cari nama / NIS / buku"
value="{{ request('search') }}">

<select name="kelas" class="input">
<option value="">Semua Kelas</option>
<option value="X" {{ request('kelas')=='X'?'selected':'' }}>X</option>
<option value="XI" {{ request('kelas')=='XI'?'selected':'' }}>XI</option>
<option value="XII" {{ request('kelas')=='XII'?'selected':'' }}>XII</option>
</select>

<select name="bulan" class="input">
<option value="">Semua Bulan</option>
@for($i=1;$i<=12;$i++)
<option value="{{ $i }}" {{ request('bulan')==$i?'selected':'' }}>
{{ \Carbon\Carbon::create()->month($i)->format('F') }}
</option>
@endfor
</select>

<select name="sort" class="input">
<option value="">Urutkan</option>
<option value="baru" {{ request('sort')=='baru'?'selected':'' }}>Terbaru</option>
<option value="lama" {{ request('sort')=='lama'?'selected':'' }}>Terlama</option>
</select>

<button class="btn">🔍</button>

</form>

<a href="{{ route('admin.peminjaman.create') }}" class="btn" style="margin-bottom:14px;">
➕ Tambah Peminjaman
</a>

<div class="table-wrap">
<table>

<thead>
<tr>
<th>Siswa</th>
<th>Buku</th>
<th>Tanggal</th>
<th>Target</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($peminjamans as $p)

<tr>

<td>
{{ $p->user->name }}<br>
<span style="font-size:12px;color:#9ca3af;">{{ $p->user->nis }}</span>
</td>

<td>{{ $p->buku->judul_buku }}</td>

<td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>

<td>
@php $tgl=\Carbon\Carbon::parse($p->target_pengembalian); @endphp
<span style="color:{{ $tgl->isPast() && $p->status!='Sudah Kembali'?'#e11d48':'inherit' }}">
{{ $tgl->format('d M Y') }}
</span>
</td>

<td>
@if($p->status=='Menunggu')
<span class="badge badge-yellow">⏳ Menunggu</span>
@elseif($p->status=='Dipinjam')
<span class="badge badge-blue">📖 Dipinjam</span>
@else
<span class="badge badge-green">✅ Kembali</span>
@endif
</td>

<td class="actions">

<a href="{{ route('admin.peminjaman.edit',$p) }}" class="btn">✏️</a>

<form method="POST" action="{{ route('admin.peminjaman.destroy',$p) }}">
@csrf
@method('DELETE')
<button class="btn btn-danger">🗑️</button>
</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" style="text-align:center;padding:30px;color:#9ca3af;">
Tidak ada data
</td>
</tr>

@endforelse

</tbody>

</table>
</div>

<div style="margin-top:14px;">
{{ $peminjamans->links() }}
</div>

@endsection