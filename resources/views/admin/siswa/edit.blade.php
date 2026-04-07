@extends('layouts.admin')

@section('title','Edit Siswa')

@section('content')

<style>
*{box-sizing:border-box}
:root{--pink:#f9a8d4;--blue:#a5d8ff;--border:#e5e7eb}
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
.input{width:100%;height:42px;padding:10px 12px 10px 38px;border-radius:10px;border:1.5px solid var(--border)}
.btn{width:100%;padding:12px;border:none;border-radius:12px;background:linear-gradient(135deg,#fbcfe8,#a5d8ff)}
</style>

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
</div>

<div class="page-wrap">
<div class="card">

<div style="text-align:center;font-weight:700;font-size:20px;">✏️ Edit Siswa</div>

<form method="POST" action="{{ route('admin.siswa.update',$siswa) }}" id="form">
@csrf
@method('PATCH')

<label class="label">Nama</label>
<div class="input-wrap"><span class="icon">👤</span><input class="input" name="name" value="{{ $siswa->name }}"></div>

<label class="label">NIS</label>
<div class="input-wrap"><span class="icon">🆔</span><input class="input" name="nis" value="{{ $siswa->nis }}"></div>

<label class="label">Kelas</label>
<div class="input-wrap"><span class="icon">🏫</span><input class="input" name="kelas" value="{{ $siswa->kelas }}"></div>

<label class="label">Status Akun</label>
<div class="input-wrap">
<span class="icon">📊</span>
<select name="status_akun" class="input">
<option value="Aktif" {{ $siswa->status_akun=='Aktif'?'selected':'' }}>Aktif</option>
<option value="Nonaktif" {{ $siswa->status_akun=='Nonaktif'?'selected':'' }}>Nonaktif</option>
</select>
</div>

<label class="label">Password Baru</label>
<div class="input-wrap"><span class="icon">🔒</span><input type="password" name="password" class="input"></div>

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