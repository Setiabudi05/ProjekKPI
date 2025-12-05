<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    {{-- Menggunakan logo.png yang ada di folder assets/img --}}
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon"> 
    <title>ABSENSI MAGANG - Register</title>
    
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
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
        
        /* Style lainnya (sama seperti Login) */
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
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
            z-index: 10;
        }
        .toggle-password:hover {
            color: #888;
        }
    </style>
</head>

<body class="bg-gradient-login">
    {{-- 🌟 PEMUSATAN VERTIKAL DENGAN FLEXBOX 🌟 --}}
    <div class="container-login d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            
            {{-- 🌟 UKURAN CARD LEBIH RAMPING (col-xl-4) 🌟 --}}
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg my-3 w-100"> 
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    
                                    {{-- 🌟 START: BLOK LOGO & TEKS UTAMA (Disamakan dengan Login) 🌟 --}}
                                    <div class="text-center pt-3 pb-1">
                                        {{-- Logo PT --}}
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo PT Media Cepat Indonesia" style="max-height: 45px; margin-bottom: 5px;">

                                        {{-- Teks Absensi --}}
                                        <h2 class="h5 text-gray-900 font-weight-bold mb-0">Absensi Magang</h2>
                                        <p class="text-gray-600 small mb-3">PT Media Cepat Indonesia</p>
                                    </div>
                                    
                                    <div class="text-center">
                                        {{-- Teks Register --}}
                                        <h1 class="h4 text-gray-900 mb-0">Register Account</h1>
                                        <hr class="mt-2 mb-4 w-25 mx-auto"> 
                                    </div>
                                    {{-- 🌟 END: BLOK LOGO & TEKS UTAMA 🌟 --}}
                                    
                                    <form class="user" method="POST" action="{{ route('register') }}">
                                        @csrf

                                        {{-- Menampilkan semua pesan error validasi (jika ada) --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        {{-- 1. INPUT NAMA --}}
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- 2. INPUT EMAIL --}}
                                        <div class="form-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- ⭐ 3. INPUT PASSWORD dan KONFIRMASI PASSWORD DENGAN TOGGLE ⭐ --}}
                                        <div class="form-group row">
                                            {{-- Password --}}
                                            <div class="col-sm-6 mb-3 mb-sm-0 password-container">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="registerPassword" placeholder="Password" name="password" required>
                                                {{-- Mengubah data-target menjadi id yang benar --}}
                                                <i class="far fa-eye toggle-password" data-target="registerPassword"></i> 
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            {{-- Repeat Password --}}
                                            <div class="col-sm-6 password-container">
                                                <input type="password" class="form-control" id="registerPasswordConfirm" placeholder="Repeat Password" name="password_confirmation" required>
                                                {{-- Mengubah data-target menjadi id yang benar --}}
                                                <i class="far fa-eye toggle-password" data-target="registerPasswordConfirm"></i> 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register Account</button>
                                        </div>
                                    </form>

                                    <hr>
                                    {{-- Link Sudah Punya Akun (Dibuat lebih rapi dengan pb-3) --}}
                                    <div class="text-center pb-3">
                                        <a class="font-weight-bold small" href="{{ route('login.form') }}">Already have an Account?</a>
                                    </div>
                                    <div class="text-center">
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

    {{-- ⭐ JAVASCRIPT UNTUK TOGGLE PASSWORD PADA REGISTRASI ⭐ --}}
    <script>
        // Menggunakan querySelectorAll karena ada dua input password
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