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
        :root{
            --primary:#16a34a;--primary-dark:#15803d;--primary-light:#dcfce7;
            --danger:#dc2626;--danger-light:#fee2e2;
            --warning:#d97706;--warning-light:#fef3c7;
            --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;
            --gray-300:#d1d5db;--gray-400:#9ca3af;--gray-500:#6b7280;
            --gray-600:#4b5563;--gray-700:#374151;--gray-800:#1f2937;--gray-900:#111827;
            --sidebar-w:240px;--radius:8px;--shadow:0 1px 3px rgba(0,0,0,.1);
        }
        body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--gray-800)}
        /* ── Sidebar ── */
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:var(--gray-900);display:flex;flex-direction:column;z-index:100}
        .sidebar-brand{display:flex;align-items:center;gap:10px;padding:20px;border-bottom:1px solid rgba(255,255,255,.08)}
        .logo{width:36px;height:36px;background:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:17px;color:#fff;flex-shrink:0}
        .sidebar-brand h1{font-size:14px;font-weight:600;color:#fff}
        .sidebar-brand small{font-size:11px;color:var(--gray-500)}
        .sidebar-nav{flex:1;padding:12px 0;overflow-y:auto}
        .nav-section{padding:4px 16px 6px;font-size:10px;font-weight:600;color:var(--gray-600);text-transform:uppercase;letter-spacing:.08em}
        .nav-item{display:flex;align-items:center;gap:10px;padding:9px 20px;font-size:13px;color:var(--gray-400);text-decoration:none;transition:.15s}
        .nav-item:hover{background:rgba(255,255,255,.06);color:#fff}
        .nav-item.active{background:rgba(22,163,74,.15);color:var(--primary);border-right:3px solid var(--primary)}
        .nav-item i{width:18px;text-align:center;font-size:13px}
        .sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.08)}
        .sidebar-user{display:flex;align-items:center;gap:10px;margin-bottom:12px}
        .avatar{width:34px;height:34px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff;font-weight:600;flex-shrink:0}
        .sidebar-user-info .uname{font-size:13px;color:#fff;font-weight:500}
        .sidebar-user-info .urole{font-size:11px;color:var(--gray-500)}
        .btn-logout{width:100%;padding:7px;border:1px solid rgba(255,255,255,.1);border-radius:6px;background:transparent;color:var(--gray-400);font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:.15s;font-family:inherit}
        .btn-logout:hover{background:rgba(220,38,38,.15);color:#f87171;border-color:rgba(220,38,38,.3)}
        /* ── Main ── */
        .main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:#fff;border-bottom:1px solid var(--gray-200);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
        .topbar-left h2{font-size:16px;font-weight:600;color:var(--gray-900)}
        .topbar-left p{font-size:12px;color:var(--gray-500);margin-top:1px}
        .api-badge{display:flex;align-items:center;gap:6px;background:var(--gray-100);border:1px solid var(--gray-200);border-radius:20px;padding:5px 12px;font-size:11px;color:var(--gray-600);font-family:monospace}
        .api-badge .dot{width:7px;height:7px;background:var(--primary);border-radius:50%;flex-shrink:0}
        .content{flex:1;padding:24px 28px}
        /* ── Alert ── */
        .alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius);margin-bottom:20px;font-size:13px}
        .alert-success{background:var(--primary-light);color:#166534;border:1px solid #bbf7d0}
        .alert-error{background:var(--danger-light);color:#991b1b;border:1px solid #fecaca}
        .alert-warning{background:var(--warning-light);color:#92400e;border:1px solid #fde68a}
        /* ── Card ── */
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);box-shadow:var(--shadow)}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
        .card-header h3{font-size:14px;font-weight:600;color:var(--gray-900)}
        .card-body{padding:20px}
        /* ── Stats ── */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-bottom:24px}
        .stat-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow)}
        .stat-icon{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px}
        .stat-value{font-size:22px;font-weight:700;color:var(--gray-900)}
        .stat-label{font-size:12px;color:var(--gray-500);margin-top:2px}
        /* ── Table ── */
        .table-wrap{overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:13px}
        thead th{padding:10px 14px;text-align:left;font-size:11px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.04em;background:var(--gray-50);border-bottom:1px solid var(--gray-200)}
        tbody td{padding:11px 14px;border-bottom:1px solid var(--gray-100);vertical-align:middle}
        tbody tr:last-child td{border-bottom:none}
        tbody tr:hover{background:var(--gray-50)}
        /* ── Badge ── */
        .badge{display:inline-flex;align-items:center;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:500}
        .badge-green{background:#dcfce7;color:#166534}
        .badge-red{background:#fee2e2;color:#991b1b}
        .badge-yellow{background:#fef3c7;color:#92400e}
        .badge-blue{background:#dbeafe;color:#1e40af}
        .badge-gray{background:var(--gray-100);color:var(--gray-600)}
        /* ── Button ── */
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;border:1px solid transparent;transition:.15s;text-decoration:none;font-family:inherit}
        .btn-primary{background:var(--primary);color:#fff;border-color:var(--primary)}
        .btn-primary:hover{background:var(--primary-dark)}
        .btn-danger{background:var(--danger);color:#fff;border-color:var(--danger)}
        .btn-danger:hover{background:#b91c1c}
        .btn-secondary{background:#fff;color:var(--gray-700);border-color:var(--gray-300)}
        .btn-secondary:hover{background:var(--gray-50)}
        .btn-warning{background:var(--warning);color:#fff;border-color:var(--warning)}
        .btn-sm{padding:5px 10px;font-size:12px}
        /* ── Form ── */
        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:13px;font-weight:500;color:var(--gray-700);margin-bottom:5px}
        .required{color:var(--danger)}
        .form-control{width:100%;padding:9px 12px;border:1px solid var(--gray-300);border-radius:6px;font-size:13px;font-family:inherit;color:var(--gray-900);background:#fff;transition:.15s}
        .form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(22,163,74,.1)}
        .form-control.is-invalid{border-color:var(--danger)}
        .form-text{font-size:11.5px;color:var(--gray-500);margin-top:3px}
        .invalid-feedback{font-size:11.5px;color:var(--danger);margin-top:3px}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        /* ── Filter ── */
        .filter-bar{display:flex;gap:10px;align-items:center;margin-bottom:16px;flex-wrap:wrap}
        /* ── Empty ── */
        .empty-state{text-align:center;padding:48px 24px;color:var(--gray-500)}
        .empty-state i{font-size:36px;color:var(--gray-300);margin-bottom:10px;display:block}
        .empty-state p{font-size:13px}
        /* ── Modal ── */
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;align-items:center;justify-content:center}
        .modal-overlay.show{display:flex}
        .modal{background:#fff;border-radius:10px;padding:24px;max-width:420px;width:calc(100% - 32px);box-shadow:0 20px 60px rgba(0,0,0,.2)}
        .modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
        .modal-title{font-size:15px;font-weight:600}
        .modal-close{background:none;border:none;font-size:18px;cursor:pointer;color:var(--gray-400);padding:2px;line-height:1;font-family:inherit}
        .modal-footer{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo"><i class="fas fa-bread-slice"></i></div>
        <div>
            <h1>Toko Roti</h1>
            <small>Web Client</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Menu</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
            <i class="fas fa-box-open"></i> Produk Roti
        </a>
        <div class="nav-section" style="margin-top:8px">Koneksi</div>
        <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
            <i class="fas fa-plug"></i> Pengaturan API
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(session('username','U'),0,1)) }}</div>
            <div class="sidebar-user-info">
                <div class="uname">{{ session('username','User') }}</div>
                <div class="urole">Client User</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <h2>@yield('page-title','Dashboard')</h2>
            <p>@yield('page-desc','')</p>
        </div>
        <div class="api-badge">
            <div class="dot"></div>
            {{ Str::limit(session('api_base_url','-'),50) }}
        </div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
