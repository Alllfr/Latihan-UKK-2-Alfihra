@extends('layouts.admin')

@section('title','Edit Buku')

@section('content')

<div class="bg-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
</div>

<div class="card">
<h2>✏️ Edit Buku</h2>

<form method="POST" action="{{ route('admin.buku.update',$buku) }}">
@csrf
@method('PATCH')

<input class="input" name="judul_buku" value="{{ $buku->judul_buku }}">
<input class="input" name="pengarang" value="{{ $buku->pengarang }}">
<input class="input" name="kategori" value="{{ $buku->kategori }}">
<input class="input" name="penerbit" value="{{ $buku->penerbit }}">
<input class="input" type="number" name="stok" value="{{ $buku->stok }}">

<button class="btn">Update</button>

</form>
</div>

@endsection