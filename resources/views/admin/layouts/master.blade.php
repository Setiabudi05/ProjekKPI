<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Absensi Magang - @yield('title', 'Dashboard')</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ruang-admin.min.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Absensi Magang</div>
            </a>
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Menu</div>

            <li class="nav-item {{ request()->is('admin/absensi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/absensi') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Absensi</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan Absensi</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/data-magang*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.interns.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Data Anak Magang</span></a>
            </li>
            <hr class="sidebar-divider">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="{{ asset('assets/img/boy.png') }}"
                                    style="max-width: 40px">
                                <span
                                    class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name ?? 'Admin Absensi' }}</span>
                            </a>

                            {{-- START: DROPDOWN MENU & LOGOUT --}}
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>

                                {{-- PENTING: LINK LOGOUT YANG HILANG, KINI DIKEMBALIKAN --}}
                                <a class="dropdown-item" href="javascript:void(0)" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </div>
                            {{-- END: DROPDOWN MENU & LOGOUT --}}
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid" id="container-wrapper">
                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>copyright &copy;
                            <script> document.write(new Date().getFullYear()); </script> - Absensi Magang
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- FORM LOGOUT TERSEMBUNYI (PENTING! - Harus tetap di sini, di luar wrapper) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/ruang-admin.min.js') }}"></script>
    @yield('scripts')
</body>

</html>