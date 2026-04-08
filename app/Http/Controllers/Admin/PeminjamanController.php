<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['buku','user']);

        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->whereHas('user', function($u) use ($request){
                    $u->where('name','like','%'.$request->search.'%')
                      ->orWhere('nis','like','%'.$request->search.'%');
                })->orWhereHas('buku', function($b) use ($request){
                    $b->where('judul_buku','like','%'.$request->search.'%');
                });
            });
        }

        if ($request->kelas) {
            $query->whereHas('user', function($q) use ($request){
                $q->where('kelas',$request->kelas);
            });
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal_pinjam',$request->bulan);
        }

        if ($request->sort == 'lama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $peminjamans = $query->paginate(10)->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::where('stok','>',0)->get();
        $siswas = User::where('role','siswa')->where('status_akun','Aktif')->get();

        return view('admin.peminjaman.create', compact('bukus','siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => ['required','exists:buku,id_buku'],
            'user_id' => ['required','exists:users,id'],
            'tanggal_pinjam' => ['required','date'],
            'target_pengembalian' => ['required','date','after:tanggal_pinjam'],
        ]);

        $buku = Buku::findOrFail($request->id_buku);

        if ($buku->stok < 1) {
            return back()->withErrors(['id_buku'=>'Stok buku tidak tersedia']);
        }

        Peminjaman::create([
            'id_buku' => $request->id_buku,
            'user_id' => $request->user_id,
            'disetujui_oleh' => Auth::id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'target_pengembalian' => $request->target_pengembalian,
            'status' => 'Dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Peminjaman berhasil ditambahkan');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $bukus = Buku::all();
        $siswas = User::where('role','siswa')->get();

        return view('admin.peminjaman.edit', compact('peminjaman','bukus','siswas'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_buku' => ['required','exists:buku,id_buku'],
            'user_id' => ['required','exists:users,id'],
            'tanggal_pinjam' => ['required','date'],
            'target_pengembalian' => ['required','date','after:tanggal_pinjam'],
        ]);

        if ($peminjaman->id_buku != $request->id_buku) {
            $oldBuku = Buku::find($peminjaman->id_buku);
            if ($oldBuku) {
                $oldBuku->increment('stok');
            }

            $newBuku = Buku::findOrFail($request->id_buku);
            if ($newBuku->stok < 1) {
                return back()->withErrors(['id_buku'=>'Stok buku tidak tersedia']);
            }

            $newBuku->decrement('stok');
        }

        $peminjaman->update([
            'id_buku' => $request->id_buku,
            'user_id' => $request->user_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'target_pengembalian' => $request->target_pengembalian,
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Data berhasil diupdate');
    }

    public function approve(Peminjaman $peminjaman)
    {
        $buku = $peminjaman->buku;

        if ($buku->stok < 1) {
            return back()->withErrors(['error'=>'Stok buku tidak tersedia']);
        }

        $peminjaman->update([
            'status'=>'Dipinjam',
            'disetujui_oleh'=>Auth::id(),
        ]);

        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Peminjaman disetujui');
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => ['required','date'],
        ]);

        $denda = 0;

        $target = Carbon::parse($peminjaman->target_pengembalian);
        $kembali = Carbon::parse($request->tanggal_kembali);

        if ($kembali->gt($target)) {
            $denda = $kembali->diffInDays($target) * 1000;
        }

        Pengembalian::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'user_id' => $peminjaman->user_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $denda,
        ]);

        $peminjaman->update(['status'=>'Sudah Kembali']);
        $peminjaman->buku->increment('stok');

        return redirect()->route('admin.peminjaman.index')
            ->with('success','Pengembalian berhasil');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status,['Dipinjam','Menunggu'])) {
            return redirect()->route('admin.peminjaman.index')
                ->with('error','Tidak bisa dihapus, buku masih dipinjam');
        }

        if ($peminjaman->status === 'Sudah Kembali') {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();

        return back()->with('success','Data berhasil dihapus');
    }
}