<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>

<style>

:root{
--pink:#fce7f3;
--blue:#e0f2fe;
--purple:#ede9fe;
--mint:#d1fae5;

--text:#0f172a;
--muted:#64748b;
--border:#e2e8f0;
}

body{
margin:0;
font-family:system-ui,sans-serif;
background:linear-gradient(
135deg,
#fdf2f8,
#eff6ff,
#ecfeff
);
min-height:100vh;
}

.wrapper{
display:flex;
min-height:100vh;
}

.sidebar{
width:250px;
background:white;
border-right:1px solid var(--border);
padding:20px;
}

.logo{
font-size:20px;
font-weight:800;
margin-bottom:30px;

background:linear-gradient(
135deg,
#f472b6,
#60a5fa
);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}

.menu a{
display:block;
padding:12px 14px;
border-radius:12px;
text-decoration:none;
color:var(--text);
font-size:14px;
margin-bottom:6px;
transition:.2s;
}

.menu a:hover{
background:var(--pink);
}

.menu a.active{
background:linear-gradient(
135deg,
#fce7f3,
#e0f2fe
);
font-weight:600;
}

.logout{
margin-top:20px;
display:block;
padding:12px;
border-radius:12px;
background:linear-gradient(
135deg,
#fecdd3,
#bfdbfe
);
text-decoration:none;
color:black;
font-weight:600;
text-align:center;
}

.main{
flex:1;
display:flex;
flex-direction:column;
}

.topbar{
padding:16px 24px;
background:white;
border-bottom:1px solid var(--border);

display:flex;
justify-content:space-between;
align-items:center;
}

.page{
padding:24px;
}

.card{
background:white;
border-radius:18px;
padding:20px;
border:1px solid var(--border);
box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

.stat-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:18px;
margin-bottom:25px;
}

.stat-card{
padding:18px;
border-radius:18px;

background:linear-gradient(
135deg,
#fdf2f8,
#eff6ff
);

display:flex;
gap:14px;
align-items:center;
}

.stat-icon{
width:50px;
height:50px;
border-radius:14px;

display:flex;
align-items:center;
justify-content:center;

font-size:22px;
}

.icon-pink{ background:#fce7f3; }
.icon-blue{ background:#e0f2fe; }
.icon-mint{ background:#d1fae5; }
.icon-yellow{ background:#fef9c3; }

.stat-value{
font-size:26px;
font-weight:800;
}

.stat-label{
font-size:13px;
color:var(--muted);
}

.table-wrap{
margin-top:14px;
background:white;
border-radius:16px;
border:1px solid var(--border);
overflow:hidden;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#f8fafc;
padding:12px;
font-size:12px;
text-align:left;
}

td{
padding:12px;
border-bottom:1px solid var(--border);
font-size:13px;
}

.badge{
padding:4px 10px;
border-radius:999px;
font-size:12px;
}

.badge-blue{
background:#e0f2fe;
color:#0369a1;
}

.badge-yellow{
background:#fef9c3;
color:#a16207;
}

.badge-red{
background:#fee2e2;
color:#b91c1c;
}

.btn{
padding:8px 14px;
border-radius:10px;
border:none;
cursor:pointer;

background:linear-gradient(
135deg,
#fce7f3,
#e0f2fe
);
}

</style>
</head>

<body>

<div class="wrapper">

<div class="sidebar">

<div class="logo">
Perpustakaan
</div>

<div class="menu">

<a href="{{ route('admin.dashboard') }}"
class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
Dashboard
</a>

<a href="{{ route('admin.buku.index') }}"
class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
Data Buku
</a>

<a href="{{ route('admin.peminjaman.index') }}"
class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
Peminjaman
</a>

<a href="{{ route('admin.siswa.index') }}"
class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
Data Siswa
</a>

</div>

<a href="{{ route('logout') }}" class="logout">
Keluar
</a>

</div>

<div class="main">

<div class="topbar">

<div>
@yield('title')
</div>

<div id="tanggal"></div>

</div>

<div class="page">

@yield('content')

</div>

</div>

</div>

<script>

function updateDate(){
const now=new Date();

document.getElementById("tanggal")
.innerText=now.toLocaleDateString(
"id-ID",
{
weekday:"long",
day:"numeric",
month:"long",
year:"numeric"
}
);
}

updateDate();

</script>

</body>
</html>