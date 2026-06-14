<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class DashboardController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index()
    {
        $result = $this->api->getAllProduk();
        $produk = ($result['status'] ?? '') === 'success' ? ($result['data'] ?? []) : [];

        $stats = [
            'total'    => count($produk),
            'stok'     => array_sum(array_column($produk, 'stok')),
            'harga_min'=> $produk ? min(array_column($produk, 'harga')) : 0,
            'harga_max'=> $produk ? max(array_column($produk, 'harga')) : 0,
        ];

        // Produk stok rendah (< 10)
        $stokRendah = array_filter($produk, fn($p) => (int)$p['stok'] < 10);

        // Produk terbaru (5 terakhir)
        $terbaru = array_slice(array_reverse($produk), 0, 5);

        return view('dashboard.index', compact('stats', 'stokRendah', 'terbaru', 'produk'));
    }
}
