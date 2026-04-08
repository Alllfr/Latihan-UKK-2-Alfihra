<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BukuController as AdminBuku;
use App\Http\Controllers\Admin\SiswaController as AdminSiswa;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjaman;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjaman;
use App\Http\Controllers\Siswa\AnggotaController;

use App\Models\Buku;

Route::redirect('/', '/login');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('buku', AdminBuku::class)->except('show');
    Route::resource('siswa', AdminSiswa::class)->except('show');
    Route::get('/peminjaman/{peminjaman}/edit', [AdminPeminjaman::class, 'edit'])->name('peminjaman.edit');
    Route::patch('/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'update'])->name('peminjaman.update');
    Route::get('/peminjaman', [AdminPeminjaman::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [AdminPeminjaman::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [AdminPeminjaman::class, 'store'])->name('peminjaman.store');

    Route::patch('/peminjaman/{peminjaman}/approve', [AdminPeminjaman::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [AdminPeminjaman::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::delete('/peminjaman/{peminjaman}', [AdminPeminjaman::class, 'destroy'])->name('peminjaman.destroy');

});

Route::prefix('siswa')->name('siswa.')->middleware(['auth','role:siswa'])->group(function () {

    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');

    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');

    Route::get('/buku', function () {
        $bukus = Buku::latest()->get();
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('siswa.buku.index', compact('bukus','kategoris'));
    })->name('buku.index');

    Route::get('/peminjaman', [SiswaPeminjaman::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [SiswaPeminjaman::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [SiswaPeminjaman::class, 'store'])->name('peminjaman.store');

    Route::get('/peminjaman/kembali/{peminjaman}', [SiswaPeminjaman::class, 'formKembali'])->name('peminjaman.formKembali');
    Route::post('/peminjaman/kembali/{peminjaman}', [SiswaPeminjaman::class, 'kembalikan'])->name('peminjaman.kembalikan');

});