<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Salam Admin Panel">
    <title>Salam &mdash; Admin</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand:       #1e40af;
            --brand-light: #eff6ff;
            --brand-hover: #1d3a9e;
            --surface:     #ffffff;
            --bg:          #f1f5f9;
            --sidebar-bg:  #4f5031;
            --sidebar-w:   240px;
            --text:        #1e293b;
            --muted:       #64748b;
            --border:      #e2e8f0;
            --success:     #16a34a;
            --danger:      #dc2626;
            --warning:     #d97706;
            --radius:      10px;
            --shadow:      0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── SIDEBAR ─────────────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 200;
            overflow-y: auto;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 22px 20px 18px;
            color: #fff;
            font-size: 18px; font-weight: 700;
            letter-spacing: -.3px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            text-decoration: none;
        }
        .sidebar-brand-icon {
            width: 100px; height: 100px;
            /*background: var(--brand);*/
            border-radius: 8px;
            display: grid; place-items: center;
            font-size: 16px; flex-shrink: 0;
        }
        .sidebar-section {
            padding: 18px 12px 4px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255,255,255,.28);
        }
        .nav-link-side {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            margin: 1px 0;
            border-radius: 7px;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            transition: background .15s, color .15s;
        }
        .nav-link-side:hover, .nav-link-side.active {
            background: rgba(255,255,255,.08);
            color: #fff;
        }
        .nav-link-side.active { color: #93c5fd; }
        .nav-icon { width: 18px; text-align: center; font-size: 15px; flex-shrink: 0; }
        .sidebar-footer {
            margin-top: auto;
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-footer a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 7px;
            color: rgba(255,255,255,.5);
            text-decoration: none;
            font-size: 13.5px;
            transition: background .15s, color .15s;
        }
        .sidebar-footer a:hover { background: rgba(220,38,38,.15); color: #fca5a5; }

        /* ── MAIN AREA ───────────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ── TOPBAR ──────────────────────────────────────── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow);
        }
        .topbar-title {
            font-size: 15px; font-weight: 600; color: var(--text);
        }
        .topbar-user {
            display: flex; align-items: center; gap: 10px;
        }
        .avatar {
            width: 34px; height: 34px;
            background: var(--brand);
            border-radius: 50%;
            display: grid; place-items: center;
            color: #fff; font-weight: 700; font-size: 13px;
        }
        .topbar-name { font-weight: 500; font-size: 13.5px; color: var(--text); }

        /* ── PAGE CONTENT ────────────────────────────────── */
        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ── ALERTS ──────────────────────────────────────── */
        .alert-pro {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            border: 1px solid transparent;
        }
        .alert-pro.success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
        .alert-pro.danger  { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

        /* ── CARDS ───────────────────────────────────────── */
        .card-pro {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .card-pro-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-pro-title {
            font-size: 15px; font-weight: 600; color: var(--text);
        }
        .card-pro-body { padding: 22px; }

        /* ── BUTTONS ─────────────────────────────────────── */
        .btn-pro {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13.5px; font-weight: 500;
            border: none; cursor: pointer;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
            line-height: 1.4;
        }
        .btn-pro:hover { opacity: .88; transform: translateY(-1px); }
        .btn-pro:active { transform: translateY(0); }
        .btn-primary-pro { background: var(--brand); color: #fff; }
        .btn-warning-pro { background: var(--warning); color: #fff; }
        .btn-danger-pro  { background: var(--danger);  color: #fff; }
        .btn-ghost       { background: var(--bg); color: var(--muted); border: 1px solid var(--border); }
        .btn-sm-pro      { padding: 5px 11px; font-size: 12.5px; }

        /* ── TABLE ───────────────────────────────────────── */
        .table-pro { width: 100%; border-collapse: collapse; }
        .table-pro thead th {
            padding: 11px 16px;
            font-size: 11px; font-weight: 600;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--muted);
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            text-align: left;
        }
        .table-pro tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text);
        }
        .table-pro tbody tr:last-child td { border-bottom: none; }
        .table-pro tbody tr:hover td { background: #f8fafc; }

        /* ── BADGES ──────────────────────────────────────── */
        .badge-pro {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px; font-weight: 600;
            letter-spacing: .02em;
        }
        .badge-green  { background: #dcfce7; color: #15803d; }
        .badge-red    { background: #fee2e2; color: #b91c1c; }
        .badge-blue   { background: #dbeafe; color: #1d4ed8; }
        .badge-gray   { background: #f1f5f9; color: var(--muted); }

        /* ── FORM ────────────────────────────────────────── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13px; font-weight: 500;
            color: var(--text);
            margin-bottom: 6px;
        }
        .form-label.required::after { content: ' *'; color: var(--danger); }
        .form-control-pro {
            display: block; width: 100%;
            padding: 9px 13px;
            font-size: 13.5px; font-family: inherit;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            background: var(--surface);
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }
        .form-control-pro:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(30,64,175,.1);
        }
        .form-hint { font-size: 12px; color: var(--muted); margin-top: 4px; }

        /* ── CHECKBOX ────────────────────────────────────── */
        .check-row {
            display: flex; align-items: center; gap: 9px;
            cursor: pointer;
            font-size: 13.5px;
        }
        .check-row input[type=checkbox] {
            width: 16px; height: 16px;
            accent-color: var(--brand);
        }

        /* ── AUTH PAGES ──────────────────────────────────── */
        .auth-wrap {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            /*background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);*/
            padding: 24px;
        }
        .auth-card {
            background: #fff;
            border-radius: 14px;
            padding: 40px 36px;
            width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .auth-logo {
            width: 48px; height: 48px;
            /*background: var(--brand);*/
            border-radius: 12px;
            display: grid; place-items: center;
            font-size: 22px;
            margin: 0 auto 22px; 
        }
        .auth-title { font-size: 22px; font-weight: 700; text-align: center; margin-bottom: 4px; }
        .auth-sub   { font-size: 13.5px; color: var(--muted); text-align: center; margin-bottom: 28px; }
        .auth-link  { color: var(--brand); text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .auth-divider { text-align: center; color: var(--muted); font-size: 12.5px; margin: 14px 0; }

        /* ── ACTIONS ROW ─────────────────────────────────── */
        .actions-row { display: flex; gap: 8px; align-items: center; }

        /* ── PAGE HEADER ─────────────────────────────────── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 22px;
        }
        .page-header-title { font-size: 20px; font-weight: 700; color: var(--text); }
        .page-header-sub   { font-size: 13px; color: var(--muted); margin-top: 2px; }

        /* ── BACK LINK ───────────────────────────────────── */
        .back-link {
            display: inline-flex; align-items: center; gap: 5px;
            color: var(--muted); font-size: 13px;
            text-decoration: none; margin-bottom: 20px;
        }
        .back-link:hover { color: var(--brand); }

        /* ── DETAIL LIST ─────────────────────────────────── */
        .detail-list dt {
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: .05em;
            color: var(--muted); margin-bottom: 2px;
        }
        .detail-list dd {
            font-size: 14px; color: var(--text);
            margin: 0 0 18px;
        }

        /* ── SECTION GRID ────────────────────────────────── */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

        /* ── PAGINATION ──────────────────────────────────── */
        .pagination { justify-content: flex-end; margin-top: 18px; }

        /* ── EMPTY STATE ─────────────────────────────────── */
        .empty-state {
            text-align: center; padding: 48px 24px; color: var(--muted);
        }
        .empty-state-icon { font-size: 36px; margin-bottom: 10px; opacity: .4; }
        .empty-state p    { font-size: 13.5px; }

        /* ── FILE INPUT ──────────────────────────────────── */
        .file-input-wrap {
            border: 1.5px dashed var(--border);
            border-radius: 7px;
            padding: 18px;
            text-align: center;
            background: var(--bg);
            cursor: pointer;
            transition: border-color .15s;
        }
        .file-input-wrap:hover { border-color: var(--brand); }
        .file-input-wrap input[type=file] { display: none; }

        /* ── TOPBAR (no sidebar = auth pages) ────────────── */
        body.auth-page .main-wrap { margin-left: 0; }

        /* ── DASHBOARD STAT CARD ──────────────────────────── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: var(--shadow);
        }
        .stat-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--text); margin: 6px 0 0; }
        .stat-icon  { width: 42px; height: 42px; border-radius: 10px; display: grid; place-items: center; font-size: 18px; }

    </style>
</head>
<body class="{{ request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*') || request()->routeIs('verification.*') ? 'auth-page' : '' }}">

@auth
<div class="sidebar" id="sidebar">
    <a href="{{ url('/') }}" class="sidebar-brand">
        <div class="sidebar-brand-icon"><img src="https://larapress.org/salam/assets/img/logo.png" width="100px"/></div>
        <!--Salam-->
    </a>

    <div style="padding: 8px 12px; flex: 1;">
        <span class="sidebar-section">Main</span>
        <a href="{{ url('/') }}" class="nav-link-side {{ request()->is('/') ? 'active' : '' }}">
            <span class="nav-icon">⊞</span> Dashboard
        </a>

        <span class="sidebar-section">Content</span>
        <a href="{{ url('/posts') }}" class="nav-link-side {{ request()->is('posts*') ? 'active' : '' }}">
            <span class="nav-icon">📄</span> PDF Documents
        </a>
        <a href="{{ url('/banners') }}" class="nav-link-side {{ request()->is('banners*') ? 'active' : '' }}">
            <span class="nav-icon">🖼</span> Banners
        </a>

        <span class="sidebar-section">Management</span>
        <a href="{{ url('/users') }}" class="nav-link-side {{ request()->is('users*') ? 'active' : '' }}">
            <span class="nav-icon">👤</span> Users
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="{{ url('/logout') }}">
            <span class="nav-icon">↩</span> Sign Out
        </a>
    </div>
</div>
@endauth

<div class="main-wrap">

    @auth
    <header class="topbar">
        <span class="topbar-title">
            @yield('page-title', 'Dashboard')
        </span>
        <div class="topbar-user">
            <div class="avatar">{{ strtoupper(substr(optional(auth()->user())->first_name ?? 'U', 0, 1)) }}</div>
            <span class="topbar-name">{{ optional(auth()->user())->first_name }}</span>
        </div>
    </header>
    @endauth

    <main class="{{ auth()->check() ? 'page-content' : '' }}">
    @auth
        @if ($errors->any())
            <div class="alert-pro danger">
                <span>⚠</span>
                <ul style="margin:0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="alert-pro {{ session('type') === 'danger' ? 'danger' : 'success' }}">
                <span>{{ session('type') === 'danger' ? '⚠' : '✓' }}</span>
                {{ session('message') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-pro success"><span>✓</span> {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-pro danger"><span>⚠</span> {{ session('error') }}</div>
        @endif
        
    @endauth

        @yield('content')
    </main>


    @auth
    <footer style="padding: 16px 28px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted);">
        &copy; {{ date('Y') }} Salam Admin. All rights reserved.
    </footer>
    @endauth
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // File input labels
    document.querySelectorAll('.file-input-wrap').forEach(wrap => {
        const input = wrap.querySelector('input[type=file]');
        const label = wrap.querySelector('.file-label');
        if (!input || !label) return;
        input.addEventListener('change', () => {
            label.textContent = input.files[0]?.name ?? 'Choose file…';
        });
    });
</script>
</body>
</html>
