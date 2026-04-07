<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = User::where('role', 'siswa')->latest()->paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'nis'         => ['required', 'string', 'unique:users,nis'],
            'kelas'       => ['required', 'string', 'max:100'],
            'password'    => ['required', 'string', 'min:6'],
            'status_akun' => ['required', 'in:Aktif,Nonaktif'],
        ]);

        User::create([
            'name'        => $request->name,
            'nis'         => $request->nis,
            'kelas'       => $request->kelas,
            'role'        => 'siswa',
            'status_akun' => $request->status_akun,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(User $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'nis'         => ['required', 'string', 'unique:users,nis,' . $siswa->id],
            'kelas'       => ['required', 'string', 'max:100'],
            'status_akun' => ['required', 'in:Aktif,Nonaktif'],
            'password'    => ['nullable', 'string', 'min:6'],
        ]);

        $data = $request->only('name', 'nis', 'kelas', 'status_akun');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(User $siswa)
    {
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}