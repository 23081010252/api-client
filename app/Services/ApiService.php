<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Service class untuk menangani seluruh komunikasi HTTP antara 
 * aplikasi Client dan API Server.
 */
class ApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    // Inisialisasi URL dasar dan API Key dari konfigurasi dan session
    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url'), '/');
        $this->apiKey  = session('api_key', '');
    }

    /**
     * Membangun request HTTP dengan header standar.
     * Mengambil session secara real-time agar token dinamis dari dashboard langsung terbaca.
     */
    protected function http()
{
    $currentApiKey = session('api_key', $this->apiKey);

    return Http::withHeaders([
        'Authorization' => 'Bearer ' . $currentApiKey,
        'Accept'        => 'application/json',
    ])->timeout(15);
}

    // ── Auth ──────────────────────────────────────────────────────────────────

    // Mengirim permintaan login ke server API
    public function login(string $baseUrl, string $username, string $password): array
    {
        try {
            $res = Http::asForm()
                ->timeout(15)
                ->post(rtrim($baseUrl, '/') . '/api/auth/login', compact('username', 'password'));
            
            if ($res->successful()) {
                return $res->json() ?? ['status' => 'error', 'message' => 'Format JSON salah.'];
            }
            return ['status' => 'error', 'message' => 'Backend Error ' . $res->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    // Mengirim permintaan registrasi ke server API
    public function register(string $baseUrl, string $username, string $email, string $password): array
    {
        try {
            $res = Http::asForm()
                ->timeout(15)
                ->post(rtrim($baseUrl, '/') . '/api/auth/register', compact('username', 'email', 'password'));
            
            if ($res->successful()) {
                return $res->json() ?? ['status' => 'error', 'message' => 'Format JSON salah.'];
            }
            return ['status' => 'error', 'message' => 'Backend Error ' . $res->status()];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    // ── Produk ────────────────────────────────────────────────────────────────

    // Mengambil semua data produk dari API
    public function getAllProduk(): array
    {
        try {
            $res = $this->http()->get("{$this->baseUrl}/api/produk");
            return $res->json() ?? ['status' => 'error', 'data' => []];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage(), 'data' => []];
        }
    }

    // Mengambil detail satu produk berdasarkan ID
    public function getProdukById(int $id): array
    {
        try {
            $res = $this->http()->get("{$this->baseUrl}/api/produk/{$id}");
            return $res->json() ?? ['status' => 'error', 'data' => null];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    // Mengirim data untuk membuat produk baru (menggunakan asForm untuk kompatibilitas)
    public function createProduk(array $data): array
    {
        try {
            $res = $this->http()->asForm()->post("{$this->baseUrl}/api/produk", $data);
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    // Mengirim data untuk memperbarui produk (menggunakan asForm)
    public function updateProduk(int $id, array $data): array
    {
        try {
            $res = $this->http()->asForm()->put("{$this->baseUrl}/api/produk/{$id}", $data);
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    // Mengirim permintaan untuk menghapus produk berdasarkan ID
    public function deleteProduk(int $id): array
    {
        try {
            $res = $this->http()->delete("{$this->baseUrl}/api/produk/{$id}");
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }
}