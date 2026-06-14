@extends('layouts.app')
@section('title', 'Produk — Toko Roti Client')
@section('page-title', 'Daftar Produk Roti')
@section('page-desc', 'Data produk diambil dari API Server')

@section('content')

{{-- Menampilkan Ringkasan Statistik (Stats Mini) yang diambil dari API --}}
@isset($stats)
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
    <div class="stat-card" style="padding:14px">
        <div class="stat-label">Total Produk</div>
        <div class="stat-value" style="font-size:18px">{{ $stats['total'] }}</div>
    </div>
    <div class="stat-card" style="padding:14px">
        <div class="stat-label">Total Stok</div>
        <div class="stat-value" style="font-size:18px">{{ number_format($stats['stok']) }}</div>
    </div>
    <div class="stat-card" style="padding:14px">
        <div class="stat-label">Harga Min</div>
        <div class="stat-value" style="font-size:18px">Rp {{ number_format($stats['harga_min']) }}</div>
    </div>
    <div class="stat-card" style="padding:14px">
        <div class="stat-label">Harga Max</div>
        <div class="stat-value" style="font-size:18px">Rp {{ number_format($stats['harga_max']) }}</div>
    </div>
</div>
@endisset

{{-- Notifikasi jika terjadi kegagalan saat mengambil data dari API --}}
@isset($apiError)
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $apiError }}</div>
@endisset

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list" style="color:#16a34a;margin-right:6px"></i>Semua Produk</h3>
        <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
    <div class="card-body" style="padding:16px 20px">

        {{-- Form Filter: Mengirim request GET ke route yang sama untuk memfilter data --}}
        <form method="GET" action="{{ route('produk.index') }}" class="filter-bar">
            <input type="text" name="search" class="form-control"
                placeholder="&#xf002; Cari nama produk..."
                value="{{ $search ?? '' }}"
                style="max-width:220px">
            <select name="kategori" class="form-control" style="max-width:180px">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ ($filterKat ?? '') === $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary btn-sm">
                <i class="fas fa-filter"></i> Filter
            </button>
            @if(($search ?? '') || ($filterKat ?? ''))
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </form>

        {{-- Tabel Data Produk --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Ditambahkan</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $p)
                    <tr>
                        <td style="color:#9ca3af;font-size:12px">{{ $p['id'] }}</td>
                        <td style="font-weight:500">{{ $p['nama_produk'] }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $p['nama_kategori'] ?? '-' }}</span>
                        </td>
                        <td style="font-family:monospace">Rp {{ number_format($p['harga']) }}</td>
                        <td>
                            {{-- Logika warna badge berdasarkan jumlah stok --}}
                            <span class="badge {{ (int)$p['stok'] < 10 ? 'badge-red' : ((int)$p['stok'] < 30 ? 'badge-yellow' : 'badge-green') }}">
                                {{ $p['stok'] }}
                            </span>
                        </td>
                        <td style="color:#9ca3af;font-size:12px">
                            {{ isset($p['created_at']) ? \Carbon\Carbon::parse($p['created_at'])->format('d M Y') : '-' }}
                        </td>
                        <td style="text-align:center">
                            <div style="display:flex;gap:6px;justify-content:center">
                                <a href="{{ route('produk.edit', $p['id']) }}"
                                    class="btn btn-secondary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Tombol pemicu modal hapus (menggunakan data attributes) --}}
                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    data-id="{{ $p['id'] }}"
                                    data-nama="{{ $p['nama_produk'] }}"
                                    onclick="confirmDelete(this)"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>Tidak ada produk ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title"><i class="fas fa-trash" style="color:#dc2626;margin-right:8px"></i>Hapus Produk</span>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <p style="font-size:13.5px;color:#374151;line-height:1.5">
            Yakin ingin menghapus produk <strong id="deleteNama"></strong>?
            Tindakan ini tidak dapat dibatalkan dan data akan dihapus dari database.
        </p>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Fungsi JavaScript untuk menangani modal konfirmasi delete secara dinamis
function confirmDelete(button) {
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('deleteNama').textContent = '"' + nama + '"';
    document.getElementById('deleteForm').action = '/produk/' + id;
    document.getElementById('deleteModal').classList.add('show');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Menutup modal jika user menekan area luar modal atau tombol ESC
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endpush