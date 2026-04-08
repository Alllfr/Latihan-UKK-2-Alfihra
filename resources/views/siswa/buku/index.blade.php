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

.page{
width:100%;
padding:20px 28px;
}

.toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 26px;
    align-items: stretch;
}

.search {
    flex: 1 1 260px;
    min-width: 0;
    position: relative;
}

.search input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border-radius: 14px;
    border: 2px solid transparent;
    background:
        linear-gradient(#fff, #fff) padding-box,
        linear-gradient(135deg, var(--pink), var(--blue)) border-box;
    font-size: 14px;
    outline: none;
    height: 100%;
    box-sizing: border-box;
}

.search span {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    pointer-events: none;
}

.select-box {
    flex: 0 0 160px;
    position: relative;
}

.select-box select {
    width: 100%;
    height: 100%;
    min-height: 44px;
    appearance: none;
    padding: 10px 38px 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    border: 2px solid transparent;
    background:
        linear-gradient(#fff, #fff) padding-box,
        linear-gradient(135deg, var(--pink), var(--blue)) border-box;
    cursor: pointer;
    box-sizing: border-box;
}

.select-box::after {
    content: "▼";
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 11px;
    pointer-events: none;
    color: var(--muted);
}

.sort{
flex:0 0 160px;
}

.grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
gap:24px;
}

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

.cover{
width:100%;
height:180px;
border-radius:14px;
object-fit:cover;
margin-bottom:10px;
}

.title{
font-size:15px;
font-weight:700;
margin-bottom:2px;
}

.meta{
font-size:12px;
color:var(--muted);
}

.card-footer{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:12px;
}

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

@media (max-width: 640px) {
    .search      { flex: 1 1 100%; }
    .select-box  { flex: 1 1 calc(50% - 6px); }

}
</style>

<div class="page">

<div class="toolbar">

<div class="search">
<span>🔍</span>
<input type="text" id="search" placeholder="Cari buku...">
</div>

<div class="select-box">
<select id="kategori">
<option value="Semua">Semua</option>
<option value="Sains">Sains</option>
<option value="Fiksi">Fiksi</option>
</select>
</div>

<div class="select-box sort">
<select id="sort">
<option value="az">A-Z</option>
<option value="za">Z-A</option>
<option value="baru">Terbaru</option>
<option value="lama">Terlama</option>
</select>
</div>

</div>

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
const kategoriSelect = document.getElementById('kategori');

const cards = Array.from(document.querySelectorAll('.card'));

searchInput.addEventListener('input', render);
sortSelect.addEventListener('change', render);
kategoriSelect.addEventListener('change', render);

function render(){
let filtered = cards.filter(c=>{
const matchSearch = c.dataset.judul.includes(searchInput.value.toLowerCase());
const matchKategori = kategoriSelect.value === 'Semua' || c.dataset.kategori === kategoriSelect.value;
return matchSearch && matchKategori;
});

cards.forEach(c=>{
c.style.display = 'none';
c.style.order = 0;
});

filtered.forEach(c=>{
c.style.display = 'flex';
});

let sorted = [...filtered];

sorted.sort((a,b)=>{
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

sorted.forEach((c,i)=>{
c.style.order = i;
});
}
</script>

@endsection