@extends('layouts.admin')

@section('title','Edit Peminjaman')

@section('content')

<style>
*{box-sizing:border-box}
:root{--pink:#f9a8d4;--blue:#a5d8ff;--mint:#a7f3d0;--border:#e5e7eb;--muted:#9ca3af}
.bg-shapes{position:fixed;inset:0;z-index:-1}
.shape{position:absolute;border-radius:50%;opacity:.35;animation:float linear infinite}
.shape-1{width:320px;height:320px;background:var(--pink);top:-80px;left:-80px}
.shape-2{width:200px;height:200px;background:var(--blue);bottom:-60px;right:-60px}
@keyframes float{0%{transform:translateY(0)}50%{transform:translateY(-20px)}100%{transform:translateY(0)}}
.page-wrap{display:flex;justify-content:center;padding:40px}
.card{max-width:520px;width:100%;background:#fff;border-radius:20px;padding:32px;box-shadow:0 10px 30px rgba(0,0,0,.08);display:flex;flex-direction:column;gap:14px}
.label{font-size:13px;font-weight:600;margin-bottom:6px;display:block}
.input-wrap{position:relative}
.icon{position:absolute;left:12px;top:50%;transform:translateY(-50%)}
.input,select.input{width:100%;height:42px;padding:10px 12px 10px 38px;border-radius:10px;border:1.5px solid var(--border)}
.btn{width:100%;padding:12px;border:none;border-radius:12px;background:linear-gradient(135deg,#fbcfe8,#a5d8ff)}
</style>

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
</div>

<div class="page-wrap">
<div class="card">

<div style="text-align:center;font-weight:700;font-size:20px;">✏️ Edit Peminjaman</div>

<form method="POST" action="{{ route('admin.peminjaman.update',$peminjaman) }}" id="form">
@csrf
@method('PATCH')

<label class="label">Siswa</label>
<div class="input-wrap">
<span class="icon">👤</span>
<select name="user_id" class="input">
@foreach($siswas as $s)
<option value="{{ $s->id }}" {{ $peminjaman->user_id==$s->id?'selected':'' }}>
{{ $s->name }} | {{ $s->kelas }}
</option>
@endforeach
</select>
</div>

<label class="label">Buku</label>
<div class="input-wrap">
<span class="icon">📚</span>
<select name="id_buku" class="input">
@foreach($bukus as $b)
<option value="{{ $b->id_buku }}" {{ $peminjaman->id_buku==$b->id_buku?'selected':'' }}>
{{ $b->judul_buku }}
</option>
@endforeach
</select>
</div>

<label class="label">Tanggal Pinjam</label>
<div class="input-wrap">
<span class="icon">📅</span>
<input type="date" name="tanggal_pinjam" class="input" value="{{ $peminjaman->tanggal_pinjam }}">
</div>

<label class="label">Target Pengembalian</label>
<div class="input-wrap">
<span class="icon">⏳</span>
<input type="date" name="target_pengembalian" class="input" value="{{ $peminjaman->target_pengembalian }}">
</div>

<button class="btn" id="btn">Update</button>

</form>
</div>
</div>

<script>
document.getElementById('form').addEventListener('submit',function(){
let b=document.getElementById('btn');b.disabled=true;b.innerHTML='⏳ Memproses...'
})
</script>

@endsection