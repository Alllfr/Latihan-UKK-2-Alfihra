@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-content">

@if(session('success'))
<div class="alert-success">
✅ {{ session('success') }}
</div>
@endif


<div class="stat-grid">

<div class="stat-card">
<div class="stat-icon pink">📚</div>
<div>
<div class="stat-val">{{ $totalBuku }}</div>
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

<span class="section-title">
⏳ Permintaan Menunggu
</span>

<a href="{{ route('admin.peminjaman.index') }}"
class="btn-sm btn-ghost">

Lihat Semua

</a>

</div>


<div class="table-wrap">

@if($menunggu->isEmpty())

<div style="padding:40px;text-align:center;color:var(--muted)">
Tidak ada permintaan menunggu
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

<td>
{{ \Illuminate\Support\Str::limit($p->buku->judul_buku, 28) }}
</td>

<td>

<form method="POST"
action="{{ route('admin.peminjaman.approve', $p->id_peminjaman) }}">

@csrf
@method('PATCH')

<button type="submit"
class="btn-sm btn-primary">

✓ Setujui

</button>

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

<span class="section-title">
📋 Dipinjam Terbaru
</span>

<a href="{{ route('admin.peminjaman.index') }}"
class="btn-sm btn-ghost">

Lihat Semua

</a>

</div>


<div class="table-wrap">

@if($dipinjam->isEmpty())

<div style="padding:40px;text-align:center;color:var(--muted)">
Belum ada peminjaman aktif
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

<td>
{{ \Illuminate\Support\Str::limit($p->buku->judul_buku, 24) }}
</td>

<td>

@php
$tgl = \Carbon\Carbon::parse($p->target_pengembalian);
@endphp

{{ $tgl->format('d M') }}

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

@endsection