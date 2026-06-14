<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
{
    $this->baseUrl = rtrim(config('services.api.base_url'), '/');
    $this->apiKey  = session('api_key', '');
}

    protected function http()
    {
        return Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Accept'    => 'application/json',
        ])->timeout(15);
    }

    // ── Auth ──────────────────────────────────────────────────────────────────

    public function login(string $baseUrl, string $username, string $password): array
    {
        try {
            // UBAH: dari '/login2.php' menjadi '/api/login' atau sesuai dokumentasi backend Anda
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

    public function register(string $baseUrl, string $username, string $email, string $password): array
    {
        try {
            // UBAH: dari '/register2.php' menjadi '/api/register'
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

    public function getAllProduk(): array
    {
        try {
            // UBAH: dari '/produk.php' menjadi '/api/produk'
            $res = $this->http()->get("{$this->baseUrl}/api/produk");
            return $res->json() ?? ['status' => 'error', 'data' => []];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage(), 'data' => []];
        }
    }

    public function getProdukById(int $id): array
    {
        try {
            // UBAH: menggunakan RESTful style '/api/produk/{id}' atau tetap passing query
$res = $this->http()->get("{$this->baseUrl}/api/produk/{$id}");
            return $res->json() ?? ['status' => 'error', 'data' => null];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    public function createProduk(array $data): array
    {
        try {
            // UBAH: dari '/produk.php' menjadi '/api/produk'
            $res = $this->http()->asJson()->post("{$this->baseUrl}/api/produk", $data);
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    public function updateProduk(int $id, array $data): array
    {
        try {
            // UBAH: menyesuaikan endpoint update backend Anda
$res = $this->http()->asJson()->put("{$this->baseUrl}/api/produk/{$id}", $data);
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }

    public function deleteProduk(int $id): array
    {
        try {
            // UBAH: menyesuaikan endpoint delete backend Anda
$res = $this->http()->delete("{$this->baseUrl}/api/produk/{$id}");
            return $res->json() ?? ['status' => 'error', 'message' => 'Tidak ada respons.'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()];
        }
    }
}