<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi Magang')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    @stack('css')

    <style>
        body { background-color: #f0f2f5; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding-top: 20px;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar a {
            color: #bdc3c7;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #34495e;
            color: #fff;
            border-left: 5px solid #3498db;
        }
        .content { flex-grow: 1; padding: 30px; }
    </style>
</head>

<body>
<div class="wrapper">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h4 class="text-center mb-4 text-white">ABSENSI MAGANG</h4>

        <a href="{{ route('user.dashboard') }}"
           class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>

        <a href="{{ route('user.absensi.index') }}"
           class="{{ request()->routeIs('user.absensi.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-check me-2"></i> Absensi
        </a>

        <a href="{{ route('user.profil') }}"
           class="{{ request()->routeIs('user.profil') ? 'active' : '' }}">
            <i class="fas fa-user-circle me-2"></i> Profil
        </a>

        <div class="mt-5 mx-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')
</body>
</html>