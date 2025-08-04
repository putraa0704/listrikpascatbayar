<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk otorisasi akses bagi pengguna dengan peran Administrator.
 *
 * Memastikan hanya pengguna yang terautentikasi melalui guard 'web'
 * dan memiliki level_id 1 (Administrator) yang dapat mengakses rute tertentu.
 * Jika tidak memenuhi kriteria, pengguna akan di-logout dan diarahkan ke halaman login.
 *
 * @package App\Http\Middleware
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request  Objek Request yang masuk.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next  Closure untuk melanjutkan request ke handler berikutnya.
     * @return \Symfony\Component\HttpFoundation\Response Respons dari request.
     */
    public function handle(Request $request, Closure $next): Response
{
    if (Auth::check() && Auth::user()->level_id === 1) {
        return $next($request);
    }

    abort(403, 'Akses dilarang. Anda bukan Admin.');
}

}