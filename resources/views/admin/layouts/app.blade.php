<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoDKIJakarta.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #1B3A6B;
            --primary-dark: #0F2A5C;
            --accent-color: #D4A017;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f4f6f9;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1B3A6B 0%, #0F2A5C 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand img {
            width: 50px;
            margin-bottom: 10px;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .sidebar-menu .menu-header {
            padding: 10px 20px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu a i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: white;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        /* Content */
        .content {
            padding: 25px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Stats cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Table */
        .table th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        /* Badge */
        .badge-active {
            background: #d6e4f0;
            color: #0F2A5C;
        }

        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Mobile */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                padding: 12px 16px;
            }

            .content {
                padding: 16px;
            }

            .topbar-title {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 12px;
            }

            .card-header {
                padding: 12px 16px;
                font-size: 14px;
            }

            .content {
                padding: 12px;
            }

            .stat-card {
                padding: 14px;
            }

            .stat-card .stat-value {
                font-size: 1.4rem;
            }
        }

        /* Sidebar overlay on mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 999;
        }

        .sidebar.show~.sidebar-overlay {
            display: block;
        }

        /* Submenu */
        .has-submenu .submenu {
            display: none;
            background: rgba(0, 0, 0, 0.1);
        }

        .has-submenu.open .submenu {
            display: block;
        }

        .submenu a {
            padding-left: 54px;
            font-size: 0.9rem;
        }

        .has-submenu>a::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.2s;
        }

        .has-submenu.open>a::after {
            transform: rotate(180deg);
        }

        /* Sidebar badges */
        .sidebar-badge {
            margin-left: auto;
            background: #e74c3c;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 10px;
            min-width: 20px;
            text-align: center;
            line-height: 1.4;
            animation: badgePulse 2s ease-in-out infinite;
        }

        @keyframes badgePulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .6;
            }
        }

        /* Table new-item badge pulse */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .7;
                transform: scale(1.1);
            }
        }

        .table-warning {
            --bs-table-bg: #fff8e1 !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand">
                <img src="{{ asset('assets/img/logoDKIJakarta.png') }}" alt="Logo DKI Jakarta">
                <h6 class="mb-0">Admin Panel</h6>
                <small class="opacity-75">Kelurahan Petamburan</small>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <div class="menu-header">Website</div>
                <a href="{{ route('admin.settings.index') }}"
                    class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
                <a href="{{ route('admin.sliders.index') }}"
                    class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> Slider
                </a>
                <a href="{{ route('admin.statistics.index') }}"
                    class="{{ request()->routeIs('admin.statistics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Statistik
                </a>
                <a href="{{ route('admin.galleries.index') }}"
                    class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <i class="fas fa-photo-video"></i> Galeri
                </a>

                <div class="menu-header">Konten</div>
                <a href="{{ route('admin.news-categories.index') }}"
                    class="{{ request()->routeIs('admin.news-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i> Kategori Berita
                </a>
                <a href="{{ route('admin.news.index') }}"
                    class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Berita
                </a>
                <a href="{{ route('admin.pages.index') }}"
                    class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Halaman
                </a>

                <div class="menu-header">Organisasi</div>
                <a href="{{ route('admin.divisions.index') }}"
                    class="{{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap"></i> Divisi
                </a>
                <a href="{{ route('admin.officials.index') }}"
                    class="{{ request()->routeIs('admin.officials.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pejabat
                </a>

                <div class="menu-header">Layanan</div>
                <a href="{{ route('admin.service-categories.index') }}"
                    class="{{ request()->routeIs('admin.service-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Kategori Layanan
                </a>
                <a href="{{ route('admin.services.index') }}"
                    class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell"></i> Layanan
                </a>
                <a href="{{ route('admin.service-hours.index') }}"
                    class="{{ request()->routeIs('admin.service-hours.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Jam Layanan
                </a>

                <div class="menu-header">Informasi</div>
                <a href="{{ route('admin.agendas.index') }}"
                    class="{{ request()->routeIs('admin.agendas.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Agenda
                </a>
                <a href="{{ route('admin.achievements.index') }}"
                    class="{{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i> Prestasi
                </a>
                <a href="{{ route('admin.infographics.index') }}"
                    class="{{ request()->routeIs('admin.infographics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Infografis
                </a>
                <a href="{{ route('admin.potentials.index') }}"
                    class="{{ request()->routeIs('admin.potentials.*') ? 'active' : '' }}">
                    <i class="fas fa-gem"></i> Potensi
                </a>
                <a href="{{ route('admin.periodic-informations.index') }}"
                    class="{{ request()->routeIs('admin.periodic-informations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Informasi Berkala
                </a>

                <div class="menu-header">Pengaduan</div>
                <a href="{{ route('admin.complaint-categories.index') }}"
                    class="{{ request()->routeIs('admin.complaint-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Kategori Pengaduan
                </a>
                <a href="{{ route('admin.complaints.index') }}"
                    class="{{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Pengaduan
                    @if (($unreadComplaints ?? 0) > 0)
                        <span class="sidebar-badge">{{ $unreadComplaints }}</span>
                    @endif
                </a>

                <div class="menu-header">PPID</div>
                <a href="{{ route('admin.ppid-categories.index') }}"
                    class="{{ request()->routeIs('admin.ppid-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i> Kategori PPID
                </a>
                <a href="{{ route('admin.ppid-documents.index') }}"
                    class="{{ request()->routeIs('admin.ppid-documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-pdf"></i> Dokumen PPID
                </a>
                <a href="{{ route('admin.ppid-requests.index') }}"
                    class="{{ request()->routeIs('admin.ppid-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text"></i> Permohonan Info
                    @if (($unreadPpidRequests ?? 0) > 0)
                        <span class="sidebar-badge">{{ $unreadPpidRequests }}</span>
                    @endif
                </a>

                <div class="menu-header">Pesan</div>
                <a href="{{ route('admin.contacts.index') }}"
                    class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Kontak Masuk
                    @if (($unreadContacts ?? 0) > 0)
                        <span class="sidebar-badge">{{ $unreadContacts }}</span>
                    @endif
                </a>

                <div class="menu-header">Akun</div>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> Kelola Admin
                </a>
                <a href="{{ route('admin.profile.index') }}"
                    class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> Profil Saya
                </a>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-globe"></i> Lihat Website
                </a>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </nav>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark d-lg-none me-2"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted d-none d-md-block">{{ Auth::user()->name }}</span>
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i
                                    class="fas fa-user-circle me-2"></i>Profil Saya</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.password') }}"><i
                                    class="fas fa-key me-2"></i>Ubah Password</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i
                                    class="fas fa-globe me-2"></i>Lihat Website</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                }
            });
        });

        // Delete confirmation
        function confirmDelete(form) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                form.submit();
            }
            return false;
        }

        // Sidebar: scroll active item into view & save/restore scroll position
        $(document).ready(function() {
            var sidebar = document.getElementById('sidebar');
            var savedScroll = sessionStorage.getItem('sidebar-scroll');
            if (savedScroll !== null) {
                sidebar.scrollTop = parseInt(savedScroll);
            } else {
                var activeItem = sidebar.querySelector('.sidebar-menu a.active');
                if (activeItem) {
                    activeItem.scrollIntoView({
                        block: 'center',
                        behavior: 'instant'
                    });
                }
            }
            // Save scroll position before navigating away
            $(sidebar).on('scroll', function() {
                sessionStorage.setItem('sidebar-scroll', sidebar.scrollTop);
            });

            // Close sidebar when overlay is clicked (mobile)
            $('#sidebarOverlay').on('click', function() {
                sidebar.classList.remove('show');
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
