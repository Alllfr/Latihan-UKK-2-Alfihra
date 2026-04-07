@extends('layouts.admin')

@section('title')
Data Siswa
@endsection

@section('content')

<a href="{{ route('admin.siswa.create') }}" class="btn" style="margin-bottom:12px;">➕ Tambah Siswa</a>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Status Akun</th>
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
<td>
<a href="{{ route('admin.siswa.edit', $s) }}" class="btn">✏️ Edit</a>
<form method="POST" action="{{ route('admin.siswa.destroy', $s) }}" style="display:inline;">
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
{{ $siswas->links() }}
</div>

@endsection