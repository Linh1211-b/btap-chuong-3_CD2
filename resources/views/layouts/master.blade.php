<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khóa học</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        html { scroll-behavior: smooth; }
        body { min-height:100vh; margin:0; font-family:'Instrument Sans', sans-serif; background:#eff6ff; color:#0f172a; }
        .button { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:.85rem 1.15rem; border-radius:.85rem; font-weight:700; transition:all .2s ease; }
        .button-primary { background:#2563eb; color:#fff; }
        .button-primary:hover { background:#1d4ed8; transform:translateY(-1px); }
        .button-secondary { background:#fff; color:#0f172a; border:1px solid #cbd5e1; }
        .button-secondary:hover { background:#f8fafc; border-color:#94a3b8; }
        .card { background:#fff; border:1px solid #e2e8f0; border-radius:1rem; box-shadow:0 24px 60px rgba(15,23,42,.08); }
        .form-card { background:#fff; border:1px solid #e2e8f0; border-radius:1.5rem; box-shadow:0 18px 34px rgba(15,23,42,.06); padding:2rem; }
        .form-label { display:block; margin-bottom:.75rem; font-weight:600; color:#334155; }
        .form-control { width:100%; border:1px solid #cbd5e1; background:#f8fafc; color:#0f172a; border-radius:.9rem; padding:.95rem 1rem; transition:border-color .2s ease, box-shadow .2s ease, background .2s ease; }
        .form-control:focus { outline:none; border-color:#3b82f6; background:#fff; box-shadow:0 0 0 4px rgba(59,130,246,.12); }
        .form-heading { margin-bottom:.5rem; font-size:1.9rem; font-weight:700; color:#0f172a; }
        .form-subtitle { color:#64748b; }
        .layout-shell { display:grid; grid-template-columns:280px minmax(0,1fr); gap:1.5rem; max-width:1440px; margin:0 auto; padding:2rem; }
        .sidebar { background:#111827; color:#e2e8f0; border-radius:1.75rem; padding:2rem 1.5rem; min-height:calc(100vh - 4rem); display:flex; flex-direction:column; gap:1.75rem; }
        .brand { display:flex; align-items:center; gap:0.9rem; margin-bottom:1.5rem; }
        .brand-mark { width:42px; height:42px; border-radius:14px; display:grid; place-items:center; background:linear-gradient(135deg,#2563eb,#9333ea); color:#fff; font-weight:700; }
        .brand-text { font-size:1.25rem; font-weight:700; color:#fff; line-height:1.1; }
        .sidebar nav { display:flex; flex-direction:column; gap:.4rem; }
        .sidebar-link { display:flex; align-items:center; gap:.9rem; padding:1rem 1rem; border-radius:1rem; color:#cbd5e1; text-decoration:none; font-weight:600; transition:all .2s ease; }
        .sidebar-link:hover, .sidebar-link.active { color:#fff; background:rgba(255,255,255,.08); }
        .sidebar-link svg { width:1rem; height:1rem; color:#60a5fa; }
        .sidebar-footer { margin-top:auto; font-size:.92rem; color:#94a3b8; }
        .main-panel { display:flex; flex-direction:column; gap:1.5rem; }
        .page-title { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; }
        .page-title h1 { margin:0; font-size:2rem; font-weight:800; }
        .metric-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:1rem; }
        .metric-card { border-radius:1.5rem; color:#fff; padding:1.65rem 1.5rem; min-height:140px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 24px 60px rgba(15,23,42,.12); }
        .metric-primary { background:linear-gradient(135deg,#2563eb 0%,#60a5fa 100%); }
        .metric-success { background:linear-gradient(135deg,#047857 0%,#22c55e 100%); }
        .metric-warning { background:linear-gradient(135deg,#d97706 0%,#facc15 100%); }
        .metric-info { background:linear-gradient(135deg,#0891b2 0%,#38bdf8 100%); }
        .metric-card h3 { margin:0; font-size:1rem; color:rgba(255,255,255,.9); font-weight:600; }
        .metric-card p { margin:0; font-size:1.9rem; font-weight:800; line-height:1; }
        .section-card { background:#fff; border:1px solid #e2e8f0; border-radius:1.5rem; padding:1.5rem; box-shadow:0 20px 40px rgba(15,23,42,.05); }
        .section-header { display:flex; flex-wrap:wrap; justify-content:space-between; gap:1rem; align-items:center; }
        .section-header h2 { margin:0; font-size:1.35rem; font-weight:700; }
        .course-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1.25rem; }
        .course-card-new { border-radius:1.5rem; overflow:hidden; border:1px solid #e2e8f0; background:#fff; box-shadow:0 20px 40px rgba(15,23,42,.06); display:flex; flex-direction:column; }
        .course-card-new img { width:100%; aspect-ratio:16/9; object-fit:cover; }
        .course-card-new .content { padding:1.25rem; }
        .course-card-new h3 { margin:0 0 .55rem; font-size:1.15rem; font-weight:700; color:#0f172a; }
        .course-card-new p { margin:0 0 .85rem; color:#475569; }
        .badge-pill { display:inline-flex; align-items:center; justify-content:center; padding:.45rem .8rem; border-radius:999px; font-size:.8rem; font-weight:700; color:#166534; background:#dcfce7; }
        @media (max-width: 1100px) { .layout-shell { grid-template-columns:1fr; } .metric-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } .course-grid { grid-template-columns:1fr; } }
        @media (max-width: 700px) { .layout-shell { padding:1rem; } .sidebar { min-height:auto; padding:1.5rem; } .metric-grid, .course-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body class="min-h-screen">
    <div class="layout-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">Q</div>
                <div class="brand-text">Quản Lý<br />Khóa Học</div>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l2-2 4 4 8-8 4 4v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('courses.index') }}" class="sidebar-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Khóa Học
                </a>
                <a href="{{ route('enrollments.index') }}" class="sidebar-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Đăng Ký Học
                </a>
            </nav>
            <div class="sidebar-footer">Giao diện mẫu, chức năng CRUD và đăng ký học vẫn giữ nguyên.</div>
        </aside>

        <main class="main-panel">
            <x-alert />
            @yield('content')
        </main>
    </div>
</body>
</html>
