@extends('layouts.guest')
@section('title', 'Login — Toko Roti Client')

@section('content')
<div class="auth-card">
    <h2>Masuk ke Akun Anda</h2>
    <p class="subtitle">Masukkan URL API Server dan kredensial Anda</p>

    {{-- Blok untuk menampilkan notifikasi sukses dari proses registrasi atau logout --}}
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Blok untuk menampilkan pesan kesalahan dari proses login yang gagal --}}
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Panduan singkat bagi user agar memahami cara mendapatkan API Key --}}
    <div class="api-info-box">
        <strong><i class="fas fa-info-circle"></i> Cara Mendapatkan API Key</strong>
        <p>Daftar/login ke <b>Web Admin/Server</b> terlebih dahulu, lalu salin API Key yang digenerate otomatis setelah login. Masukkan URL server dan login di bawah.</p>
    </div>

    {{-- Form login yang mengirim data POST ke route 'login.post' --}}
    <form method="POST" action="{{ route('login.post') }}">
        @csrf {{-- Token keamanan untuk mencegah serangan CSRF --}}
        
        <label>API Key</label>
        {{-- Input API Key yang akan diverifikasi oleh AuthController --}}
        <input type="text" name="api_key" 
               placeholder="Paste API Key dari Web Server (contoh: ROTI-abc123...)" required>
               
        <button type="submit">Masuk</button>
    </form>

</div>
@endsection