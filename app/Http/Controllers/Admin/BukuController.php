<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
{
    $query = Buku::query();

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('judul_buku', 'like', '%'.$request->search.'%')
              ->orWhere('pengarang', 'like', '%'.$request->search.'%')
              ->orWhere('penerbit', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->kategori && $request->kategori !== 'Semua') {
        $query->where('kategori', $request->kategori);
    }

    if ($request->sort == 'az') {
        $query->orderBy('judul_buku', 'asc');
    } elseif ($request->sort == 'za') {
        $query->orderBy('judul_buku', 'desc');
    } elseif ($request->sort == 'lama') {
        $query->oldest();
    } else {
        $query->latest();
    }

    $bukus = $query->paginate(10)->withQueryString();

    $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

    return view('admin.buku.index', compact('bukus','kategoris'));
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