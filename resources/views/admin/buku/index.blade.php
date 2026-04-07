@extends('layouts.admin')

@section('title')
Data Buku
@endsection

@section('content')

<style>
.table-wrap{overflow-x:auto;background:#fff;border-radius:16px;padding:16px;box-shadow:0 6px 20px rgba(0,0,0,.05)}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:left;font-size:14px}
th{background:#f9fafb;font-weight:600}
tr:not(:last-child){border-bottom:1px solid #eee}
.img-thumb{width:50px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb}
.btn{padding:6px 10px;border:none;border-radius:8px;background:linear-gradient(135deg,#fbcfe8,#a5d8ff);cursor:pointer;font-size:12px}
</style>

<a href="{{ route('admin.buku.create') }}" class="btn" style="margin-bottom:12px;">➕ Tambah Buku</a>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>Foto</th>
<th>ID Buku</th>
<th>Judul</th>
<th>Pengarang</th>
<th>Kategori</th>
<th>Penerbit</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach($bukus as $b)
<tr>

<td>
@if($b->foto)
<img src="{{ asset('storage/'.$b->foto) }}" class="img-thumb">
@else
<span style="font-size:12px;color:#9ca3af;">-</span>
@endif
</td>

<td>{{ $b->id_buku }}</td>
<td>{{ $b->judul_buku }}</td>
<td>{{ $b->pengarang }}</td>
<td>{{ $b->kategori }}</td>
<td>{{ $b->penerbit }}</td>
<td>{{ $b->stok }}</td>

<td>
<a href="{{ route('admin.buku.edit', $b) }}" class="btn">✏️</a>

<form method="POST" action="{{ route('admin.buku.destroy', $b) }}" style="display:inline;">
@csrf
@method('DELETE')
<button class="btn">🗑️</button>
</form>
</td>

</tr>
@endforeach
</tbody>

</table>
</div>

<div style="margin-top:12px;">
{{ $bukus->links() }}
</div>

@endsection