<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * 📋 Riwayat peminjaman siswa
     */
    public function index()
    {
        if (!auth()->user()->anggota) {
            return redirect()
                ->route('siswa.anggota.create')
                ->with('error', 'Anda harus daftar anggota dulu.');
        }

        $peminjamans = Peminjaman::with(['buku', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.peminjaman.index', compact('peminjamans'));
    }

    /**
     * 📥 Form pinjam buku
     */
    public function create(Request $request)
    {
        $buku = Buku::where('id_buku', $request->buku)->firstOrFail();

        return view('siswa.peminjaman.create', compact('buku'));
    }

    /**
     * 💾 Simpan pengajuan peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => ['required', 'exists:buku,id_buku'],
            'target_pengembalian' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'target_pengembalian.after_or_equal' => 'Target pengembalian tidak boleh kurang dari hari ini.'
        ]);

        // ❌ Cegah pinjam buku yang sama
        $sudahMeminjam = Peminjaman::where('user_id', Auth::id())
            ->where('id_buku', $request->id_buku)
            ->whereIn('status', ['Menunggu', 'Dipinjam'])
            ->exists();

        if ($sudahMeminjam) {
            return back()->with('error', 'Anda masih meminjam buku ini.');
        }

        Peminjaman::create([
            'id_buku' => $request->id_buku,
            'user_id' => Auth::id(),
            'tanggal_pinjam' => now()->toDateString(),
            'target_pengembalian' => $request->target_pengembalian,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    /**
     * 🔄 Form pengembalian
     */
    public function formKembali(Peminjaman $peminjaman)
    {
        // 🔒 Pastikan milik user
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

     return view('siswa.peminjaman.kembalikan', compact('peminjaman'));
    }

    /**
     * ✅ Proses pengembalian oleh siswa
     */
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        // 🔒 Validasi kepemilikan
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        // ❌ Cegah double return
        if ($peminjaman->status === 'Sudah Kembali') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $request->validate([
            'tanggal_kembali' => ['required', 'date'],
        ]);

        $target  = Carbon::parse($peminjaman->target_pengembalian);
        $kembali = Carbon::parse($request->tanggal_kembali);

        // 💰 Hitung denda
        $denda = 0;
        if ($kembali->gt($target)) {
            $denda = $kembali->diffInDays($target) * 1000;
        }

        // 💾 Simpan pengembalian
        Pengembalian::create([
            'id_peminjaman'   => $peminjaman->id_peminjaman,
            'user_id'         => Auth::id(),
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda'           => $denda,
        ]);

        // 🔄 Update status & stok
        $peminjaman->update(['status' => 'Sudah Kembali']);
        $peminjaman->buku->increment('stok');

        return redirect()
            ->route('siswa.peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}