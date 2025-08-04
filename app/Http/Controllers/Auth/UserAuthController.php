<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            // --- Lakukan eager loading relasi 'level' di sini ---
            // Ambil ulang user yang baru saja login, beserta relasi level-nya
            $user = Auth::guard('web')->user()->load('level'); // <<< TAMBAHKAN BARIS INI

            if ($user->level_id == 1) { // Asumsi level_id 1 untuk Admin
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->level_id == 2) { // Asumsi level_id 2 untuk Petugas
                return redirect()->intended('/petugas/dashboard');
            }
            return redirect()->intended('/admin/dashboard');
        }

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/pelanggan/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}