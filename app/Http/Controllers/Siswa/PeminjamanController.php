<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        if (!auth()->user()->anggota) {
         return redirect()
        ->route('siswa.anggota.create')
        ->with('error', 'Anda harus daftar anggota dulu.');
}

        return view('siswa.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('siswa.peminjaman.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'             => ['required', 'exists:buku,id_buku'],
            'target_pengembalian' => ['required', 'date', 'after:today'],
        ]);

        $sudahMeminjam = Peminjaman::where('user_id', Auth::id())
            ->where('id_buku', $request->id_buku)
            ->whereIn('status', ['Menunggu', 'Dipinjam'])
            ->exists();

        if ($sudahMeminjam) {
            return back()->withErrors(['id_buku' => 'Anda masih meminjam buku ini.']);
        }

        Peminjaman::create([
            'id_buku'             => $request->id_buku,
            'user_id'             => Auth::id(),
            'tanggal_pinjam'      => now()->toDateString(),
            'target_pengembalian' => $request->target_pengembalian,
            'status'              => 'Menunggu',
        ]);

        return redirect()->route('siswa.peminjaman.index')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }
}