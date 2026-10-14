<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel - College ERP')</title>



    <style>

        \* { box-sizing: border-box; }



        html, body {

            margin: 0;

            padding: 0;

            font-family: Inter, 'Segoe UI', Roboto, Arial, sans-serif;

            background: #f5f6fa;

            color: #232323;

        }



        body { overflow-x: hidden; }



        /\* ================= TOP BAR ================= \*/

        .admin-topbar {

            position: fixed;

            top: 0;

            left: 0;

            right: 0;

            height: 62px;

            background: linear-gradient(110deg, #28215f 0%, #4338a5 55%, #5145cd 100%);

            color: #fff;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 22px;

            z-index: 1200;

            box-shadow: 0 2px 8px rgba(0,0,0,.15);

        }



        .admin-topbar-left,

        .admin-topbar-right {

            display: flex;

            align-items: center;

        }



        .admin-topbar-left { gap: 14px; }

        .admin-topbar-right { gap: 12px; }



        .admin-menu-btn {

            width: 40px;

            height: 40px;

            border: 0;

            background: transparent;

            color: #fff;

            border-radius: 7px;

            cursor: pointer;

            font-size: 24px;

            display: flex;

            align-items: center;

            justify-content: center;

        }



        .admin-menu-btn:hover { background: rgba(255,255,255,.14); transform: translateY(-1px); }
        .admin-menu-btn { transition: background .18s ease, transform .18s ease; }
        .admin-menu-btn:focus-visible { outline: 2px solid #c4b5fd; outline-offset: 2px; }



        .admin-brand {

            font-size: 18px;

            font-weight: 700;

            line-height: 1.1;

        }



        .admin-brand small {

            display: block;

            margin-top: 2px;

            font-size: 10px;

            font-weight: 400;

            opacity: .84;

        }



        .admin-session-badge {

            padding: 7px 11px;

            border: 1px solid rgba(255,255,255,.35);

            border-radius: 18px;

            font-size: 11px;

            font-weight: 700;

        }



        .admin-user-name {

            font-size: 12px;

            white-space: nowrap;

            max-width: 220px;

            overflow: hidden;

            text-overflow: ellipsis;

        }



        .admin-logout-form { margin: 0; }



        .admin-logout-btn {

            border: 0;

            background: #e85b66;

            color: #fff;

            padding: 8px 12px;

            border-radius: 6px;

            cursor: pointer;

            font-size: 11px;

            font-weight: 700;

        }



        .admin-logout-btn:hover { background: #d94955; }



        /\* ================= LAYOUT ================= \*/

        .admin-shell {

            min-height: 100vh;

            padding-top: 62px;

        }



        .admin-content {

            margin-left: 238px;

            min-height: calc(100vh - 62px);

            padding: 26px 30px 40px;

            background: #f7f8fb;

        }



        /\* ================= SIDEBAR SUPPORT ================= \*/

        .admin-sidebar {

            position: fixed;

            left: 0;

            top: 62px;

            bottom: 0;

            width: 238px;

            background: linear-gradient(180deg, #171b3d 0%, #202653 55%, #252c5c 100%);

            border-right: 1px solid rgba(255,255,255,.08); box-shadow: 8px 0 28px rgba(16,24,60,.10);

            overflow-y: auto;

            z-index: 1100;

            transition: transform .2s ease;

        }



        .admin-sidebar::-webkit-scrollbar { width: 6px; }

        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.25); border-radius: 10px; }



        .admin-overlay {

            display: none;

            position: fixed;

            inset: 62px 0 0 0;

            background: rgba(0,0,0,.34);

            z-index: 1050;

        }



        .admin-sidebar-profile {

            text-align: center;

            padding: 18px 10px 16px;

            border-bottom: 1px solid rgba(255,255,255,.12);

        }



        .admin-logo {

            width: 86px;

            height: 86px;

            margin: 0 auto 9px;

            border-radius: 50%;

            background: #fff;

            border: 3px solid #fff;

            box-shadow: 0 1px 5px rgba(0,0,0,.10);

            display: flex;

            align-items: center;

            justify-content: center;

            color: #40358f;

            font-size: 12px;

            font-weight: 700;

        }



        .admin-profile-name {

            font-size: 12px;

            font-weight: 700;

            color: #fff;

        }



        .admin-profile-role {

            margin-top: 3px;

            font-size: 10px;

            color: #b8c1e4;

        }



        .admin-section-title {

            padding: 14px 9px 7px;

            font-size: 9px;

            color: #9ca9e0;

            letter-spacing: .8px;

            text-transform: uppercase;

            font-weight: 700;

        }



        .admin-menu-item,

        .admin-menu-button {

            width: 100%;

            min-height: 39px;

            border: 0;

            background: transparent;

            color: #e7eaff;

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 9px 11px;

            font-size: 12px;

            cursor: pointer;

            text-align: left;

        }



        .admin-menu-item:hover,

        .admin-menu-button:hover {

            background: rgba(255,255,255,.09);

        }



        .admin-menu-item.active,

        .admin-menu-button.active {

            background: #fff;

            color: #40358f;

            font-weight: 700;

            box-shadow: inset 3px 0 0 #9b8cff;

        }



        .admin-menu-item.disabled {

            color: #777;

            cursor: default;

        }



        .admin-menu-icon {

            width: 20px;

            text-align: center;

            flex: 0 0 20px;

            font-size: 14px;

        }



        .admin-menu-text {

            flex: 1;

            line-height: 1.35;

        }



        .admin-menu-arrow {

            font-size: 11px;

            transition: transform .18s ease;

        }



        .admin-menu-button.open .admin-menu-arrow { transform: rotate(90deg); }



        .admin-submenu {

            display: none;

            background: rgba(8,12,40,.22);

        }



        .admin-submenu.open { display: block; }



        .admin-submenu .admin-menu-item {

            padding-left: 40px;

            min-height: 36px;

            font-size: 11px;

        }



        .admin-soon {

            margin-left: auto;

            padding: 2px 5px;

            border: 1px solid rgba(196,205,255,.25);

            border-radius: 10px;

            font-size: 8px;

            color: #777;

            white-space: nowrap;

        }



        .admin-signout-form { margin: 0; }



        /\* ================= COMMON PAGE ELEMENTS ================= \*/

        .admin-page-head {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 15px;

        }



        .admin-page-head h1 {

            margin: 0;

            font-size: 25px;

            font-weight: 700;

            color: #222;

        }



        .admin-page-head p {

            margin: 6px 0 0;

            color: #717171;

            font-size: 12px;

        }



        .admin-page-line {

            height: 1px;

            background: #dedede;

            margin: 0 0 18px;

        }



        .admin-session-select {

            min-width: 118px;

            padding: 9px 11px;

            border: 1px solid #d2d4dc;

            background: #fff;

            border-radius: 4px;

            font-size: 11px;

            color: #444;

        }



        .admin-panel {

            background: #fff;

            border: 1px solid #e6e7ec;

            border-radius: 8px;

            overflow: hidden;

            box-shadow: 0 2px 9px rgba(0,0,0,.04);

        }



        .admin-panel-header {

            padding: 14px 16px;

            border-bottom: 1px solid #ececf1;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

        }



        .admin-panel-title {

            margin: 0;

            font-size: 14px;

            color: #292929;

        }



        .admin-panel-subtitle {

            font-size: 10px;

            color: #858585;

        }



        .admin-panel-body { padding: 16px; }



        /\* ================= MOBILE ================= \*/

        @media (max-width: 900px) {

            .admin-sidebar {

                transform: translateX(-100%); width: min(280px, 86vw);

            }



            .admin-sidebar.open { transform: translateX(0); }

            .admin-overlay.open { display: block; }



            .admin-content {

                margin-left: 0;

                padding: 22px 16px 30px;

            }



            .admin-session-badge,

            .admin-user-name { display: none; }

        }



        @media (max-width: 580px) {

            .admin-topbar { padding: 0 10px; }

            .admin-brand { font-size: 15px; }

            .admin-page-head { flex-direction: column; }

        }





        /\* ================= STAFF MANAGEMENT ================= \*/

        .admin-btn {

            display: inline-block;

            text-decoration: none;

            border: 0;

            border-radius: 6px;

            padding: 9px 14px;

            font-size: 11px;

            font-weight: 700;

            cursor: pointer;

        }



        .admin-btn-primary { background: #5b3cae; color: #fff; }

        .admin-btn-primary:hover { background: #493092; }

        .admin-btn-secondary { background: #6c757d; color: #fff; }

        .admin-btn-secondary:hover { background: #5c636a; }

        .admin-btn-danger { background: #dc3545; color: #fff; }

        .admin-btn-danger:hover { background: #bb2d3b; }

        .admin-btn-success { background: #198754; color: #fff; }

        .admin-btn-success:hover { background: #157347; }

        .admin-btn-small { padding: 6px 9px; font-size: 10px; }



        .admin-alert {

            padding: 12px 15px;

            border-radius: 7px;

            margin-bottom: 18px;

            font-size: 12px;

            line-height: 1.55;

        }

        .admin-alert-success { background: #d1e7dd; color: #0f5132; border-left: 4px solid #198754; }

        .admin-alert-danger { background: #f8d7da; color: #842029; border-left: 4px solid #dc3545; }



        .admin-count-badge {

            background: #f0ecfa;

            color: #5b3cae;

            border-radius: 16px;

            padding: 7px 11px;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;

        }



        .admin-table { width: 100%; border-collapse: collapse; min-width: 980px; }

        .admin-table th {

            background: #f1eef8;

            color: #5b3cae;

            font-size: 10px;

            text-align: left;

            padding: 11px 10px;

            border-bottom: 1px solid #e0dce9;

        }

        .admin-table td {

            padding: 11px 10px;

            font-size: 10px;

            color: #45414c;

            border-bottom: 1px solid #eceaf0;

            vertical-align: middle;

        }

        .admin-table tr:last-child td { border-bottom: none; }

        .admin-table tbody tr:hover { background: #faf9fc; }



        .admin-status {

            display: inline-block;

            padding: 5px 8px;

            border-radius: 14px;

            font-size: 8px;

            font-weight: 800;

        }

        .admin-status-active { background: #d1e7dd; color: #0f5132; }

        .admin-status-inactive { background: #e2e3e5; color: #41464b; }



        .admin-actions { display: flex; gap: 5px; flex-wrap: wrap; }

        .admin-empty { text-align: center; padding: 35px 15px !important; color: #777 !important; }



        .admin-pagination { padding: 15px 18px; border-top: 1px solid #eceaf0; }

        .admin-pagination nav { display: flex; justify-content: center; }

        .admin-pagination svg { width: 16px; height: 16px; }



        .admin-form-panel { max-width: 1000px; }

        .admin-form-grid {

            display: grid;

            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 17px;

            padding: 21px;

        }

        .admin-form-group label {

            display: block;

            margin-bottom: 7px;

            font-size: 11px;

            color: #3b3844;

            font-weight: 700;

        }

        .admin-form-group label span { color: #dc3545; }

        .admin-form-group input,

        .admin-form-group select {

            width: 100%;

            padding: 10px 11px;

            border: 1px solid #d7d5dd;

            border-radius: 5px;

            background: #fff;

            font-size: 11px;

            color: #333;

            outline: none;

        }

        .admin-form-group input:focus,

        .admin-form-group select:focus { border-color: #7b61bb; box-shadow: 0 0 0 2px rgba(91,60,174,.08); }

        .admin-form-group small { display: block; margin-top: 5px; color: #777; font-size: 9px; }

        .admin-check-row { padding: 0 21px 4px; font-size: 11px; color: #3f3c46; }

        .admin-check-row input { margin-right: 6px; }

        .admin-info-box {

            margin: 13px 21px 0;

            padding: 12px 14px;

            background: #eef5ff;

            border-left: 4px solid #3b73d1;

            color: #294b7c;

            border-radius: 6px;

            font-size: 10px;

            line-height: 1.5;

        }

        .admin-form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 8px;

            padding: 18px 21px 21px;

        }



        @media (max-width: 800px) {

            .admin-form-grid { grid-template-columns: 1fr; }

            .admin-form-actions { flex-direction: column-reverse; }

            .admin-form-actions .admin-btn { text-align: center; }

        }



</style>



    @stack('styles')

</head>

<body>



<header class="admin-topbar">

    <div class="admin-topbar-left">

        <button type="button" class="admin-menu-btn" id="adminMenuBtn" aria-label="Open menu">☰</button>



        <div class="admin-brand">

            College ERP

            <small>Administration & Management System</small>

        </div>

    </div>



    <div class="admin-topbar-right">

        <span class="admin-session-badge">SESSION 2026-27</span>

        <span class="admin-user-name">{{ auth()->user()->name }}</span>



        <form action="{{ route('logout') }}" method="POST" class="admin-logout-form">

            @csrf

            <button type="submit" class="admin-logout-btn">Logout</button>

        </form>

    </div>

</header>



<div class="admin-overlay" id="adminOverlay"></div>



<div class="admin-shell">

    @include('admin.partials.sidebar')



    <main class="admin-content">

        @yield('content')

    </main>

</div>



<script>

    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('adminMenuBtn');
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.getElementById('adminOverlay');
        const desktopQuery = window.matchMedia('(min-width: 901px)');

        function updateMenuButton() {
            if (!menuBtn) return;
            const collapsed = document.body.classList.contains('admin-sidebar-collapsed');
            const mobileOpen = sidebar && sidebar.classList.contains('open');
            menuBtn.setAttribute('aria-expanded', String(desktopQuery.matches ? !collapsed : !!mobileOpen));
            menuBtn.setAttribute('aria-label', desktopQuery.matches
                ? (collapsed ? 'Expand sidebar' : 'Collapse sidebar')
                : (mobileOpen ? 'Close menu' : 'Open menu'));
        }

        function toggleSidebar() {
            if (!sidebar) return;
            if (desktopQuery.matches) {
                document.body.classList.toggle('admin-sidebar-collapsed');
            } else {
                sidebar.classList.toggle('open');
                if (overlay) overlay.classList.toggle('open');
            }
            updateMenuButton();
        }

        function closeMobileSidebar() {
            if (sidebar) sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('open');
            updateMenuButton();
        }

        if (menuBtn) menuBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', closeMobileSidebar);
        window.addEventListener('resize', function () {
            if (desktopQuery.matches) closeMobileSidebar();
            updateMenuButton();
        });

        document.querySelectorAll('[data-admin-accordion]').forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = button.getAttribute('data-admin-accordion');
                const target = document.getElementById(targetId);
                if (!target) return;
                button.classList.toggle('open');
                target.classList.toggle('open');
            });
        });

        updateMenuButton();
    });
    </script>



@stack('scripts')

</body>

</html>
