<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class AuthController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'api_key' => 'required|string',
    ]);

    // Simpan API key ke session, langsung tanpa hit web server
    session([
        'api_key'      => $request->api_key,
        'api_base_url' => config('services.api.base_url'),
    ]);

    return redirect()->route('dashboard');
}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
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

        $result = $this->api->register(
            $request->api_base_url,
            $request->username,
            $request->email,
            $request->password
        );

        if (($result['status'] ?? '') === 'success') {
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
        }

        return back()
            ->withInput($request->only('api_base_url', 'username', 'email'))
            ->with('error', $result['message'] ?? 'Registrasi gagal, coba lagi.');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
