<div id="sidebar" class="active">
    <div class="sidebar-wrapper active shadow-sm" style="background: #fff; border-right: 1px solid #f1f5f9;">
        
        {{-- Custom CSS Sidebar --}}
        <style>
            /* Reset list agar tidak ada titik hitam di samping tombol */
            .sidebar-menu ul.menu {
                list-style: none !important;
                padding: 0;
                margin: 0;
            }

            /* Styling Dasar Menu Item */
            .sidebar-item .sidebar-link {
                border-radius: 12px !important;
                padding: 12px 18px !important;
                margin-bottom: 8px;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                background: transparent !important;
                color: #4b5563 !important; /* Warna abu gelap agar teks terbaca jelas */
                text-decoration: none !important;
                font-weight: 500;
            }

            /* Styling Menu AKTIF (Rekap Absensi, Dashboard, dll) */
            .sidebar-item.active > .sidebar-link {
                background-color: #484cce !important; /* Latar biru sangat muda */
                color: #4d62af !important; /* Warna teks biru tua saat aktif */
                font-weight: 700 !important;
                position: relative;
                box-shadow: none !important;
            }

            /* Indikator garis vertikal penanda di sisi kiri saat aktif */
            .sidebar-item.active > .sidebar-link::before {
                content: "";
                position: absolute;
                left: 0;
                top: 25%;
                height: 50%;
                width: 4px;
                background-color: #435ebe;
                border-radius: 0 5px 5px 0;
            }

            /* Efek Hover */
            .sidebar-item .sidebar-link:hover {
                background-color: #f8fafc !important;
                color: #435ebe !important;
            }

            /* Merapikan Ikon di dalam Menu */
            .sidebar-item .sidebar-link i { 
                margin-right: 15px; 
                font-size: 1.25rem;
                color: inherit; /* Warna ikon mengikuti teks */
                display: flex;
                align-items: center;
            }

            /* Tombol Logout - Menghilangkan titik hitam dan memberikan jarak */
            .sidebar-item-logout {
                list-style: none !important;
                margin-top: 3rem;
                padding: 0 10px;
            }
            
            #logout-btn-sidebar {
                border: 1.5px solid #ff7976;
                color: #ff7976;
                background: transparent;
                font-weight: bold;
                letter-spacing: 0.5px;
                transition: 0.3s;
            }

            #logout-btn-sidebar:hover {
                background-color: #ff7976;
                color: white !important;
            }
        </style>

        {{-- Header Sidebar: Logo & Nama Aplikasi --}}
        <div class="sidebar-header text-center pt-5 pb-2">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets1/img/logo.png') }}" alt="Logo" style="height: 60px; width: auto;" class="mb-2">
                    <h5 class="fw-bold text-dark mt-2" style="letter-spacing: 1px; font-size: 1.1rem;">ABSENSI MAGANG</h5>
                </a>
            </div>
            <div class="sidebar-toggler x d-xl-none">
                <a href="#" class="sidebar-hide"><i class="bi bi-x fs-3"></i></a>
            </div>
        </div>

        {{-- Navigasi Menu --}}
        <div class="sidebar-menu px-4 pt-4">
            <ul class="menu">
                {{-- Dashboard --}}
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Manajemen Peserta --}}
                <li class="sidebar-item {{ request()->routeIs('admin.interns.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.interns.index') }}" class="sidebar-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Data Peserta</span>
                    </a>
                </li>

                {{-- Rekap Absensi --}}
                <li class="sidebar-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.attendance.index') }}" class="sidebar-link">
                        <i class="bi bi-calendar2-check-fill"></i>
                        <span>Rekap Absensi</span>
                    </a>
                </li>

                {{-- Laporan Bulanan --}}
                <li class="sidebar-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan.index') }}" class="sidebar-link">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Laporan Bulanan</span>
                    </a>
                </li>

                {{-- Tombol Logout --}}
                <div class="sidebar-item-logout">
                    <a href="#" class="btn w-100 rounded-pill py-2 fw-bold" id="logout-btn-sidebar">
                        <i class="bi bi-box-arrow-right me-2"></i> LOGOUT
                    </a>
                </div>
            </ul>
        </div>
    </div>
</div>