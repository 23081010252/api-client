<!-- @extends('layouts.guest')
@section('title', 'Daftar — Toko Roti Client')

@section('content')
<div class="auth-card">
    <h2>Buat Akun Baru</h2>
    <p class="subtitle">Daftar ke Web Server API Toko Roti</p>

    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="api-info-box">
        <strong><i class="fas fa-info-circle"></i> Registrasi via API</strong>
        <p>Data Anda akan didaftarkan langsung ke server API. Setelah berhasil, API Key akan otomatis digenerate saat Anda login.</p>
    </div>

    <form method="POST" action="{{ route('register.post') }}">
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
        </div>

        <hr class="divider">

        <div class="form-group">
            <label class="form-label">Username <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="username"
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    placeholder="Minimal 3 karakter"
                    value="{{ old('username') }}"
                    required>
            </div>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="email@example.com"
                    value="{{ old('email') }}"
                    required>
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Minimal 6 karakter"
                    required>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password"
                    required>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-user-plus"></i> Daftar Akun
        </button>
    </form>
</div>

<div class="auth-footer">
    Sudah punya akun?
    <a href="{{ route('login') }}">Login di sini</a>
</div>
@endsection -->
