<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

/**
 * Controller untuk mengelola data produk.
 * Berfungsi sebagai perantara antara User (View) dan API Server (ApiService).
 */
class ProdukController extends Controller
{
    // Konstruktor untuk menyuntikkan layanan ApiService ke dalam controller
    public function __construct(protected ApiService $api) {}

    // Menampilkan daftar seluruh produk dengan fitur filter
    public function index(Request $request)
    {
        // Validasi sesi aktif
        if (!session('api_key')) {
            return redirect()->route('dashboard')
                ->with('error', 'API Key tidak ditemukan atau kedaluwarsa. Silakan masuk kembali.');
        }

        // Mengambil data dari API Server
        $result = $this->api->getAllProduk();

        // Jika pengambilan data gagal, kembalikan view dengan data kosong
        if (($result['status'] ?? '') !== 'success') {
            return view('produk.index', [
                'produk'      => [],
                'apiError'    => $result['message'] ?? 'Gagal mengambil data dari API.',
                'kategoriList'=> [],
                'stats'       => ['total'=>0,'stok'=>0,'harga_min'=>0,'harga_max'=>0],
                'search'      => '',
                'filterKat'   => '',
            ]);
        }

        $semua = $result['data'] ?? [];

        // Logika Filter pencarian nama dan kategori
        $search    = $request->get('search', '');
        $filterKat = $request->get('kategori', '');

        $produk = $semua;
        if ($search) {
            $produk = array_filter($produk, fn($p) => stripos($p['nama_produk'], $search) !== false);
        }
        if ($filterKat) {
            $produk = array_filter($produk, fn($p) => ($p['nama_kategori'] ?? '') === $filterKat);
        }

        // Persiapan data untuk dropdown kategori dan statistik ringkasan
        $kategoriList = array_unique(array_column($semua, 'nama_kategori'));
        sort($kategoriList);

        $stats = [
            'total'    => count($semua),
            'stok'     => array_sum(array_column($semua, 'stok')),
            'harga_min'=> $semua ? min(array_column($semua, 'harga')) : 0,
            'harga_max'=> $semua ? max(array_column($semua, 'harga')) : 0,
        ];

        return view('produk.index', compact('produk', 'kategoriList', 'stats', 'search', 'filterKat'));
    }

    // Menampilkan form tambah produk baru
    public function create()
    {
        if (!session('api_key')) {
            return redirect()->route('dashboard')->with('error', 'Sesi Anda telah habis.');
        }

        // Mengambil daftar kategori dari produk yang ada
        $result = $this->api->getAllProduk();
        $semua  = ($result['status'] ?? '') === 'success' ? ($result['data'] ?? []) : [];
        $kategoriList = [];
        foreach ($semua as $p) {
            $kategoriList[$p['id_kategori']] = $p['nama_kategori'] ?? $p['id_kategori'];
        }
        return view('produk.create', compact('kategoriList'));
    }

    // Memproses data form untuk disimpan ke API Server
    public function store(Request $request)
    {
        if (!session('api_key')) {
            return redirect()->route('dashboard')->with('error', 'Sesi Anda telah habis.');
        }

        // Validasi input wajib dari form
        $request->validate([
            'id_kategori' => 'required|integer|min:1',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        // Mengirim data baru ke API Server
        $result = $this->api->createProduk([
            'id_kategori' => (int)$request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'harga'       => (int)$request->harga,
            'stok'        => (int)$request->stok,
        ]);

        // Jika API mengembalikan status sukses
        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        }

        return back()->withInput()
            ->with('error', $result['message'] ?? 'Gagal menambahkan produk.');
    }

    // Menampilkan form edit berdasarkan ID produk
    public function edit(int $id)
    {
        if (!session('api_key')) {
            return redirect()->route('dashboard')->with('error', 'Sesi Anda telah habis.');
        }

        $result = $this->api->getProdukById($id);

        if (($result['status'] ?? '') !== 'success') {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $produk = $result['data'];

        // Mengambil daftar kategori untuk pilihan edit
        $allResult    = $this->api->getAllProduk();
        $semua        = ($allResult['status'] ?? '') === 'success' ? ($allResult['data'] ?? []) : [];
        $kategoriList = [];
        foreach ($semua as $p) {
            $kategoriList[$p['id_kategori']] = $p['nama_kategori'] ?? $p['id_kategori'];
        }

        return view('produk.edit', compact('produk', 'kategoriList'));
    }

    // Memproses update data produk ke API Server
    public function update(Request $request, int $id)
    {
        if (!session('api_key')) {
            return redirect()->route('dashboard')->with('error', 'Sesi Anda telah habis.');
        }

        $request->validate([
            'id_kategori' => 'required|integer|min:1',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        // Mengirim request update ke API
        $result = $this->api->updateProduk($id, [
            'id_kategori' => (int)$request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'harga'       => (int)$request->harga,
            'stok'        => (int)$request->stok,
        ]);

        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil diperbarui!');
        }

        return back()->withInput()
            ->with('error', $result['message'] ?? 'Gagal memperbarui produk.');
    }

    // Menghapus data produk melalui API
    public function destroy(int $id)
    {
        if (!session('api_key')) {
            return redirect()->route('dashboard')->with('error', 'Sesi Anda telah habis.');
        }

        $result = $this->api->deleteProduk($id);

        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil dihapus!');
        }

        return redirect()->route('produk.index')
            ->with('error', $result['message'] ?? 'Gagal menghapus produk.');
    }
}