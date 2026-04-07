<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBuku'     => Buku::count(),
            'totalSiswa'    => User::where('role', 'siswa')->count(),
            'totalDipinjam' => Peminjaman::where('status', 'Dipinjam')->count(),
            'totalMenunggu' => Peminjaman::where('status', 'Menunggu')->count(),
            'menunggu'      => Peminjaman::with(['buku', 'user'])->where('status', 'Menunggu')->latest()->take(5)->get(),
            'dipinjam'      => Peminjaman::with(['buku', 'user'])->where('status', 'Dipinjam')->latest()->take(5)->get(),
        ]);
    }
}