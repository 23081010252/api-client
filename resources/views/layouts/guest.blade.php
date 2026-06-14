<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Roti Client')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    @vite(['resources/css/app.css'])

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #6B3F2A;          /* Cokelat Utama */
            --primary-dark: #3B1F0F;     /* Cokelat Tua */
            --cream-light: #FAF5EC;      /* Putih Cream Hangat */
            --cream-dark: #F5ECD7;       /* Cream Aksen */
            --sage: #7D9B76;             /* Hijau Sage */
            --sage-dark: #6b8765;
            --danger: #dc2626;
        }

        /* Latar Belakang Luar Berwarna Cokelat Tua */
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--primary-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrap {
            width: 100%;
            max-width: 440px;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 24px;
        }

        /* Container Logo Menggunakan Flexbox agar Ikon Pas di Tengah */
        .auth-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 12px;
        }

        /* Penyelarasan Class stat-icon dark dari Request Kamu */
        .stat-icon.dark {
            width: 100%;
            height: 100%;
            background: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .auth-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--cream-light);
        }

        .auth-brand p {
            font-size: 13px;
            color: rgba(250, 245, 236, 0.75);
            margin-top: 4px;
        }

        /* Kotak Putih Utama Pembungkus Login */
        .auth-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            padding: 32px;
        }

        /* Otomatis Menargetkan Elemen di Dalam View Login */
        .auth-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 6px;
        }

        .auth-card p {
            font-size: 13px;
            color: #71717a;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Mengubah Tampilan Kotak Info Petunjuk Menjadi Lembut */
        .auth-card .api-info-box, 
        .auth-card div[class*="info"], 
        .auth-card div:has(strong) {
            background: var(--cream-light);
            border-left: 4px solid var(--sage);
            padding: 12px 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 12.5px;
            color: var(--primary-dark);
            line-height: 1.5;
            text-align: left;
        }

        .auth-card .api-info-box strong,
        .auth-card div[class*="info"] strong {
            color: var(--primary);
            display: block;
            margin-bottom: 4px;
        }

        /* Membungkus Struktur Form Otomatis dengan Kotak Cokelat Premium */
        .auth-card form {
            display: block;
            text-align: left;
            background: var(--primary);
            border-radius: 12px;
            padding: 24px;
            color: var(--cream-light);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Mengubah Warna Teks Label di Dalam Kotak Form Cokelat */
        .auth-card form label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--cream-dark);
            margin-bottom: 8px;
        }

        /* Memperbaiki Input API Key Agar Putih, Bersih, Lebar & Rapi */
        .auth-card form input[type="text"],
        .auth-card form input[type="url"],
        .auth-card form input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--cream-light);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            color: #27272a;
            background: #ffffff;
            outline: none;
            margin-bottom: 16px;
            transition: all 0.2s ease-in-out;
            display: block;
        }

        .auth-card form input[type="text"]:focus,
        .auth-card form input[type="url"]:focus,
        .auth-card form input[type="password"]:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 3px rgba(125, 155, 118, 0.4);
        }

        /* Memperbaiki Tombol Masuk Menjadi Hijau Sage Lebar Kontras */
        .auth-card form button,
        .auth-card form button[type="submit"] {
            width: 100%;
            padding: 11px;
            background: var(--sage);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
            margin-top: 4px;
        }

        .auth-card form button:hover,
        .auth-card form button[type="submit"]:hover {
            background: var(--sage-dark);
        }

        /* Notifikasi Alert Validasi Laravel */
        .auth-card .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            margin-bottom: 16px;
            text-align: left;
        }
        .auth-card .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .auth-card .alert-error, .auth-card .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-brand">
        <div class="auth-logo">
            <div class="stat-icon dark">
                <span class="material-icons" style="font-size: 36px; color: var(--cream-light);">bakery_dining</span>
            </div>
        </div>
        <h1>Toko Roti</h1>
        <p>Web Client — Sistem Manajemen Produk</p>
    </div>

    <div class="auth-card">
        @yield('content')
    </div>
</div>
</body>
</html>