<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware untuk memastikan sesi autentikasi API masih aktif.
 * Middleware ini bertindak sebagai penjaga (gatekeeper) sebelum akses ke rute-rute yang diproteksi.
 */
class CheckApiAuth
{
    /**
     * Menangani request yang masuk untuk memverifikasi kredensial API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah 'api_key' dan 'api_base_url' tersedia di dalam session pengguna.
        // Jika salah satu atau keduanya hilang, berarti pengguna belum login atau sesi telah habis.
        if (!session('api_key') || !session('api_base_url')) {
            // Mengarahkan pengguna kembali ke halaman login jika sesi tidak valid.
            return redirect()->route('login')->with('error', 'Silakan login dan pastikan API Key & URL sudah diset.');
        }

        // Jika sesi valid, meneruskan request ke proses atau controller tujuan (rute yang diproteksi).
        return $next($request);
    }
}