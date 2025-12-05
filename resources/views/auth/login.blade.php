<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <title>ABSENSI MAGANG - Login</title>
    
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ruang-admin.min.css') }}" rel="stylesheet">
    
    <style>
        /* 🌟 PERUBAHAN BACKGROUND 🌟 */
        .bg-gradient-login {
            background-image: url('{{ asset("assets/img/bg.jpg") }}'); 
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
            background-blend-mode: multiply; 
            background-color: rgba(50, 70, 100, 0.4); 
        }
        
        /* Style lainnya */
        .card { border: none; border-radius: 1rem; }
        .btn-primary, .btn-primary:hover { box-shadow: 0 4px 6px rgba(100, 100, 100, 0.2); font-weight: 600; }
        .password-container { position: relative; }
        .password-container input { padding-right: 38px !important; }
        .toggle-password { position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; color: #ccc; z-index: 10; font-size: 1rem; }
        .toggle-password:hover { color: #888; }
        .auth-options { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>

<body class="bg-gradient-login">
    <div class="container-login d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            
            {{-- 🌟 PERUBAHAN UTAMA: MENGECILKAN LEBAR KOTAK (col-xl-4) 🌟 --}}
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-10">
                
                {{-- 🌟 MENGURANGI MARGIN VERTICAL PADA CARD (my-3) 🌟 --}}
                <div class="card shadow-lg my-3 w-100">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    
                                    {{-- BLOK LOGO & TEKS UTAMA (pt-3 pb-1) --}}
                                    <div class="text-center pt-3 pb-1">
                                        {{-- Logo PT --}}
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo PT Media Cepat Indonesia" style="max-height: 45px; margin-bottom: 5px;">

                                        {{-- Teks Absensi --}}
                                        <h2 class="h5 text-gray-900 font-weight-bold mb-0">Absensi Magang</h2>
                                        <p class="text-gray-600 small mb-3">PT Media Cepat Indonesia</p>
                                    </div>
                                    
                                    <div class="text-center">
                                        {{-- Teks Login --}}
                                        <h1 class="h4 text-gray-900 mb-0">Login</h1>
                                        <hr class="mt-2 mb-4 w-25 mx-auto">
                                    </div>
                                    
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf 

                                        {{-- PESAN STATUS & ERROR --}}
                                        @if (session('status'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('status') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        
                                        @error('email')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Gagal Login!</strong> {{ $message }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @enderror
                                        
                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" name="email" value="{{ old('email') }}" required autofocus>
                                        </div>

                                        <div class="form-group password-container">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password" name="password" required>
                                            <i class="far fa-eye toggle-password" id="togglePassword"></i> 
                                        </div>
                                        
                                        <div class="form-group auth-options">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="font-weight-bold small" href="{{ route('password.request') }}">Forgot Password?</a>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                        <hr>

                                        <a href="{{ route('socialite.google.redirect') }}" class="btn btn-google btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        
                                    </form>

                                    <hr>
                                    {{-- MENGURANGI PADDING BAWAH (pb-3) --}}
                                    <div class="text-center pb-3">
                                        <a class="font-weight-bold small" href="{{ route('register.form') }}">Create an Account!</a>
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
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const passwordInput = document.getElementById('exampleInputPassword');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>