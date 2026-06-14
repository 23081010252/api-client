# 🍞 Toko Roti — Web Client (Laravel 12)

Website Client yang mengkonsumsi API dari Web Server/Admin Toko Roti.
Data produk diambil, ditambah, diubah, dan dihapus **seluruhnya melalui API**.

---

## Struktur Proyek

```
toko_roti_client/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       ← Login, Register, Logout via API
│   │   │   ├── DashboardController.php  ← Statistik produk
│   │   │   ├── ProdukController.php     ← CRUD Produk via API
│   │   │   └── SettingsController.php   ← Kelola API URL & Key
│   │   └── Middleware/
│   │       ├── CheckApiAuth.php         ← Proteksi route (cek session api_key)
│   │       └── GuestApi.php             ← Redirect jika sudah login
│   └── Services/
│       └── ApiService.php               ← Semua komunikasi HTTP ke API
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                ← Layout utama (sidebar + topbar)
│   │   └── guest.blade.php              ← Layout halaman auth
│   ├── auth/
│   │   ├── login.blade.php              ← Halaman Login
│   │   └── register.blade.php           ← Halaman Register
│   ├── dashboard/
│   │   └── index.blade.php              ← Dashboard statistik
│   ├── produk/
│   │   ├── index.blade.php              ← Daftar produk + filter + hapus
│   │   ├── create.blade.php             ← Form tambah produk
│   │   └── edit.blade.php               ← Form edit produk
│   └── settings/
│       └── index.blade.php              ← Pengaturan API URL & Key
└── routes/
    └── web.php                          ← Semua route
```

---

## Cara Instalasi

### 1. Clone / Salin Project

```bash
cp -r toko_roti_client /var/www/html/
# atau taruh di folder htdocs/toko_roti_client (XAMPP)
```

### 2. Install Dependency

```bash
cd toko_roti_client
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Jalankan Server

```bash
php artisan serve --port=8001
```

Akses: **http://localhost:8001**

---

## Alur Penggunaan

### A. Login Otomatis (Rekomendasi)

1. Buka `http://localhost:8001/login`
2. Isi **URL API Server** → contoh: `http://localhost/toko_roti_api`
3. Isi **Username** dan **Password** (akun yang sudah terdaftar di server API)
4. Klik **Masuk** → sistem otomatis mengambil API Key dari respons server
5. Langsung masuk ke dashboard

### B. Ganti API Key Manual (jika perlu)

1. Login terlebih dahulu
2. Buka menu **Pengaturan API** di sidebar
3. Ubah URL Base atau API Key sesuai kebutuhan
4. Klik **Simpan Pengaturan**

---

## Endpoint API yang Digunakan

| Method | Endpoint              | Fungsi                  | Auth        |
|--------|-----------------------|-------------------------|-------------|
| POST   | `/register2.php`      | Daftar akun baru        | Tidak       |
| POST   | `/login2.php`         | Login & dapat API Key   | Tidak       |
| GET    | `/produk.php`         | Ambil semua produk      | X-API-KEY   |
| GET    | `/produk.php?id=1`    | Ambil produk by ID      | X-API-KEY   |
| POST   | `/produk.php`         | Tambah produk baru      | X-API-KEY   |
| PUT    | `/produk.php?id=1`    | Update produk           | X-API-KEY   |
| DELETE | `/produk.php?id=1`    | Hapus produk            | X-API-KEY   |

---

## Fitur

- ✅ Login via API (URL server diinput sendiri oleh user)
- ✅ Register via API
- ✅ Dashboard statistik (total produk, stok, harga min/max)
- ✅ Daftar produk dengan filter pencarian & kategori
- ✅ Tambah produk (POST ke API)
- ✅ Edit produk (PUT ke API)
- ✅ Hapus produk dengan konfirmasi modal (DELETE ke API)
- ✅ Halaman Pengaturan API (ganti URL & API Key kapan saja)
- ✅ Notifikasi stok rendah di dashboard
- ✅ Semua request pakai header `X-API-KEY`

---

## Catatan CORS

Jika web client dan API berada di domain/port berbeda, tambahkan header CORS
di file `produk.php`, `login2.php`, dan `register2.php` pada server API:

```php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
```
