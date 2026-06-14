<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Roti Client')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--primary:#16a34a;--primary-dark:#15803d;--gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;--gray-400:#9ca3af;--gray-500:#6b7280;--gray-700:#374151;--gray-900:#111827;--danger:#dc2626;--danger-light:#fee2e2;--radius:8px}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#052e16 0%,#14532d 50%,#052e16 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .auth-wrap{width:100%;max-width:440px}
        .auth-brand{text-align:center;margin-bottom:24px}
        .auth-logo{width:56px;height:56px;background:#16a34a;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;margin:0 auto 12px}
        .auth-brand h1{font-size:20px;font-weight:700;color:#fff}
        .auth-brand p{font-size:13px;color:rgba(255,255,255,.5);margin-top:2px}
        .auth-card{background:#fff;border-radius:12px;padding:28px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
        .auth-card h2{font-size:16px;font-weight:600;color:var(--gray-900);margin-bottom:6px}
        .auth-card .subtitle{font-size:13px;color:var(--gray-500);margin-bottom:22px}
        .form-group{margin-bottom:14px}
        .form-label{display:block;font-size:13px;font-weight:500;color:var(--gray-700);margin-bottom:5px}
        .form-label .required{color:var(--danger)}
        .form-control{width:100%;padding:9px 12px;border:1px solid var(--gray-300);border-radius:6px;font-size:13px;font-family:inherit;color:var(--gray-900);transition:.15s}
        .form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(22,163,74,.12)}
        .form-control.is-invalid{border-color:var(--danger)}
        .invalid-feedback{font-size:11.5px;color:var(--danger);margin-top:3px}
        .form-text{font-size:11.5px;color:var(--gray-500);margin-top:3px}
        .input-with-icon{position:relative}
        .input-with-icon .form-control{padding-left:38px}
        .input-with-icon .input-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:13px}
        .btn-submit{width:100%;padding:10px;background:var(--primary);color:#fff;border:none;border-radius:6px;font-size:14px;font-weight:500;cursor:pointer;transition:.15s;font-family:inherit;margin-top:4px}
        .btn-submit:hover{background:var(--primary-dark)}
        .alert{display:flex;align-items:center;gap:9px;padding:11px 14px;border-radius:6px;margin-bottom:16px;font-size:13px}
        .alert-success{background:#dcfce7;color:#166534;border:1px solid #bbf7d0}
        .alert-error{background:var(--danger-light);color:#991b1b;border:1px solid #fecaca}
        .auth-footer{text-align:center;margin-top:20px;font-size:13px;color:rgba(255,255,255,.5)}
        .auth-footer a{color:rgba(255,255,255,.8);text-decoration:none;font-weight:500}
        .auth-footer a:hover{color:#fff}
        .divider{border:none;border-top:1px solid var(--gray-100);margin:16px 0}
        .api-info-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;padding:10px 12px;margin-bottom:16px}
        .api-info-box p{font-size:12px;color:#166534;line-height:1.5}
        .api-info-box strong{font-size:11px;display:block;margin-bottom:3px;color:#14532d}
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-brand">
        <div class="auth-logo"><i class="fas fa-bread-slice"></i></div>
        <h1>Toko Roti</h1>
        <p>Web Client — Sistem Manajemen Produk</p>
    </div>
    @yield('content')
</div>
</body>
</html>
