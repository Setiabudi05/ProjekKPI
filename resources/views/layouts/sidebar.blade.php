<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative" style="padding-bottom: 0.5rem;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2">
                    <img src="{{ asset('assets1/img/logo.png') }}" alt="Logo GRA"
                        style="height: 55px; width: auto; object-fit: contain;">
                    <h3 class="mb-0">Absensi Magang</h3>
                </a>
            </div>
            <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                    <label class="form-check-label"></label>
                </div>
            </div>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>

    <div class="sidebar-menu">
        <ul class="menu mt-0">
            <li class="sidebar-title" style="padding-top: 0;">Menu</li>
            
            <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-title">Manajemen Magang</li>

            <li class="sidebar-item {{ request()->routeIs('admin.interns.*') ? 'active' : '' }}">
                <a href="{{ route('admin.interns.index') }}" class="sidebar-link">
                    <i class="bi bi-people-fill"></i><span>Data Peserta Magang</span>
                </a>
            </li>

            <li class="sidebar-title">Laporan & Presensi</li>

            {{-- Fitur Rekap Absensi Baru --}}
            <li class="sidebar-item {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}">
                <a href="{{ route('admin.attendance.index') }}" class="sidebar-link">
                    <i class="bi bi-calendar-check"></i><span>Rekap Absensi</span>
                </a>
            </li>

            {{-- Fitur Laporan Bulanan --}}
            <li class="sidebar-item {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-text"></i><span>Laporan Bulanan</span>
                </a>
            </li>

            <li class="sidebar-title">Akun</li>

            <li class="sidebar-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right" style="color: #dc3545;"></i><span style="color: #dc3545;">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>