@extends('layouts.siswa')

@section('title','Pinjam Buku')

@section('content')

@if(session('error'))
<script>alert("{{ session('error') }}");</script>
@endif

@if(session('success'))
<script>alert("{{ session('success') }}");</script>
@endif

@if($errors->any())
<script>alert("{{ $errors->first() }}");</script>
@endif

<style>
*{box-sizing:border-box}

:root{
--pink:#f9a8d4;
--blue:#a5d8ff;
--mint:#a7f3d0;
--border:#e5e7eb;
--text:#1e293b;
--muted:#64748b;
}

.bg-shapes{position:fixed;inset:0;z-index:-1}
.shape{position:absolute;border-radius:50%;opacity:.35;animation:float 8s linear infinite}
.shape-1{width:320px;height:320px;background:var(--pink);top:-80px;left:-80px}
.shape-2{width:200px;height:200px;background:var(--blue);bottom:-60px;right:-60px}
.shape-3{width:140px;height:140px;background:var(--mint);top:60%;left:10%}

@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-20px)}
100%{transform:translateY(0)}
}

.page-wrap{display:flex;justify-content:center;padding:40px}

.card{
max-width:520px;
width:100%;
background:#fff;
border-radius:20px;
padding:32px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.form-group{
display:flex;
flex-direction:column;
gap:6px;
margin-bottom:16px;
}

.label{
font-size:13px;
font-weight:600;
color:var(--text);
}

.input-wrap{position:relative}

.icon{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
}

.input{
width:100%;
height:42px;
padding:10px 12px 10px 38px;
border-radius:10px;
border:1.5px solid var(--border);
background:#fafafa;
font-size:14px;
}

.input[readonly]{background:#f1f5f9}

.actions{
display:flex;
gap:10px;
margin-top:10px;
}

.btn{
flex:1;
padding:12px;
border:none;
border-radius:12px;
background:linear-gradient(135deg,#fbcfe8,#a5d8ff);
font-weight:600;
cursor:pointer;
}

.btn-cancel{
flex:1;
text-align:center;
padding:12px;
border-radius:12px;
background:#e5e7eb;
color:#374151;
font-weight:600;
text-decoration:none;
}
</style>

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>
</div>

<div class="page-wrap">
<div class="card">

<div style="text-align:center;font-weight:700;font-size:20px;margin-bottom:20px;">
📚 Form Peminjaman
</div>

<form method="POST" action="{{ route('siswa.peminjaman.store') }}" id="form">
@csrf

<input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

<div class="form-group">
<label class="label">NIS</label>
<div class="input-wrap">
<span class="icon">🆔</span>
<input type="text" class="input" value="{{ auth()->user()->nis }}" readonly>
</div>
</div>

<div class="form-group">
<label class="label">Nama</label>
<div class="input-wrap">
<span class="icon">👤</span>
<input type="text" class="input" value="{{ auth()->user()->name }}" readonly>
</div>
</div>

<div class="form-group">
<label class="label">Kelas</label>
<div class="input-wrap">
<span class="icon">🏫</span>
<input type="text" class="input" value="{{ auth()->user()->kelas }}" readonly>
</div>
</div>

<div class="form-group">
<label class="label">Buku Dipilih</label>
<div class="input-wrap">
<span class="icon">📚</span>
<input type="text" class="input"
value="{{ $buku->judul_buku }} (Stok: {{ $buku->stok }})"
readonly>
</div>
</div>

<div class="form-group">
<label class="label">Target Pengembalian</label>
<div class="input-wrap">
<span class="icon">⏳</span>
<input 
type="date" 
name="target_pengembalian" 
id="tanggal" 
class="input"
min="{{ date('Y-m-d') }}"
required>
</div>
</div>

<div class="actions">
<a href="{{ route('siswa.buku.index') }}" class="btn-cancel">
Batal
</a>

<button class="btn" id="btn">
Ajukan Permintaan
</button>
</div>

</form>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

const form = document.getElementById('form');
const btn = document.getElementById('btn');
const tanggal = document.getElementById('tanggal');

function getToday(){
    const now = new Date();
    return now.getFullYear() + '-' +
        String(now.getMonth()+1).padStart(2,'0') + '-' +
        String(now.getDate()).padStart(2,'0');
}

function validateTanggal(){
    const today = getToday();

    if(tanggal.value === ''){
        alert('Tanggal wajib diisi');
        return false;
    }

    if(tanggal.value < today){
        alert('Target pengembalian tidak boleh kurang dari hari ini');
        return false;
    }

    return true;
}

tanggal.addEventListener('change', validateTanggal);

form.addEventListener('submit', function(e){
    if(!validateTanggal()){
        e.preventDefault();
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '⏳ Memproses...';
});

});
</script>

@endsection