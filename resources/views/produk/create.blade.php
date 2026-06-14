@extends('layouts.app')
@section('title', 'Tambah Produk — Toko Roti Client')
@section('page-title', 'Tambah Produk Baru')
@section('page-desc', 'Data akan dikirim ke API Server melalui POST request')

@section('content')

<div style="max-width:560px">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle" style="color:#16a34a;margin-right:6px"></i>Form Tambah Produk</h3>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">

            {{-- Pesan error jika terjadi masalah pada koneksi atau validasi di server API --}}
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Informasikan user tentang endpoint yang dituju agar proses debugging lebih mudah --}}
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:10px 14px;margin-bottom:20px;font-size:12.5px;color:#166534">
                <i class="fas fa-info-circle"></i>
                Data akan dikirim via <strong>POST</strong> ke
                <code style="background:#dcfce7;padding:1px 6px;border-radius:3px">{{ session('api_base_url') }}/produk.php</code>
                dengan header <code style="background:#dcfce7;padding:1px 6px;border-radius:3px">X-API-KEY</code>
            </div>

            {{-- Form untuk menginput data produk baru --}}
            <form method="POST" action="{{ route('produk.store') }}">
                @csrf {{-- Token keamanan untuk perlindungan CSRF --}}

                <div class="form-group">
                    <label class="form-label">Kategori Roti <span class="required">*</span></label>
                    <select name="id_kategori" class="form-control {{ $errors->has('id_kategori') ? 'is-invalid' : '' }}" required>
                        <option value="">-- Pilih Kategori Roti --</option>
                        {{-- Iterasi daftar kategori yang didapat dari server API --}}
                        @if(!empty($kategoriList))
                            @foreach($kategoriList as $id => $nm)
                                <option value="{{ $id }}" {{ old('id_kategori') == $id ? 'selected' : '' }}>
                                    {{ $id }} — {{ $nm }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Pilih salah satu kategori aktif yang terdaftar pada sistem server.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Produk <span class="required">*</span></label>
                    <input type="text" name="nama_produk"
                        class="form-control {{ $errors->has('nama_produk') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_produk') }}"
                        placeholder="Contoh: Roti Tawar Gandum"
                        maxlength="150" required>
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Layout dua kolom untuk Harga dan Stok agar lebih efisien secara visual --}}
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="harga"
                            class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                            value="{{ old('harga') }}"
                            placeholder="Contoh: 15000"
                            min="0" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok <span class="required">*</span></label>
                        <input type="number" name="stok"
                            class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}"
                            value="{{ old('stok') }}"
                            placeholder="Contoh: 50"
                            min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="display:flex;gap:10px;margin-top:20px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim ke API
                    </button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection