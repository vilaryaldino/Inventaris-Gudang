<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistem Gudang') - Sistem Manajemen Gudang Enterprise</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Enterprise Dashboard Styles -->
    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 76px;
            --header-height: 64px;
            --footer-height: 48px;
            
            /* Color Palette */
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --primary-border: #bfdbfe;

            --success: #10b981;
            --success-dark: #059669;
            --success-light: #ecfdf5;

            --danger: #ef4444;
            --danger-hover: #dc2626;
            --danger-light: #fef2f2;

            --warning: #f59e0b;
            --warning-light: #fffbeb;

            /* Neutral Tones */
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;

            /* Sidebar Theme (Deep Slate / Navy) */
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #1e3a8a;
            --sidebar-border: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --sidebar-category: #64748b;

            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.07), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.08), 0 4px 6px -4px rgb(0 0 0 / 0.03);
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ========================================================
           LAYOUT WRAPPER
           ======================================================== */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* ========================================================
           SIDEBAR STYLES
           ======================================================== */
        .app-sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid var(--sidebar-border);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            user-select: none;
        }

        .sidebar-brand {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 12px;
            border-bottom: 1px solid var(--sidebar-border);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
            flex-shrink: 0;
        }

        .brand-text h2 {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 11px;
            color: #38bdf8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;
        }

        .nav-category {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--sidebar-category);
            letter-spacing: 0.08em;
            padding: 16px 12px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: var(--radius-md);
            margin-bottom: 3px;
            font-weight: 500;
            font-size: 13.5px;
            transition: all 0.2s ease;
        }

        .nav-item i {
            font-size: 17px;
            color: #94a3b8;
            transition: color 0.2s ease;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .nav-item:hover i {
            color: #38bdf8;
        }

        .nav-item.active {
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .nav-item.active i {
            color: #ffffff;
        }

        .nav-item .badge {
            margin-left: auto;
            background-color: #0284c7;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
            letter-spacing: 0.02em;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid var(--sidebar-border);
            background: #090e17;
        }

        .oracle-status-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(51, 65, 85, 0.8);
            border-radius: var(--radius-md);
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pulse-indicator {
            position: relative;
            width: 10px;
            height: 10px;
            background-color: #10b981;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .pulse-indicator::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 0.4);
            animation: pulse-ring 1.8s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.6); opacity: 0.8; }
            100% { transform: scale(2); opacity: 0; }
        }

        .oracle-info {
            line-height: 1.25;
            overflow: hidden;
        }

        .oracle-info .title {
            color: #f1f5f9;
            font-size: 11px;
            font-weight: 700;
            display: block;
        }

        .oracle-info .desc {
            color: #94a3b8;
            font-size: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ========================================================
           MAIN CONTENT CONTAINER
           ======================================================== */
        .app-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--bg-body);
        }

        /* ========================================================
           HEADER STYLES
           ======================================================== */
        .app-header {
            height: var(--header-height);
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .sidebar-toggle-btn {
            background: none;
            border: 1px solid var(--border-color);
            width: 36px;
            height: 36px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sidebar-toggle-btn:hover {
            background-color: var(--bg-body);
            color: var(--primary);
            border-color: var(--primary-border);
        }

        .header-quick-search {
            position: relative;
            width: 320px;
        }

        .header-quick-search input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            font-size: 13px;
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: all 0.2s ease;
            outline: none;
        }

        .header-quick-search input:focus {
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .header-quick-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .db-status-pill {
            background-color: var(--success-light);
            border: 1px solid #a7f3d0;
            color: #065f46;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .db-status-pill .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--success);
        }

        .header-btn {
            background: none;
            border: 1px solid var(--border-color);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .header-btn:hover {
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .header-btn .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 16px;
            height: 16px;
            background-color: var(--danger);
            color: white;
            font-size: 9px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        .user-profile-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 8px 4px 4px;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .user-profile-menu:hover {
            background-color: var(--bg-body);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            border: 2px solid #ffffff;
            box-shadow: var(--shadow-sm);
        }

        .user-meta {
            line-height: 1.2;
            text-align: left;
        }

        .user-meta .name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            display: block;
        }

        .user-meta .role {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* ========================================================
           PAGE CONTENT AREA
           ======================================================== */
        .content-container {
            flex: 1;
            padding: 28px;
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
        }

        /* ========================================================
           FOOTER STYLES
           ======================================================== */
        .app-footer {
            height: var(--footer-height);
            background-color: #ffffff;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: auto;
        }

        .footer-left strong {
            color: var(--text-main);
            font-weight: 600;
        }

        .footer-badge {
            background-color: #f1f5f9;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 11px;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* ========================================================
           COLLAPSED SIDEBAR STATE
           ======================================================== */
        body.sidebar-collapsed .app-sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .app-main {
            margin-left: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .nav-category,
        body.sidebar-collapsed .nav-item span,
        body.sidebar-collapsed .nav-item .badge,
        body.sidebar-collapsed .oracle-info {
            display: none !important;
        }

        body.sidebar-collapsed .sidebar-brand {
            padding: 0;
            justify-content: center;
        }

        body.sidebar-collapsed .nav-item {
            justify-content: center;
            padding: 12px 0;
        }

        body.sidebar-collapsed .oracle-status-card {
            justify-content: center;
            padding: 10px 0;
        }

        /* Responsive styling */
        @media (max-width: 1024px) {
            .app-sidebar {
                transform: translateX(-100%);
            }
            .app-main {
                margin-left: 0 !important;
            }
            body.sidebar-open .app-sidebar {
                transform: translateX(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-layout">
        
        <!-- ====================================================
             1. SIDEBAR (NAVIGASI UTAMA GUDANG)
             ==================================================== -->
        <aside class="app-sidebar" id="appSidebar">
            <!-- Brand Logo -->
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div class="brand-text">
                    <h2>GudangKu</h2>
                    <span>Enterprise System</span>
                </div>
            </div>

            <!-- Nav Items -->
            <div class="sidebar-nav">
                
                <!-- Kategori: Utama -->
                <div class="nav-category">Navigasi Utama</div>
                
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard', 'home') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Kategori: Master Data -->
                <div class="nav-category">Master Data</div>

                <a href="{{ route('master.satuan-dasar') }}" class="nav-item {{ request()->routeIs('master.satuan-dasar') ? 'active' : '' }}">
                    <i class="bi bi-rulers"></i>
                    <span>Satuan Dasar</span>
                </a>

                <a href="{{ route('master.satuan') }}" class="nav-item {{ request()->routeIs('master.satuan') ? 'active' : '' }}">
                    <i class="bi bi-stack"></i>
                    <span>Satuan Konversi</span>
                </a>

                <a href="{{ route('master.rekanan') }}" class="nav-item {{ request()->routeIs('master.rekanan') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Data Rekanan</span>
                </a>

                <a href="{{ route('master.item') }}" class="nav-item {{ request()->routeIs('master.item') ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Master Barang (Item)</span>
                </a>

                <!-- Kategori: Transaksi -->
                <div class="nav-category">Transaksi Gudang</div>

                <a href="{{ route('transaksi.faktur-pembelian') }}" class="nav-item {{ request()->routeIs('transaksi.faktur-pembelian') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    <span>Faktur Pembelian</span>
                    <span class="badge">Masuk</span>
                </a>

                <a href="{{ route('transaksi.barang-keluar') }}" class="nav-item {{ request()->routeIs('transaksi.barang-keluar') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Pengeluaran Barang</span>
                    <span class="badge" style="background-color: #64748b;">Keluar</span>
                </a>

                <!-- Kategori: Laporan -->
                <div class="nav-category">Laporan & Kontrol</div>

                <a href="{{ route('laporan.stok') }}" class="nav-item">
                    <i class="bi bi-clipboard2-data-fill"></i>
                    <span>Laporan Stok Fisik</span>
                </a>

                <a href="{{ route('laporan.mutasi') }}" class="nav-item">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Kartu Mutasi Stok</span>
                </a>

            </div>

            <!-- Sidebar Footer: Oracle Database Live Indicator -->
            <div class="sidebar-footer">
                <div class="oracle-status-card" title="Oracle Database 11g Release 2 connected">
                    <div class="pulse-indicator"></div>
                    <div class="oracle-info">
                        <span class="title">Oracle 11g Connected</span>
                        <span class="desc">Host: 192.168.1.19 / Schema: LATIHAN</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ====================================================
             MAIN CONTAINER (HEADER + CONTENT + FOOTER)
             ==================================================== -->
        <div class="app-main">
            
            <!-- ================================================
                 2. HEADER (TOP NAVBAR)
                 ================================================ -->
            <header class="app-header">
                <!-- Left: Sidebar Toggle & Search -->
                <div class="header-left">
                    <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" title="Toggle Sidebar (Ctrl+B)">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <div class="header-quick-search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Pencarian cepat barang / transaksi... (Ctrl+K)">
                    </div>
                </div>

                <!-- Right: Status, Notifikasi, Profile -->
                <div class="header-right">
                    
                    <!-- Oracle Status Pill -->
                    <div class="db-status-pill">
                        <span class="dot"></span>
                        <span>Oracle 11g · OCI8 Active</span>
                    </div>

                    <!-- Notifikasi -->
                    <button type="button" class="header-btn" title="Notifikasi Transaksi">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <!-- Divider -->
                    <div style="width: 1px; height: 26px; background-color: var(--border-color);"></div>

                    <!-- User Profile Dropdown -->
                    <div class="user-profile-menu">
                        <div class="user-avatar">AD</div>
                        <div class="user-meta">
                            <span class="name">Administrator</span>
                            <span class="role">Kepala Gudang</span>
                        </div>
                        <i class="bi bi-chevron-down ms-1 text-muted" style="font-size: 11px;"></i>
                    </div>

                </div>
            </header>

            <!-- ================================================
                 3. MAIN CONTENT
                 ================================================ -->
            <main class="content-container">
                @if(session('success'))
                    <div style="background-color: var(--success-light); border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-check-circle-fill fs-5" style="color: var(--success);"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('info'))
                    <div style="background-color: var(--primary-light); border: 1px solid var(--primary-border); color: #1e40af; padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="bi bi-info-circle-fill fs-5" style="color: var(--primary);"></i>
                        <div>{{ session('info') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- ================================================
                 4. FOOTER (SISTEM & STATUS)
                 ================================================ -->
            <footer class="app-footer">
                <div class="footer-left">
                    <span>&copy; {{ date('Y') }} <strong>Sistem Gudang & Logistik Enterprise</strong>. Hak Cipta Dilindungi.</span>
                </div>
                <div class="footer-center" style="display: flex; align-items: center; gap: 12px;">
                    <span>Database: <strong class="footer-badge">Oracle 11g Release 2 (Yajra OCI8)</strong></span>
                    <span>Framework: <strong class="footer-badge">Laravel 12 (PHP 8.2)</strong></span>
                </div>
                <div class="footer-right" style="display: flex; align-items: center; gap: 8px;">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: var(--success);"></span>
                    <span>Latency: <strong>&lt; 5ms</strong></span>
                </div>
            </footer>

        </div>
    </div>

    <!-- Layout Javascript -->
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-collapsed');
            });
        }

        // Shortcut keyboard Ctrl+B to toggle sidebar
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapsed');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
