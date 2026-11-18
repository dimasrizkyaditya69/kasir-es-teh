<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - Es Teh Jumbo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --green-dark: #123c32;
            --green-main: #1d604b;
            --green-light: #e5f1e8;
            --lime: #b8e986;
            --page-bg: #f5f7f3;
            --text-dark: #20332c;
            --text-muted: #87958d;
            --border-color: #e8eee9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text-dark);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
        }

        /* SIDEBAR */

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--green-dark);
            color: white;
            border: none;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 23px 20px;
            border-bottom: 1px solid rgba(255,255,255,.10);
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: var(--lime);
            color: var(--green-dark);
            border-radius: 13px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.1;
        }

        .brand-caption {
            color: #a9c4b5;
            font-size: 9px;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .sidebar-section {
            padding: 22px 20px 8px;
            color: #91b0a0;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #c4d6cc;
            padding: 12px 14px;
            margin: 3px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s ease;
        }

        .sidebar .nav-link i {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.09);
        }

        .sidebar .nav-link.active {
            color: white;
            background: var(--green-main);
            box-shadow: inset 3px 0 var(--lime);
        }

        .sidebar-footer {
            margin: 25px 12px 15px;
            padding: 15px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 12px;
        }

        .sidebar-footer p {
            color: #a9c4b5;
            font-size: 11px;
            margin: 5px 0 0;
        }

        .sidebar-footer .btn {
            margin-top: 12px;
            font-size: 12px;
        }

        /* MAIN CONTENT */

        .main-content {
            min-width: 0;
            flex: 1;
        }

        .topbar {
            min-height: 68px;
            background: rgba(255,255,255,.92);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-label {
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 750;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 13px;
            background: #f7f9f6;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--green-light);
            color: var(--green-main);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
        }

        .content-wrapper {
            padding: 30px;
        }

        /* GENERAL COMPONENTS */

        .page-heading {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .page-description {
            color: var(--text-muted);
            font-size: 13px;
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 15px;
            box-shadow: 0 3px 14px rgba(28, 55, 40, .035);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 17px 20px;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 700;
        }

        .card-body {
            padding: 20px;
        }

        .btn-success {
            background: var(--green-main);
            border-color: var(--green-main);
        }

        .btn-success:hover {
            background: var(--green-dark);
            border-color: var(--green-dark);
        }

        .table thead th {
            background: #f6f8f5;
            color: #738278;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 800;
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px;
            font-size: 13px;
        }

        .form-control,
        .form-select {
            border-color: #dfe8e1;
            border-radius: 9px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 .2rem rgba(29,96,75,.10);
        }

        /* RESPONSIVE */

        @media (min-width: 992px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                overflow-y: auto;
            }

            .main-content {
                margin-left: 260px;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 280px;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .topbar {
                padding: 12px 15px;
            }

            .topbar-title {
                font-size: 13px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <aside class="sidebar offcanvas-lg offcanvas-start"
           tabindex="-1"
           id="sidebarMenu">

        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-cup-straw"></i>
            </div>

            <div>
                <div class="brand-name">Es Teh Jumbo</div>
                <div class="brand-caption">FRESH EVERY DAY</div>
            </div>

            <button type="button"
                    class="btn-close btn-close-white d-lg-none ms-auto"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>

        <div class="sidebar-section">WORKSPACE</div>

        <nav class="nav flex-column">

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                Dashboard
            </a>

            <a href="{{ route('categories.index') }}"
               class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                Kategori
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-link {{ request()->routeIs('products.*') || request()->routeIs('product-ingredients.*') ? 'active' : '' }}">
                <i class="bi bi-cup-hot-fill"></i>
                Produk & Resep
            </a>

            <a href="{{ route('ingredients.index') }}"
               class="nav-link {{ request()->routeIs('ingredients.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                Bahan Baku
            </a>

            <a href="{{ route('stock-movements.index') }}"
               class="nav-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i>
                Manajemen Stok
            </a>

        </nav>

        <div class="sidebar-section">TRANSAKSI</div>

        <nav class="nav flex-column">

            <a href="{{ route('sales.create') }}"
               class="nav-link {{ request()->routeIs('sales.create') || request()->routeIs('sales.store') ? 'active' : '' }}">
                <i class="bi bi-cart-plus-fill"></i>
                Kasir
            </a>

            <a href="{{ route('sales.index') }}"
               class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                Riwayat Transaksi
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <strong class="small">Es Teh Jumbo</strong>
                <i class="bi bi-stars" style="color: var(--lime)"></i>
            </div>

            <p>Kelola penjualan dan stok bahan baku dengan mudah.</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <header class="topbar">

            <div class="d-flex align-items-center gap-3">

                <button class="btn btn-outline-success d-lg-none"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#sidebarMenu">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <div>
                    <div class="topbar-label">Point of Sale / Kasir</div>
                    <div class="topbar-title">@yield('title', 'Dashboard')</div>
                </div>

            </div>

            <div class="d-flex align-items-center gap-3">

                <div class="topbar-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="fw-bold small">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-muted" style="font-size: 10px">
                            Administrator
                        </div>
                    </div>
                </div>

            </div>

        </header>

        <div class="content-wrapper">
            @yield('content')
        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
