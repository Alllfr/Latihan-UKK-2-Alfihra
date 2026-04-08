@extends('layouts.admin')

@section('title','Tambah Peminjaman')

@section('content')

<style>
*{box-sizing:border-box}
:root{
--pink:#f9a8d4;--blue:#a5d8ff;--mint:#a7f3d0;
--yellow:#fde68a;--purple:#c4b5fd;
--text:#374151;--muted:#9ca3af;
--border:#e5e7eb;--white:#ffffff;
}

.bg-shapes{position:fixed;inset:0;z-index:-1}
.shape{position:absolute;border-radius:50%;opacity:.35;animation:float linear infinite}
.shape-1{width:320px;height:320px;background:var(--pink);top:-80px;left:-80px}
.shape-2{width:200px;height:200px;background:var(--blue);bottom:-60px;right:-60px}

@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-20px)}
100%{transform:translateY(0)}
}

.page-wrap{display:flex;justify-content:center;padding:40px 20px}

.card{
width:100%;max-width:520px;background:white;border-radius:20px;
padding:32px;box-shadow:0 10px 30px rgba(0,0,0,0.08);
display:flex;flex-direction:column;gap:14px;
}

.title{text-align:center;font-size:20px;font-weight:700}
.subtitle{text-align:center;font-size:13px;color:var(--muted);margin-bottom:10px}

.form-group{width:100%}
.label{font-size:13px;font-weight:600;margin-bottom:6px;display:block}

.input-wrap{position:relative}
.icon{position:absolute;left:12px;top:50%;transform:translateY(-50%)}

.input,select.input,input[type="date"].input{
width:100%;height:42px;padding:10px 12px 10px 38px;
border-radius:10px;
border:2px solid transparent;
background:
linear-gradient(#fff,#fff) padding-box,
linear-gradient(135deg,var(--pink),var(--blue)) border-box;
font-size:14px;
}

.actions{display:flex;gap:10px;margin-top:10px}

.btn{
flex:1;padding:12px;border:none;border-radius:12px;
background:linear-gradient(135deg,#fbcfe8,#a5d8ff);
font-weight:700;cursor:pointer;
}

.btn-cancel{
flex:1;text-align:center;padding:12px;border-radius:12px;
background:#e5e7eb;color:#374151;font-weight:700;text-decoration:none;
}
</style>

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
</div>

<div class="page-wrap">
<div class="card">

<div class="title">📚 Tambah Peminjaman</div>
<div class="subtitle">Pilih siswa dan buku</div>

<form method="POST" action="{{ route('admin.peminjaman.store') }}">
@csrf

<div class="form-group">
<label class="label">Siswa (NIS)</label>
<div class="input-wrap">
<span class="icon">👤</span>
<select name="user_id" class="input">
@foreach($siswas as $s)
<option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="form-group">
<label class="label">Buku</label>
<div class="input-wrap">
<span class="icon">📖</span>
<select name="id_buku" class="input">
@foreach($bukus as $b)
<option value="{{ $b->id_buku }}">{{ $b->judul_buku }} ({{ $b->stok }})</option>
@endforeach
</select>
</div>
</div>

<div class="form-group">
<label class="label">Tanggal Pinjam</label>
<div class="input-wrap">
<span class="icon">📅</span>
<input type="date" name="tanggal_pinjam" class="input">
</div>
</div>

<div class="form-group">
<label class="label">Target Kembali</label>
<div class="input-wrap">
<span class="icon">⏳</span>
<input type="date" name="target_pengembalian" class="input">
</div>
</div>

<div class="actions">
<a href="{{ route('admin.peminjaman.index') }}" class="btn-cancel">Batal</a>
<button class="btn">💾 Simpan</button>
</div>

</form>

</div>
</div>

@endsection