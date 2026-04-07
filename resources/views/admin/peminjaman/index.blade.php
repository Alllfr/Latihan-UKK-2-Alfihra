@extends('layouts.admin')

@section('title')
Peminjaman
@endsection

@section('content')

<a href="{{ route('admin.peminjaman.create') }}" class="btn" style="margin-bottom:12px;">➕ Tambah Peminjaman</a>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>Siswa</th>
<th>Buku</th>
<th>Status</th>
<th>Tanggal Pinjam</th>
<th>Target Kembali</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($peminjamans as $p)
<tr>
<td>{{ $p->user->name }}</td>
<td>{{ $p->buku->judul_buku }}</td>
<td>{{ $p->status }}</td>
<td>{{ $p->tanggal_pinjam }}</td>
<td>{{ $p->target_pengembalian }}</td>
<td>
@if($p->status=='Menunggu')
<form method="POST" action="{{ route('admin.peminjaman.approve',$p->id_peminjaman) }}" style="display:inline;">
@csrf
@method('PATCH')
<button class="btn">✓ Setujui</button>
</form>
@endif
<form method="POST" action="{{ route('admin.peminjaman.destroy',$p->id_peminjaman) }}" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn">🗑️ Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<div style="margin-top:12px;">
{{ $peminjamans->links() }}
</div>

@endsection