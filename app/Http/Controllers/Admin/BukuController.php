<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku'          => ['required', 'string', 'unique:buku,id_buku'],
            'judul_buku'       => ['required', 'string', 'max:255'],
            'pengarang'        => ['required', 'string', 'max:255'],
            'kategori'         => ['required', 'string', 'max:255'],
            'penerbit'         => ['required', 'string', 'max:255'],
            'tanggal_register' => ['required', 'date'],
            'stok'             => ['required', 'integer', 'min:0'],
            'foto'             => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul_buku'       => ['required', 'string', 'max:255'],
            'pengarang'        => ['required', 'string', 'max:255'],
            'kategori'         => ['required', 'string', 'max:255'],
            'penerbit'         => ['required', 'string', 'max:255'],
            'tanggal_register' => ['required', 'date'],
            'stok'             => ['required', 'integer', 'min:0'],
            'foto'             => ['nullable', 'image', 'max:2048'],
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}