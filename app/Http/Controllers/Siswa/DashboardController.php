<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        return view('siswa.dashboard', [
            'peminjamans'   => Peminjaman::with('buku')->where('user_id', $userId)->whereIn('status', ['Menunggu', 'Dipinjam'])->latest()->get(),
            'totalDipinjam' => Peminjaman::where('user_id', $userId)->where('status', 'Dipinjam')->count(),
            'totalMenunggu' => Peminjaman::where('user_id', $userId)->where('status', 'Menunggu')->count(),
            'totalKembali'  => Peminjaman::where('user_id', $userId)->where('status', 'Sudah Kembali')->count(),
        ]);
    }
}