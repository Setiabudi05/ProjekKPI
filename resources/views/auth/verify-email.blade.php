<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verifikasi Email - ABSENSI MAGANG</title>
    
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ruang-admin.min.css') }}" rel="stylesheet">
    
    <style>
        /* 🌟 PERUBAHAN BACKGROUND (Disamakan dengan halaman Login) 🌟 */
        .bg-gradient-login {
            background-image: url('{{ asset("assets/img/bg.jpg") }}'); 
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
            background-blend-mode: multiply; 
            background-color: rgba(50, 70, 100, 0.4); 
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .btn-link {
            padding: 0;
            font-weight: bold; /* Menambahkan penekanan pada tombol logout */
        }
        .text-sm { /* Definisi tambahan karena kelas ini bukan standar Bootstrap 4 */
            font-size: 0.875em;
        }
    </style>
</head>

<body class="bg-gradient-login">
    {{-- 🌟 PEMUSATAN VERTIKAL DENGAN FLEXBOX 🌟 --}}
    <div class="container-login d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            
            {{-- UKURAN CARD RAMPING (col-xl-4) --}}
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-10">
                <div class="card shadow-lg my-3 w-100"> {{-- my-3 untuk margin vertikal --}}
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    
                                    {{-- 🌟 START: BLOK LOGO & TEKS UTAMA 🌟 --}}
                                    <div class="text-center pt-4 pb-1">
                                        {{-- Logo PT --}}
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo PT Media Cepat Indonesia" style="max-height: 45px; margin-bottom: 5px;">

                                        {{-- Teks Absensi --}}
                                        <h2 class="h5 text-gray-900 font-weight-bold mb-0">Absensi Magang</h2>
                                        <p class="text-gray-600 small mb-4">PT Media Cepat Indonesia</p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Verifikasi Email Anda</h1>
                                    </div>
                                    {{-- 🌟 END: BLOK LOGO & TEKS UTAMA 🌟 --}}

                                    {{-- PESAN STATUS (Link Verifikasi Terkirim Ulang) --}}
                                    @if (session('status') == 'verification-link-sent')
                                        <div class="alert alert-success" role="alert">
                                            Link verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                                        </div>
                                    @endif

                                    <div class="mb-4 text-sm text-gray-600 px-3">
                                        Terima kasih sudah mendaftar! Sebelum melanjutkan, silakan periksa kotak masuk email Anda untuk link verifikasi.
                                        Jika Anda tidak menerima email tersebut, klik tombol di bawah untuk meminta yang baru.
                                    </div>
                                    
                                    <div class="px-3 pb-4"> {{-- Padding disesuaikan --}}
                                        
                                        {{-- 1. FORM KIRIM ULANG LINK --}}
                                        <form method="POST" action="{{ route('verification.send') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-block mb-3">
                                                Kirim Ulang Email Verifikasi
                                            </button>
                                        </form>

                                        {{-- 2. FORM LOGOUT (Untuk mengganti akun) --}}
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                            @csrf
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-link text-danger font-weight-bold">
                                                    Log Out / Ganti Akun
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/ruang-admin.min.js') }}"></script>
</body>

</html>