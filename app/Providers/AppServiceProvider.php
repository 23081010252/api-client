<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider adalah pusat utama untuk melakukan registrasi 
 * dan konfigurasi layanan (services) di seluruh aplikasi Laravel.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Metode ini dipanggil saat aplikasi pertama kali dimuat (register).
     * Gunakan metode ini untuk melakukan binding ke Service Container.
     * JANGAN melakukan akses ke layanan lain di sini karena belum tentu semuanya sudah tersedia.
     */
    public function register(): void
    {
        //
    }

    /**
     * Metode ini dipanggil setelah semua layanan terdaftar (boot).
     * Ini adalah tempat yang aman untuk menggunakan layanan lainnya 
     * atau melakukan konfigurasi tambahan sebelum aplikasi mulai menangani request.
     */
    public function boot(): void
    {
        //
    }
}