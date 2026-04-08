@extends('layouts.admin')

@section('title','Tambah Siswa')

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
.shape-3{width:140px;height:140px;background:var(--mint);top:60%;left:10%}
.shape-4{width:100px;height:100px;background:var(--yellow);top:20%;right:12%}
.shape-5{width:80px;height:80px;background:var(--purple);bottom:20%;left:40%}

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

.input,select.input,input[type="password"].input{
width:100%;height:42px;padding:10px 12px 10px 38px;
border-radius:10px;
border:2px solid transparent;
background:
linear-gradient(#fff,#fff) padding-box,
linear-gradient(135deg,var(--pink),var(--blue)) border-box;
font-size:14px;
}

.input:focus{
outline:none;
box-shadow:0 0 0 3px rgba(165,216,255,0.25);
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

.error{
background:#fff1f2;border:1px solid #fecdd3;
color:#e11d48;padding:10px;border-radius:10px;font-size:13px;
}
</style>

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>
<div class="shape shape-4"></div>
<div class="shape shape-5"></div>
</div>

<div class="page-wrap">
<div class="card">

<div class="title">👨‍🎓 Tambah Siswa</div>
<div class="subtitle">Masukkan data siswa baru</div>

@if ($errors->any())
<div class="error">⚠️ {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.siswa.store') }}" id="form">
@csrf

<div class="form-group">
<label class="label">Nama</label>
<div class="input-wrap">
<span class="icon">👤</span>
<input class="input" name="name">
</div>
</div>

<div class="form-group">
<label class="label">NIS</label>
<div class="input-wrap">
<span class="icon">🆔</span>
<input class="input" name="nis">
</div>
</div>

<div class="form-group">
<label class="label">Kelas</label>
<div class="input-wrap">
<span class="icon">🏫</span>
<input class="input" name="kelas">
</div>
</div>

<div class="form-group">
<label class="label">Status Akun</label>
<div class="input-wrap">
<span class="icon">📊</span>
<select name="status_akun" class="input">
<option value="Aktif">Aktif</option>
<option value="Nonaktif">Nonaktif</option>
</select>
</div>
</div>

<div class="form-group">
<label class="label">Password</label>
<div class="input-wrap">
<span class="icon">🔒</span>
<input type="password" name="password" class="input">
</div>
</div>

<div class="actions">
<a href="{{ route('admin.siswa.index') }}" class="btn-cancel">Batal</a>
<button class="btn" id="btn">💾 Simpan</button>
</div>

</form>

</div>
</div>

<script>
document.getElementById('form').addEventListener('submit',function(){
let b=document.getElementById('btn')
b.disabled=true
b.innerHTML='⏳ Memproses...'
})
</script>

@endsection