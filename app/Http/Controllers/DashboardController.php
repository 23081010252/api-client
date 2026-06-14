<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

/**
 * Controller untuk menangani tampilan dashboard utama.
 * Mengambil data dari API dan memprosesnya untuk keperluan statistik.
 */
class DashboardController extends Controller
{
    // Konstruktor untuk menyuntikkan layanan ApiService ke dalam controller
    public function __construct(protected ApiService $api) {}

    // Menampilkan halaman utama dashboard
    public function index()
    {
        // Mengambil seluruh data produk dari API
        $result = $this->api->getAllProduk();
        
        // Memastikan data produk tersedia, jika gagal kembalikan array kosong
        $produk = ($result['status'] ?? '') === 'success' ? ($result['data'] ?? []) : [];

        // Menghitung statistik ringkasan produk (total, jumlah stok, harga min/max)
        $stats = [
            'total'    => count($produk),
            'stok'     => array_sum(array_column($produk, 'stok')),
            'harga_min'=> $produk ? min(array_column($produk, 'harga')) : 0,
            'harga_max'=> $produk ? max(array_column($produk, 'harga')) : 0,
        ];

        // Menyaring daftar produk yang memiliki stok kurang dari 10 (stok rendah)
        $stokRendah = array_filter($produk, fn($p) => (int)$p['stok'] < 10);

        // Mengambil 5 produk terbaru (dibalik urutannya agar data baru di posisi awal)
        $terbaru = array_slice(array_reverse($produk), 0, 5);

        // Mengirim data ke view dashboard.index untuk ditampilkan
        return view('dashboard.index', compact('stats', 'stokRendah', 'terbaru', 'produk'));
    }
}