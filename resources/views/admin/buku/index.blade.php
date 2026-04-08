@extends('layouts.admin')

@section('title','Data Buku')

@section('content')

<style>
.table-wrap{overflow-x:auto;background:#fff;border-radius:20px;padding:20px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:left;font-size:14px}
th{background:#f9fafb;font-weight:700}
tr:not(:last-child){border-bottom:1px solid #eee}
.img-thumb{width:50px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb}

.topbar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.input{padding:8px 10px;border-radius:10px;border:1px solid #e5e7eb;font-size:13px}

.actions{display:flex;gap:6px}

.btn{
padding:6px 12px;border:none;border-radius:10px;
background:linear-gradient(135deg,#fbcfe8,#a5d8ff);
cursor:pointer;font-size:12px;font-weight:600;text-decoration:none;color:#111;
}

.btn-danger{background:#fee2e2;color:#991b1b}
</style>

<form method="GET" class="topbar">
<input type="text" name="search" class="input" placeholder="Cari buku..." value="{{ request('search') }}">

<select name="kategori" class="input">
<option value="">Semua Genre</option>
@foreach($kategoris as $k)
<option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
@endforeach
</select>

<select name="sort" class="input">
<option value="">Sort</option>
<option value="az" {{ request('sort')=='az'?'selected':'' }}>A-Z</option>
<option value="za" {{ request('sort')=='za'?'selected':'' }}>Z-A</option>
<option value="baru" {{ request('sort')=='baru'?'selected':'' }}>Terbaru</option>
<option value="lama" {{ request('sort')=='lama'?'selected':'' }}>Terlama</option>
</select>

<button class="btn">🔍</button>
</form>

<a href="{{ route('admin.buku.create') }}" class="btn" style="margin-bottom:14px;">➕ Tambah Buku</a>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>Foto</th>
<th>ID</th>
<th>Judul</th>
<th>Pengarang</th>
<th>Kategori</th>
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
<td>{{ $b->stok }}</td>

<td class="actions">
<a href="{{ route('admin.buku.edit',$b) }}" class="btn">✏️</a>
<form method="POST" action="{{ route('admin.buku.destroy',$b) }}">
@csrf @method('DELETE')
<button class="btn btn-danger">🗑️</button>
</form>
</td>

</tr>
@endforeach
</tbody>
</table>
</div>

{{ $bukus->links() }}

@endsection