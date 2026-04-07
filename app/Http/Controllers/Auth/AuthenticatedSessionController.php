<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        if (!Auth::attempt([
            $field => $request->login,
            'password' => $request->password
        ], $request->boolean('remember'))) {

            return back()->withErrors([
                'login' => 'NIS atau password salah.',
            ])->onlyInput('login');
        }

        $user = Auth::user();

        if ($user->status_akun !== 'Aktif') {
            Auth::logout();

            return back()->withErrors([
                'login' => 'Akun Anda dinonaktifkan. Hubungi admin.',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        if (!$user->anggota) {
            return redirect()->route('siswa.anggota.create');
        }

        return redirect()->intended('/siswa/dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}