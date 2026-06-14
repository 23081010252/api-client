<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class ProdukController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function index(Request $request)
    {
        $result = $this->api->getAllProduk();

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

        // Filter
        $search    = $request->get('search', '');
        $filterKat = $request->get('kategori', '');

        $produk = $semua;
        if ($search) {
            $produk = array_filter($produk, fn($p) => stripos($p['nama_produk'], $search) !== false);
        }
        if ($filterKat) {
            $produk = array_filter($produk, fn($p) => ($p['nama_kategori'] ?? '') === $filterKat);
        }

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

    public function create()
    {
        // Ambil daftar kategori untuk dropdown
        $result = $this->api->getAllProduk();
        $semua  = ($result['status'] ?? '') === 'success' ? ($result['data'] ?? []) : [];
        $kategoriList = [];
        foreach ($semua as $p) {
            $kategoriList[$p['id_kategori']] = $p['nama_kategori'] ?? $p['id_kategori'];
        }
        return view('produk.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|integer|min:1',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

        $result = $this->api->createProduk([
            'id_kategori' => (int)$request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'harga'       => (int)$request->harga,
            'stok'        => (int)$request->stok,
        ]);

        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        }

        return back()->withInput()
            ->with('error', $result['message'] ?? 'Gagal menambahkan produk.');
    }

    public function edit(int $id)
    {
        $result = $this->api->getProdukById($id);

        if (($result['status'] ?? '') !== 'success') {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $produk = $result['data'];

        // Kategori list untuk dropdown
        $allResult    = $this->api->getAllProduk();
        $semua        = ($allResult['status'] ?? '') === 'success' ? ($allResult['data'] ?? []) : [];
        $kategoriList = [];
        foreach ($semua as $p) {
            $kategoriList[$p['id_kategori']] = $p['nama_kategori'] ?? $p['id_kategori'];
        }

        return view('produk.edit', compact('produk', 'kategoriList'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'id_kategori' => 'required|integer|min:1',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
        ]);

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

    public function destroy(int $id)
    {
        $result = $this->api->deleteProduk($id);

        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil dihapus!');
        }

        return redirect()->route('produk.index')
            ->with('error', $result['message'] ?? 'Gagal menghapus produk.');
    }
}
