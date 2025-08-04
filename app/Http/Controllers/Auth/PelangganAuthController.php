<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller ini menangani proses login dan logout untuk pengguna dengan guard 'pelanggan'.
 * Cocok digunakan jika kamu memisahkan autentikasi antara admin, petugas, dan pelanggan.
 */
class PelangganAuthController extends Controller
{
    /**
     * Menampilkan halaman form login untuk pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Mengembalikan view login pelanggan (resources/views/auth/pelanggan_login.blade.php)
        return view('auth.pelanggan_login');
    }

    /**
     * Menangani proses login pelanggan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input form login: username dan password wajib diisi
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mencoba login menggunakan guard 'pelanggan'
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            // Jika berhasil, regenerasi session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Redirect ke halaman dashboard pelanggan atau halaman yang sebelumnya diakses
            return redirect()->intended('/pelanggan/dashboard');
        }

        // Jika gagal login, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username'); // Hanya menyimpan input 'username' agar tidak dikosongkan
    }

    /**
     * Menangani proses logout pelanggan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Melakukan logout dari guard 'pelanggan'
        Auth::guard('pelanggan')->logout();

        // Invalidate session agar tidak bisa digunakan kembali
        $request->session()->invalidate();

        // Regenerasi CSRF token untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login pelanggan setelah logout
        return redirect('/pelanggan/login');
    }
}
