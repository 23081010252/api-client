@extends('layouts.app')
@section('title', 'Edit Produk — Toko Roti Client')
@section('page-title', 'Edit Produk')
@section('page-desc', 'Data akan dikirim ke API Server melalui PUT request')

@section('content')

<div style="max-width:560px">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-edit" style="color:#16a34a;margin-right:6px"></i>Edit Produk #{{ $produk['id'] }}</h3>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">

            <div style="background:#fefce8;border:1px solid #fde68a;border-radius:6px;padding:10px 14px;margin-bottom:20px;font-size:12.5px;color:#92400e">
                <i class="fas fa-info-circle"></i>
                Data akan dikirim via <strong>PUT</strong> ke
                <code style="background:#fef3c7;padding:1px 6px;border-radius:3px">{{ session('api_base_url') }}/produk.php?id={{ $produk['id'] }}</code>
            </div>

            <form method="POST" action="{{ route('produk.update', $produk['id']) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">ID Kategori <span class="required">*</span></label>
                    <input type="number" name="id_kategori"
                        class="form-control {{ $errors->has('id_kategori') ? 'is-invalid' : '' }}"
                        value="{{ old('id_kategori', $produk['id_kategori']) }}"
                        min="1" required>
                    @error('id_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if(!empty($kategoriList))
                    <div class="form-text">
                        Kategori tersedia:
                        @foreach($kategoriList as $id => $nama)
                            <span style="background:#f3f4f6;padding:1px 6px;border-radius:3px;font-size:11px">{{ $id }} = {{ $nama }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Produk <span class="required">*</span></label>
                    <input type="text" name="nama_produk"
                        class="form-control {{ $errors->has('nama_produk') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_produk', $produk['nama_produk']) }}"
                        maxlength="150" required>
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="harga"
                            class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                            value="{{ old('harga', $produk['harga']) }}"
                            min="0" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok <span class="required">*</span></label>
                        <input type="number" name="stok"
                            class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}"
                            value="{{ old('stok', $produk['stok']) }}"
                            min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Info produk saat ini --}}
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:12px;margin-bottom:16px;font-size:12px;color:#6b7280">
                    <strong style="display:block;margin-bottom:6px">Data saat ini di server:</strong>
                    Kategori: <strong>{{ $produk['nama_kategori'] ?? $produk['id_kategori'] }}</strong> &nbsp;|&nbsp;
                    Dibuat: <strong>{{ $produk['created_at'] ?? '-' }}</strong>
                </div>

                <div style="display:flex;gap:10px">
                    <button type="submit" class="btn btn-warning" style="background:#d97706;color:#fff;border-color:#d97706">
                        <i class="fas fa-save"></i> Update ke API
                    </button>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
