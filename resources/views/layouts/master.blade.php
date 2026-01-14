<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul: Dinamis sesuai halaman --}}
    <title>AbsenMagang | @yield('title')</title>

    {{-- Favicon: Mengarah ke folder asset yang benar --}}
    <link rel="shortcut icon" href="{{ asset('assets1/img/logo.png') }}" type="image/x-icon">
    
    {{-- CSS Bawaan Mazer (CDN resmi untuk memastikan tampilan stabil) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Optimasi agar konten lebih naik ke atas dan rapi */
        #main {
            padding-top: 0 !important;
        }

        #main-content {
            padding: 1.2rem 2rem !important; 
        }

        .page-heading {
            margin-bottom: 1rem !important;
        }

        /* Styling logo di sidebar agar proporsional */
        .sidebar-header img {
            height: auto;
            max-width: 50px;
        }

        /* Perbaikan untuk Navbar */
        .navbar {
            padding: 1rem 2rem !important;
        }
    </style>
    @stack('css')
</head>

<body>
    {{-- Script Inisialisasi Tema (Dark/Light) --}}
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js"></script>

    <div id="app">
        {{-- 1. SIDEBAR --}}
        <div id="sidebar">
            @include('layouts.sidebar')
        </div>

        {{-- 2. AREA UTAMA --}}
        <div id="main" class='layout-navbar'>
            
            {{-- 3. NAVBAR/HEADER --}}
            <header class='mb-2'>
                @include('layouts.navigation')
            </header>

            {{-- 4. CONTENT --}}
            <div id="main-content">
                <div class="page-heading">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    {{-- Scripts Dasar Mazer --}}
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/components/dark.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/compiled/js/app.js"></script>
    
    {{-- JS Tambahan --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('js')

    {{-- 
       PENTING: Hanya biarkan @include di bawah ini jika Anda SUDAH 
       menjalankan `php artisan sweetalert:publish`. 
       Jika masih error, hapus atau komentari baris di bawah ini.
    --}}
    @if(View::exists('sweetalert::alert'))
        @include('sweetalert::alert')
    @endif

</body>
</html>