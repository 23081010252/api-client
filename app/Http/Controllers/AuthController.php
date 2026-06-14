<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AuthController extends Controller
{
    // Konstruktor untuk menyuntikkan layanan ApiService ke dalam controller
    public function __construct(protected ApiService $api) {}

    // Menampilkan halaman login awal
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses logika autentikasi login
    public function login(Request $request)
    {
        // Validasi input form login
        $request->validate([
            'api_key' => 'required|string',
        ]);

        // 1. Simpan sementara ke session agar method http() di ApiService bisa membaca token ini saat pengujian
        session([
            'api_key'      => $request->api_key,
            'api_base_url' => config('services.api.base_url'),
        ]);

        // 2. Lakukan uji coba hit ke web server untuk cek validitas API Key
        $testResult = $this->api->getAllProduk();

        // Jika respons dari API server menandakan gagal/tidak sukses
        if (($testResult['status'] ?? '') === 'error' || isset($testResult['message']) && stripos($testResult['message'], 'API Key tidak ditemukan') !== false) {
            // Hapus session jika API key tidak valid
            $request->session()->flush();

            return back()
                ->withInput()
                ->with('error', $testResult['message'] ?? 'API Key salah atau tidak terdaftar di server.');
        }

        // 3. Jika lolos validasi server, langsung arahkan ke dashboard
        return redirect()->route('dashboard');
    }

    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses logika registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input data registrasi dengan pesan error kustom
        $request->validate([
            'api_base_url'          => 'required|url',
            'username'              => 'required|string|min:3',
            'email'                 => 'required|email',
            'password'              => 'required|string|min:6|confirmed',
        ], [
            'api_base_url.required'  => 'URL API wajib diisi.',
            'api_base_url.url'       => 'Format URL tidak valid.',
            'username.required'      => 'Username wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        // Mengirim data registrasi ke API Server
        $result = $this->api->register(
            $request->api_base_url,
            $request->username,
            $request->email,
            $request->password
        );

        // Jika registrasi di server sukses, arahkan ke halaman login
        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
        }

        // Jika gagal, kembali ke halaman register dengan membawa input sebelumnya
        return back()
            ->withInput($request->only('api_base_url', 'username', 'email'))
            ->with('error', $result['message'] ?? 'Registrasi gagal, coba lagi.');
    }

    // Menghapus seluruh sesi pengguna dan mengarahkan ke halaman login
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}