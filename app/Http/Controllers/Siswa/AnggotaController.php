<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function create()
    {
        return view('siswa.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'kelas' => 'required'
        ]);

        Anggota::create([
            'user_id' => Auth::id(),
            'nis' => $request->nis,
            'kelas' => $request->kelas
        ]);

        return redirect()->route('siswa.dashboard');
    }
}