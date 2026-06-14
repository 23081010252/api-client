<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

/**
 * Controller untuk mengelola pengaturan aplikasi, 
 * khususnya konfigurasi URL dasar API yang digunakan.
 */
class SettingsController extends Controller
{
    // Konstruktor untuk menyuntikkan layanan ApiService ke dalam controller
    public function __construct(protected ApiService $api) {}

    // Menampilkan halaman pengaturan
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Memproses penyimpanan konfigurasi URL API baru.
     * URL ini akan disimpan ke dalam session agar aplikasi tahu ke mana 
     * harus mengirimkan request API berikutnya.
     */
    public function update(Request $request)
    {
        // Validasi bahwa input adalah URL yang valid
        $request->validate([
            'api_base_url' => 'required|url',
        ], [
            'api_base_url.required' => 'URL API wajib diisi.',
            'api_base_url.url'      => 'Format URL tidak valid.',
        ]);

        // Menyimpan URL API ke dalam session setelah dibersihkan dari garis miring berlebih
        session([
            'api_base_url' => rtrim($request->api_base_url, '/'),
        ]);

        // Mengembalikan pesan sukses ke halaman sebelumnya
        return back()->with('success', 'Pengaturan API berhasil disimpan!');
    }
}