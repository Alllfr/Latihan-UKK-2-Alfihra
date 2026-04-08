@extends('layouts.siswa')

@section('content')

<style>
:root {
    --pink:   #fbcfe8;
    --blue:   #a5d8ff;
    --mint:   #a7f3d0;
    --yellow: #fde68a;
    --purple: #c4b5fd;
    --text:   #374151;
    --muted:  #9ca3af;
    --border: #e5e7eb;
    --white:  #ffffff;
    --bg:     #f8fafc;
}

.card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 20px;
}

.label {
    font-size: 12px;
    color: var(--muted);
}

.value {
    font-weight: 600;
    font-size: 14px;
}

.input {
    width: 100%;
    margin-top: 6px;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 13px;
}

.btn-main {
    background: linear-gradient(135deg, var(--pink), var(--purple));
    border: none;
    color: white;
    padding: 10px 16px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.btn-main:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.btn-secondary {
    background: var(--bg);
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    text-decoration: none;
    color: var(--text);
}
</style>

<div style="max-width:720px;margin:auto;padding:20px;">

    <div style="margin-bottom:20px;">
        <h2 style="font-size:22px;font-weight:800;">🔄 Pengembalian Buku</h2>
        <p style="font-size:13px;color:var(--muted);">Isi tanggal pengembalian ya </p>
    </div>

    <div class="card">

        <div style="margin-bottom:16px;">
            <div class="label">Judul Buku</div>
            <div class="value">{{ $peminjaman->buku->judul_buku }}</div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
            
            <div>
                <div class="label">Tanggal Pinjam</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                </div>
            </div>

            <div>
                <div class="label">Batas Kembali</div>
                <div id="batas" class="value"
                     data-date="{{ $peminjaman->target_pengembalian }}">
                    {{ \Carbon\Carbon::parse($peminjaman->target_pengembalian)->format('d M Y') }}
                </div>
            </div>

        </div>

        <form method="POST" action="{{ route('siswa.peminjaman.kembalikan', $peminjaman->id_peminjaman) }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label class="label">Tanggal Kembali</label>
                <input 
                    type="date" 
                    name="tanggal_kembali"
                    id="tanggal_kembali"
                    value="{{ date('Y-m-d') }}"
                    min="{{ date('Y-m-d') }}"
                    class="input">
            </div>

            <div style="margin-bottom:16px;">
                <div class="label">Estimasi Denda</div>
                <div id="denda" class="value" style="color:#e11d48;">
                    Rp 0
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-main">
                     Kembalikan
                </button>

                <a href="{{ route('siswa.peminjaman.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

<script>
function hitungDenda() {
    const batas = new Date(document.getElementById('batas').dataset.date);
    const kembali = new Date(document.getElementById('tanggal_kembali').value);

    let denda = 0;

    if (kembali > batas) {
        const selisih = Math.ceil((kembali - batas) / (1000 * 60 * 60 * 24));
        denda = selisih * 1000;
    }

    document.getElementById('denda').innerText = 
        'Rp ' + denda.toLocaleString('id-ID');
}

document.getElementById('tanggal_kembali').addEventListener('change', hitungDenda);

window.onload = hitungDenda;
</script>

@endsection