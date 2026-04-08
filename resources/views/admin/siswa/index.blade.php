@extends('layouts.admin')

@section('title','Data Siswa')

@section('content')

<style>
.table-wrap{overflow-x:auto;background:#fff;border-radius:20px;padding:20px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;text-align:left;font-size:14px}
th{background:#f9fafb;font-weight:700}

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
<input type="text" name="search" class="input" placeholder="Cari siswa..." value="{{ request('search') }}">

<select name="kelas" class="input">
<option value="">Semua Kelas</option>
<option value="X">X</option>
<option value="XI">XI</option>
<option value="XII">XII</option>
</select>

<select name="sort" class="input">
<option value="">Sort</option>
<option value="az">A-Z</option>
<option value="za">Z-A</option>
<option value="baru">Terbaru</option>
<option value="lama">Terlama</option>
</select>

<button class="btn">🔍</button>
</form>

<a href="{{ route('admin.siswa.create') }}" class="btn" style="margin-bottom:14px;">➕ Tambah Siswa</a>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach($siswas as $s)
<tr>
<td>{{ $s->nis }}</td>
<td>{{ $s->name }}</td>
<td>{{ $s->kelas }}</td>
<td>{{ $s->status_akun }}</td>

<td class="actions">
<a href="{{ route('admin.siswa.edit',$s) }}" class="btn">✏️</a>
<form method="POST" action="{{ route('admin.siswa.destroy',$s) }}">
@csrf @method('DELETE')
<button class="btn btn-danger">🗑️</button>
</form>
</td>

</tr>
@endforeach
</tbody>
</table>
</div>

{{ $siswas->links() }}

@endsection