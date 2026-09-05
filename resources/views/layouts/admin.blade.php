<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Temoe Tumbuh</title>
    <style>
        :root{--ink:#26352f;--muted:#748078;--bg:#f5f3ed;--panel:#fff;--line:#e7e2d7;--green:#456b5c;--green2:#dce8df;--sand:#efe5d3;--rose:#ecd8cf;--danger:#a14c45;--shadow:0 14px 36px rgba(47,55,49,.07)}
        *{box-sizing:border-box}body{margin:0;font-family:Inter,ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:var(--bg);color:var(--ink)}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}.app{min-height:100vh;display:grid;grid-template-columns:250px 1fr}.sidebar{background:#20362f;color:#f8f7f0;padding:26px 18px;position:sticky;top:0;height:100vh}.brand{padding:4px 12px 24px}.brand strong{font-size:21px;letter-spacing:-.5px}.brand small{display:block;color:#b9c8c0;margin-top:5px}.nav{display:grid;gap:5px}.nav a{padding:11px 12px;border-radius:11px;color:#d6e0db;font-size:14px}.nav a:hover,.nav a.active{background:rgba(255,255,255,.1);color:#fff}.nav-label{font-size:10px;letter-spacing:1.5px;color:#829a90;text-transform:uppercase;margin:22px 12px 8px}.sidebar-footer{position:absolute;left:18px;right:18px;bottom:20px}.logout{width:100%;border:1px solid rgba(255,255,255,.14);background:transparent;color:#d6e0db;border-radius:10px;padding:10px;cursor:pointer}.main{min-width:0}.topbar{height:76px;background:rgba(245,243,237,.88);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:space-between;padding:0 34px;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:5}.page{padding:32px 34px 60px;max-width:1500px}.heading{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:25px}.heading h1{margin:0;font-size:29px;letter-spacing:-.7px}.heading p{margin:7px 0 0;color:var(--muted)}.card{background:var(--panel);border:1px solid var(--line);border-radius:17px;box-shadow:var(--shadow)}.card-pad{padding:22px}.grid{display:grid;gap:16px}.grid-4{grid-template-columns:repeat(4,minmax(0,1fr))}.grid-3{grid-template-columns:repeat(3,minmax(0,1fr))}.grid-2{grid-template-columns:repeat(2,minmax(0,1fr))}.metric{padding:20px}.metric .label{font-size:13px;color:var(--muted)}.metric .value{font-size:31px;font-weight:750;letter-spacing:-1px;margin-top:7px}.metric .hint{font-size:12px;color:var(--muted);margin-top:5px}.btn{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:10px;padding:10px 14px;cursor:pointer;font-weight:650;font-size:13px}.btn-primary{background:var(--green);color:#fff}.btn-soft{background:var(--green2);color:#2d5547}.btn-danger{background:#f7e2df;color:var(--danger)}.btn-outline{background:#fff;border:1px solid var(--line)}.field{display:grid;gap:7px}.field label{font-size:12px;font-weight:700;color:#526058}.input,.select,.textarea{width:100%;border:1px solid #dcd8cd;background:#fff;border-radius:10px;padding:10px 12px;outline:0;color:var(--ink)}.textarea{min-height:110px;resize:vertical}.input:focus,.select:focus,.textarea:focus{border-color:#7da08f;box-shadow:0 0 0 3px rgba(69,107,92,.09)}.table-wrap{overflow:auto}.table{width:100%;border-collapse:collapse;font-size:13px}.table th{text-align:left;color:var(--muted);font-size:11px;text-transform:uppercase;letter-spacing:.7px;padding:12px 14px;border-bottom:1px solid var(--line)}.table td{padding:13px 14px;border-bottom:1px solid #f0ede6;vertical-align:top}.table tr:last-child td{border-bottom:0}.badge{display:inline-flex;padding:5px 8px;border-radius:999px;background:#eef0eb;font-size:11px;font-weight:700}.badge-new{background:#e6edf6;color:#3f6184}.badge-contacted{background:#f1ead8;color:#806a35}.badge-qualified{background:#e1ecdf;color:#45683f}.badge-high_intent{background:#f2ded3;color:#8a5238}.badge-reserved{background:#d8ebe1;color:#30634b}.badge-lost{background:#eee4e3;color:#875c58}.muted{color:var(--muted)}.flash{padding:12px 15px;border-radius:11px;background:#dfece4;color:#315d49;margin-bottom:18px}.error{padding:12px 15px;border-radius:11px;background:#f4dfdc;color:#8c403a;margin-bottom:18px}.section-title{font-size:16px;font-weight:750;margin:0 0 15px}.empty{padding:35px;text-align:center;color:var(--muted)}.stack{display:grid;gap:14px}.actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}.kpi-list{display:grid;gap:10px}.kpi-row{display:flex;justify-content:space-between;gap:18px;padding:9px 0;border-bottom:1px solid #f0ede7}.kpi-row:last-child{border-bottom:0}.help{font-size:12px;color:var(--muted)}
        @media(max-width:1050px){.app{grid-template-columns:82px 1fr}.brand strong,.brand small,.nav span,.nav-label,.sidebar-footer{display:none}.nav a{text-align:center;padding:12px 5px}.grid-4{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:720px){.app{display:block}.sidebar{height:auto;position:static;padding:10px;display:flex;overflow:auto}.brand,.nav-label,.sidebar-footer{display:none}.nav{display:flex}.nav a{white-space:nowrap;padding:9px 12px}.topbar{height:58px;padding:0 16px}.page{padding:22px 16px 50px}.heading{display:block}.heading .actions{margin-top:14px}.grid-4,.grid-3,.grid-2{grid-template-columns:1fr}}
    </style>
    @stack('head')
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand"><strong>Temoe Tumbuh</strong><small>Market Validation OS</small></div>
        <nav class="nav">
            <div class="nav-label">Overview</div>
            <a class="{{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">◫ <span>Dashboard</span></a>
            <a class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" href="{{ route('admin.leads.index') }}">◎ <span>Leads</span></a>
            <div class="nav-label">Website</div>
            <a class="{{ request()->routeIs('admin.cms.*') ? 'active' : '' }}" href="{{ route('admin.cms.index') }}">▤ <span>Homepage</span></a>
            <a class="{{ request()->routeIs('admin.form-fields.*') ? 'active' : '' }}" href="{{ route('admin.form-fields.index') }}">✦ <span>Form Minat</span></a>
            <a class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">▧ <span>Media</span></a>
            <div class="nav-label">Marketing</div>
            <a class="{{ request()->routeIs('admin.tracking.*') ? 'active' : '' }}" href="{{ route('admin.tracking.edit') }}">⌁ <span>Tracking</span></a>
        </nav>
        <div class="sidebar-footer">
            <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="logout">Keluar</button></form>
        </div>
    </aside>
    <main class="main">
        <div class="topbar"><div><strong>@yield('topbar', 'Temoe Tumbuh')</strong></div><div class="muted" style="font-size:13px">{{ auth()->user()->email ?? '' }}</div></div>
        <div class="page">
            @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
            @yield('content')
        </div>
    </main>
</div>
@stack('scripts')
</body>
</html>
