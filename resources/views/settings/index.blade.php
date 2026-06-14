@extends('layouts.app')
@section('title', 'Pengaturan API — Toko Roti Client')
@section('page-title', 'Pengaturan Koneksi API')
@section('page-desc', 'Kelola URL server dan API Key yang digunakan')

@section('content')

<div style="max-width:640px">

    {{-- Panduan cara mendapatkan API Key --}}
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h3><i class="fas fa-book" style="color:#2563eb;margin-right:6px"></i>Cara Mendapatkan API Key</h3>
        </div>
        <div class="card-body">
            <ol style="font-size:13px;color:#374151;line-height:1.9;padding-left:18px">
                <li>Buka browser dan akses <strong>Web Admin/Server API</strong> (contoh: <code style="background:#f3f4f6;padding:1px 6px;border-radius:4px">http://localhost/toko_roti</code>)</li>
                <li>Daftar akun baru atau login jika sudah punya akun</li>
                <li>Setelah login berhasil, API Key akan ditampilkan atau bisa dilihat di halaman profil/dashboard admin</li>
                <li>Salin API Key tersebut, lalu tempelkan di kolom <strong>"API Key"</strong> di bawah ini</li>
                <li>Klik <strong>Simpan Pengaturan</strong></li>
            </ol>
            <div style="background:#fef3c7;border:1px solid #fde68a;border-radius:6px;padding:10px 14px;margin-top:12px;font-size:12.5px;color:#92400e">
                <i class="fas fa-lightbulb"></i> <strong>Tips:</strong>
                Saat login melalui halaman <a href="{{ route('login') }}" style="color:#92400e;font-weight:600">Login</a> di sini,
                API Key akan otomatis tersimpan dari respons server. Halaman ini berguna jika Anda ingin mengganti URL atau API Key secara manual.
            </div>
        </div>
    </div>

    {{-- Form Pengaturan --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-sliders-h" style="color:#16a34a;margin-right:6px"></i>Konfigurasi API</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">
                        URL API Server <span class="required">*</span>
                    </label>
                    <input type="url" name="api_base_url"
                        class="form-control {{ $errors->has('api_base_url') ? 'is-invalid' : '' }}"
                        value="{{ old('api_base_url', session('api_base_url')) }}"
                        placeholder="http://localhost/toko_roti"
                        required>
                    @error('api_base_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">URL base dari server API tanpa slash di akhir. Contoh: <code>http://localhost/toko_roti</code></div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        API Key <span class="required">*</span>
                    </label>
                    <input type="text" name="api_key"
                        class="form-control {{ $errors->has('api_key') ? 'is-invalid' : '' }}"
                        value="{{ old('api_key', session('api_key')) }}"
                        placeholder="ROTI-xxxxxxxxxxxxxxxx"
                        style="font-family:monospace"
                        required>
                    @error('api_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        API Key didapat setelah login ke server API. Format: <code>ROTI-xxxxxxxxxxxx</code>
                    </div>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Status Koneksi Saat Ini --}}
    <div class="card" style="margin-top:20px">
        <div class="card-header">
            <h3><i class="fas fa-info-circle" style="color:#6b7280;margin-right:6px"></i>Status Koneksi Saat Ini</h3>
        </div>
        <div class="card-body">
            <div style="font-size:13px">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#16a34a;flex-shrink:0"></div>
                    <span style="color:#6b7280;width:80px;flex-shrink:0">Base URL</span>
                    <code style="background:#f3f4f6;padding:4px 10px;border-radius:4px;font-size:12px;word-break:break-all">
                        {{ session('api_base_url', 'Belum diset') }}
                    </code>
                </div>
                <div style="display:flex;align-items:center;gap:8px">
                    <div style="width:8px;height:8px;border-radius:50%;background:#16a34a;flex-shrink:0"></div>
                    <span style="color:#6b7280;width:80px;flex-shrink:0">API Key</span>
                    <code style="background:#f3f4f6;padding:4px 10px;border-radius:4px;font-size:12px;word-break:break-all">
                        {{ session('api_key', 'Belum diset') }}
                    </code>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
