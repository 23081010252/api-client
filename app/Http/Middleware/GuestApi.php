<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware untuk rute khusus tamu (guest).
 * Berfungsi untuk mencegah pengguna yang sudah login (memiliki API Key) 
 * mengakses halaman login atau registrasi kembali.
 */
class GuestApi
{
    /**
     * Menangani request yang masuk untuk memverifikasi status tamu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah 'api_key' sudah tersimpan di dalam sesi.
        // Jika ada, berarti pengguna sudah dalam kondisi terautentikasi.
        if (session('api_key')) {
            // Jika sudah login, paksa pengguna untuk langsung menuju ke halaman dashboard
            // agar tidak perlu login/register berulang kali.
            return redirect()->route('dashboard');
        }

        // Jika tidak ada 'api_key', izinkan pengguna mengakses halaman tersebut (login/register).
        return $next($request);
    }
}