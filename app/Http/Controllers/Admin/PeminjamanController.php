<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'user'])->latest()->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus  = Buku::where('stok', '>', 0)->get();
        $siswas = User::where('role', 'siswa')->where('status_akun', 'Aktif')->get();
        return view('admin.peminjaman.create', compact('bukus', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'             => ['required', 'exists:buku,id_buku'],
            'user_id'             => ['required', 'exists:users,id'],
            'tanggal_pinjam'      => ['required', 'date'],
            'target_pengembalian' => ['required', 'date', 'after:tanggal_pinjam'],
        ]);

        $buku = Buku::findOrFail($request->id_buku);

        if ($buku->stok < 1) {
            return back()->withErrors(['id_buku' => 'Stok buku tidak tersedia.']);
        }

        Peminjaman::create([
            'id_buku'             => $request->id_buku,
            'user_id'             => $request->user_id,
            'disetujui_oleh'      => Auth::id(),
            'tanggal_pinjam'      => $request->tanggal_pinjam,
            'target_pengembalian' => $request->target_pengembalian,
            'status'              => 'Dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function approve(Peminjaman $peminjaman)
    {
        $buku = $peminjaman->buku;

        if ($buku->stok < 1) {
            return back()->withErrors(['error' => 'Stok buku tidak tersedia.']);
        }

        $peminjaman->update([
            'status'         => 'Dipinjam',
            'disetujui_oleh' => Auth::id(),
        ]);

        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman disetujui.');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => ['required', 'date'],
        ]);

        $denda = 0;
        $target = \Carbon\Carbon::parse($peminjaman->target_pengembalian);
        $kembali = \Carbon\Carbon::parse($request->tanggal_kembali);

        if ($kembali->gt($target)) {
            $denda = $kembali->diffInDays($target) * 1000;
        }

        Pengembalian::create([
            'id_peminjaman'  => $peminjaman->id_peminjaman,
            'user_id'        => $peminjaman->user_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda'          => $denda,
        ]);

        $peminjaman->update(['status' => 'Sudah Kembali']);
        $peminjaman->buku->increment('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'Dipinjam') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }
}