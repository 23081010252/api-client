@extends('layouts.guest')
@section('title', 'Login — Toko Roti Client')

@section('content')
<div class="auth-card">
    <h2>Masuk ke Akun Anda</h2>
    <p class="subtitle">Masukkan URL API Server dan kredensial Anda</p>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="api-info-box">
        <strong><i class="fas fa-info-circle"></i> Cara Mendapatkan API Key</strong>
        <p>Daftar/login ke <b>Web Admin/Server</b> terlebih dahulu, lalu salin API Key yang digenerate otomatis setelah login. Masukkan URL server dan login di bawah.</p>
    </div>

<form method="POST" action="{{ route('login.post') }}">
    @csrf
    <label>API Key</label>
    <input type="text" name="api_key" 
           placeholder="Paste API Key dari Web Server (contoh: ROTI-abc123...)">
    <button type="submit">Masuk</button>
</form>

    <!-- <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">URL API Server <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-server input-icon"></i>
                <input type="url" name="api_base_url"
                    class="form-control {{ $errors->has('api_base_url') ? 'is-invalid' : '' }}"
                    placeholder="http://localhost/toko_roti"
                    value="{{ old('api_base_url', 'http://localhost/toko_roti') }}"
                    required>
            </div>
            @error('api_base_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">URL base dari web server/admin API Anda</div>
        </div>

        <hr class="divider">

        <div class="form-group">
            <label class="form-label">Username <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="username"
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="Username Anda"
                    value="{{ old('username') }}"
                    required autofocus>
            </div>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Password Anda"
                    required>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt"></i> Masuk & Ambil API Key
        </button>
    </form> -->
</div>

{{-- <div class="auth-footer">
    Belum punya akun?
    <a href="{{ route('register') }}">Daftar sekarang</a>
</div> --}}
@endsection
