@extends('layouts.admin')

@section('title','Tambah Buku')

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

.input,select.input,input[type="file"].input,input[type="date"].input,input[type="number"].input{
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

select.input{appearance:none}
input[type="file"].input{padding:6px 12px 6px 38px}

.preview{margin-top:10px;display:flex;justify-content:center}
.preview img{
width:120px;height:160px;object-fit:cover;
border-radius:10px;border:1px solid var(--border);display:none;
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

<div class="title">📚 Tambah Buku</div>
<div class="subtitle">Masukkan data buku baru</div>

@if ($errors->any())
<div class="error">⚠️ {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data" id="form">
@csrf

<div class="form-group">
<label class="label">ID Buku</label>
<div class="input-wrap">
<span class="icon">🆔</span>
<input class="input" name="id_buku">
</div>
</div>

<div class="form-group">
<label class="label">Judul Buku</label>
<div class="input-wrap">
<span class="icon">📖</span>
<input class="input" name="judul_buku">
</div>
</div>

<div class="form-group">
<label class="label">Pengarang</label>
<div class="input-wrap">
<span class="icon">✍️</span>
<input class="input" name="pengarang">
</div>
</div>

<div class="form-group">
<label class="label">Kategori</label>
<div class="input-wrap">
<span class="icon">🏷️</span>
<select class="input" id="kategoriSelect">
<option value="">Pilih Kategori</option>
<option value="Fiksi">Fiksi</option>
<option value="Non-Fiksi">Non-Fiksi</option>
<option value="__lainnya">+ Lainnya</option>
</select>
<input type="text" id="kategoriInput" class="input" style="display:none;margin-top:8px" placeholder="Tulis kategori baru">
<input type="hidden" name="kategori" id="kategoriFinal">
</div>
</div>

<div class="form-group">
<label class="label">Penerbit</label>
<div class="input-wrap">
<span class="icon">🏢</span>
<input class="input" name="penerbit">
</div>
</div>

<div class="form-group">
<label class="label">Tanggal Register</label>
<div class="input-wrap">
<span class="icon">📅</span>
<input class="input" type="date" name="tanggal_register">
</div>
</div>

<div class="form-group">
<label class="label">Stok</label>
<div class="input-wrap">
<span class="icon">📦</span>
<input class="input" type="number" name="stok">
</div>
</div>

<div class="form-group">
<label class="label">Foto</label>
<div class="input-wrap">
<span class="icon">🖼️</span>
<input class="input" type="file" name="foto" id="fotoInput">
</div>
<div class="preview">
<img id="previewImg">
</div>
</div>

<div class="actions">
<a href="{{ route('admin.buku.index') }}" class="btn-cancel">Batal</a>
<button class="btn" id="btnSubmit">💾 Simpan</button>
</div>

</form>

</div>
</div>

<script>
const select = document.getElementById('kategoriSelect')
const input  = document.getElementById('kategoriInput')
const final  = document.getElementById('kategoriFinal')

select.addEventListener('change',function(){
if(this.value==='__lainnya'){
input.style.display='block'
input.focus()
final.value=''
}else{
input.style.display='none'
final.value=this.value
}
})

input.addEventListener('input',function(){
final.value=this.value
})

let savedKategori = JSON.parse(localStorage.getItem('kategori_buku')||'[]')

savedKategori.forEach(k=>{
let opt=document.createElement('option')
opt.value=k
opt.textContent=k
select.insertBefore(opt,select.lastElementChild)
})

document.getElementById('form').addEventListener('submit',function(){
const btn=document.getElementById('btnSubmit')
btn.disabled=true
btn.innerHTML='⏳ Memproses...'

if(input.value){
if(!savedKategori.includes(input.value)){
savedKategori.push(input.value)
localStorage.setItem('kategori_buku',JSON.stringify(savedKategori))
}
}
})

const fotoInput=document.getElementById('fotoInput')
const preview=document.getElementById('previewImg')

fotoInput.addEventListener('change',function(e){
const file=e.target.files[0]
if(file){
const reader=new FileReader()
reader.onload=function(e){
preview.src=e.target.result
preview.style.display='block'
}
reader.readAsDataURL(file)
}
})
</script>

@endsection