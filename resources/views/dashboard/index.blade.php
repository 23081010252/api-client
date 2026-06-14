@extends('layouts.app')
@section('title', 'Dashboard — Toko Roti Client')
@section('page-title', 'Dashboard')
@section('page-desc', 'Ringkasan data produk dari API')

@section('content')

{{-- Menampilkan 4 kotak statistik utama (Total Produk, Total Stok, Harga Min, Harga Max) --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7;color:#16a34a"><i class="fas fa-box-open"></i></div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dbeafe;color:#2563eb"><i class="fas fa-cubes"></i></div>
        <div class="stat-value">{{ number_format($stats['stok']) }}</div>
        <div class="stat-label">Total Stok</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="fas fa-tag"></i></div>
        <div class="stat-value">Rp {{ number_format($stats['harga_min']) }}</div>
        <div class="stat-label">Harga Termurah</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9fe;color:#7c3aed"><i class="fas fa-tags"></i></div>
        <div class="stat-value">Rp {{ number_format($stats['harga_max']) }}</div>
        <div class="stat-label">Harga Tertinggi</div>
    </div>
</div>

{{-- Layout grid dua kolom untuk menampilkan daftar produk terbaru dan stok kritis --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    {{-- Tabel Produk Terbaru: Menampilkan 5 produk terakhir yang diinput --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-clock" style="color:#16a34a;margin-right:6px"></i>Produk Terbaru</h3>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0">
            @if(count($terbaru) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($terbaru as $p)
                    <tr>
                        <td style="font-weight:500">{{ $p['nama_produk'] }}</td>
                        <td>Rp {{ number_format($p['harga']) }}</td>
                        <td>
                            <span class="badge {{ (int)$p['stok'] < 10 ? 'badge-yellow' : 'badge-green' }}">
                                {{ $p['stok'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada produk</p></div>
            @endif
        </div>
    </div>

    {{-- Tabel Stok Rendah: Menampilkan produk dengan stok < 10 untuk peringatan --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle" style="color:#d97706;margin-right:6px"></i>Stok Rendah</h3>
            <span class="badge badge-yellow">{{ count($stokRendah) }} produk</span>
        </div>
        <div class="card-body" style="padding:0">
            @if(count($stokRendah) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokRendah as $p)
                    <tr>
                        <td style="font-weight:500">{{ $p['nama_produk'] }}</td>
                        <td><span class="badge badge-gray">{{ $p['nama_kategori'] ?? '-' }}</span></td>
                        <td><span class="badge badge-red">{{ $p['stok'] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#16a34a"></i><p>Semua stok aman</p></div>
            @endif
        </div>
    </div>

</div>

{{-- Panel Informasi Koneksi API: Menampilkan konfigurasi yang sedang aktif dari sesi --}}
<div class="card" style="margin-top:20px">
    <div class="card-header">
        <h3><i class="fas fa-plug" style="color:#16a34a;margin-right:6px"></i>Informasi Koneksi API</h3>
        <a href="{{ route('settings') }}" class="btn btn-secondary btn-sm"><i class="fas fa-cog"></i> Ubah</a>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;font-size:13px">
            <div>
                <div style="color:#6b7280;margin-bottom:4px;font-size:12px;font-weight:500">API Base URL</div>
                <div style="font-family:monospace;background:#f3f4f6;padding:8px 12px;border-radius:6px;word-break:break-all">
                    {{ session('api_base_url','-') }}
                </div>
            </div>
            <div>
                <div style="color:#6b7280;margin-bottom:4px;font-size:12px;font-weight:500">API Key (aktif)</div>
                <div style="font-family:monospace;background:#f3f4f6;padding:8px 12px;border-radius:6px;word-break:break-all">
                    {{ session('api_key','-') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection