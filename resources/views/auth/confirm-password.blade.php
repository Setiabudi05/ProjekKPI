<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ABSENSI MAGANG - Confirm Password</title>
    
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ruang-admin.min.css') }}" rel="stylesheet">
    
    <style>
        .bg-gradient-login {
            /* Menggunakan gambar background */
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
        .btn-primary, .btn-primary:hover {
            box-shadow: 0 4px 6px rgba(100, 100, 100, 0.2);
            font-weight: 600;
        }
        /* Style untuk ikon toggle password */
        .password-container {
            position: relative;
        }
        .password-container input {
            padding-right: 38px !important;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
            z-index: 10;
            font-size: 1rem;
        }
        .toggle-password:hover {
            color: #888;
        }
    </style>
</head>

<body class="bg-gradient-login">
    {{-- PEMUSATAN VERTIKAL DENGAN FLEXBOX --}}
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
                                    <div class="text-center pt-3 pb-1">
                                        {{-- Logo PT --}}
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo PT Media Cepat Indonesia" style="max-height: 45px; margin-bottom: 5px;">

                                        {{-- Teks Absensi --}}
                                        <h2 class="h5 text-gray-900 font-weight-bold mb-0">Absensi Magang</h2>
                                        <p class="text-gray-600 small mb-3">PT Media Cepat Indonesia</p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-0">Confirm Password</h1>
                                        <hr class="mt-2 mb-4 w-25 mx-auto"> 
                                    </div>
                                    {{-- 🌟 END: BLOK LOGO & TEKS UTAMA 🌟 --}}

                                    {{-- Teks Instruksi --}}
                                    <div class="mb-4 small text-gray-700">
                                        Harap konfirmasi kata sandi Anda sebelum melanjutkan.
                                    </div>

                                    <form class="user" method="POST" action="{{ route('password.confirm') }}">
                                        @csrf 

                                        {{-- Menampilkan pesan error validasi --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        {{-- Input Password dengan Toggle --}}
                                        <div class="form-group password-container">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="confirmPassword" placeholder="Password" name="password" required autocomplete="current-password">
                                            <i class="far fa-eye toggle-password" data-target="confirmPassword"></i> 
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Confirm Password
                                            </button>
                                        </div>
                                    </form>

                                    <hr>
                                    <div class="text-center pb-3"> {{-- pb-3 untuk padding bawah --}}
                                        @if (Route::has('password.request'))
                                            <a class="font-weight-bold small" href="{{ route('password.request') }}">Forgot Your Password?</a>
                                        @endif
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
    
    {{-- JAVASCRIPT UNTUK TOGGLE PASSWORD --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function (e) {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>