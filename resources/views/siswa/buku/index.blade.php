@extends('layouts.siswa')

@section('title','Daftar Buku')

@section('content')

<style>
:root{
--pink:#ff7eb3;
--blue:#4facfe;
--mint:#34d399;
--yellow:#facc15;
--purple:#a78bfa;

--text:#1e293b;
--muted:#64748b;
--border:#e2e8f0;
--white:#ffffff;
}

/* FULL WIDTH */
.page{
width:100%;
padding:20px 28px;
}

/* TOOLBAR FIX */
.toolbar{
display:flex;
flex-wrap:wrap;
gap:14px;
margin-bottom:26px;
align-items:center;
}

/* SEARCH FLEX BESAR */
.search{
flex:1 1 320px;
min-width:260px;
position:relative;
}

.search input{
width:100%;
padding:12px 16px 12px 42px;
border-radius:14px;
border:2px solid transparent;
background:
linear-gradient(#fff,#fff) padding-box,
linear-gradient(135deg,var(--pink),var(--blue)) border-box;
font-size:14px;
outline:none;
}

.search span{
position:absolute;
left:14px;
top:50%;
transform:translateY(-50%);
font-size:14px;
}

/* FILTER GROUP */
.filters{
display:flex;
gap:10px;
flex-wrap:wrap;
}

.filter-btn{
padding:10px 16px;
border-radius:12px;
border:none;
cursor:pointer;
font-size:13px;
font-weight:600;
background:linear-gradient(135deg,#ffe4ec,#e0f2fe);
transition:.2s;
white-space:nowrap;
}

.filter-btn:hover{
transform:translateY(-2px);
}

/* SORT */
.sort{
margin-left:auto;
position:relative;
}

.sort select{
appearance:none;
padding:10px 38px 10px 14px;
border-radius:12px;
font-size:13px;
font-weight:600;
border:2px solid transparent;
background:
linear-gradient(#fff,#fff) padding-box,
linear-gradient(135deg,var(--pink),var(--blue)) border-box;
cursor:pointer;
}

.sort:after{
content:"▼";
position:absolute;
right:12px;
top:50%;
transform:translateY(-50%);
font-size:12px;
}

/* GRID FULL */
.grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
gap:24px;
}

/* CARD */
.card{
background:white;
border-radius:20px;
padding:16px;
box-shadow:0 12px 28px rgba(0,0,0,0.08);
transition:.25s;
display:flex;
flex-direction:column;
}

.card:hover{
transform:translateY(-6px) scale(1.02);
box-shadow:0 18px 40px rgba(0,0,0,0.14);
}

/* IMAGE */
.cover{
width:100%;
height:180px;
border-radius:14px;
object-fit:cover;
margin-bottom:10px;
}

/* TEXT */
.title{
font-size:15px;
font-weight:700;
margin-bottom:2px;
}

.meta{
font-size:12px;
color:var(--muted);
}

/* FOOTER */
.card-footer{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:12px;
}

/* BUTTON */
.btn-pinjam{
padding:7px 14px;
border:none;
border-radius:10px;
font-size:12px;
font-weight:600;
cursor:pointer;
background:linear-gradient(135deg,var(--pink),var(--blue));
color:white;
transition:.2s;
}

.btn-pinjam:hover{
transform:scale(1.05);
}

.btn-disabled{
background:#e5e7eb;
color:#9ca3af;
cursor:not-allowed;
}

/* RESPONSIVE FIX */
@media(max-width:640px){
.sort{
width:100%;
margin-left:0;
}
.sort select{
width:100%;
}
}
</style>

<div class="page">

<!-- TOOLBAR -->
<div class="toolbar">

<div class="search">
<span>🔍</span>
<input type="text" id="search" placeholder="Cari buku...">
</div>

<div class="filters">
<button class="filter-btn" onclick="filterKategori('Semua')">Semua</button>
<button class="filter-btn" onclick="filterKategori('Sains')">Sains</button>
<button class="filter-btn" onclick="filterKategori('Fiksi')">Fiksi</button>
</div>

<div class="sort">
<select id="sort">
<option value="az">A-Z</option>
<option value="za">Z-A</option>
<option value="baru">Terbaru</option>
<option value="lama">Terlama</option>
</select>
</div>

</div>

<!-- GRID -->
<div class="grid" id="grid">

@foreach($bukus as $b)
<div class="card"
data-judul="{{ strtolower($b->judul_buku) }}"
data-kategori="{{ $b->kategori }}"
data-tanggal="{{ $b->created_at }}">

<img src="{{ asset('storage/'.$b->foto) }}" class="cover">

<div class="title">{{ $b->judul_buku }}</div>
<div class="meta">{{ $b->pengarang }}</div>
<div class="meta">{{ $b->kategori }}</div>

<div class="card-footer">
<span class="meta">Stok: {{ $b->stok }}</span>

@if($b->stok > 0)
<a href="{{ route('siswa.peminjaman.create',['buku'=>$b->id_buku]) }}" class="btn-pinjam">
Pinjam
</a>
@else
<button class="btn-pinjam btn-disabled">Habis</button>
@endif

</div>

</div>
@endforeach

</div>

</div>

<script>
const searchInput = document.getElementById('search');
const sortSelect = document.getElementById('sort');
let currentKategori = 'Semua';

function filterKategori(kat){
currentKategori = kat;
render();
}

searchInput.addEventListener('input', render);
sortSelect.addEventListener('change', render);

function render(){
const cards = Array.from(document.querySelectorAll('.card'));

let filtered = cards.filter(c=>{
const matchSearch = c.dataset.judul.includes(searchInput.value.toLowerCase());
const matchKategori = currentKategori === 'Semua' || c.dataset.kategori === currentKategori;
return matchSearch && matchKategori;
});

filtered.sort((a,b)=>{
if(sortSelect.value==='az'){
return a.dataset.judul.localeCompare(b.dataset.judul);
}
if(sortSelect.value==='za'){
return b.dataset.judul.localeCompare(a.dataset.judul);
}
if(sortSelect.value==='baru'){
return new Date(b.dataset.tanggal)-new Date(a.dataset.tanggal);
}
if(sortSelect.value==='lama'){
return new Date(a.dataset.tanggal)-new Date(b.dataset.tanggal);
}
});

const grid = document.getElementById('grid');
grid.innerHTML='';
filtered.forEach(c=>grid.appendChild(c));
}
</script>

@endsection