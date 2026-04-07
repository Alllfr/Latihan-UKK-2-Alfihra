<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

      public function store(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    $user = Auth::user();

    if ($user->status_akun != 'Aktif') {

        Auth::logout();

        return back()->withErrors([
            'email' => 'Akun belum disetujui admin',
        ]);
    }

    $request->session()->regenerate();
    if ($user->role == 'admin') {
        return redirect('/admin/dashboard');
    }
    if ($user->role == 'guru') {
        return redirect('/guru/dashboard');
    }
    return redirect('/siswa/dashboard');
}

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }

}