<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ABSENSI MAGANG - Forgot Password</title>
    
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
        /* Style tambahan untuk konsistensi */
        .login-form {
            padding: 0 2rem; /* Tambahkan padding horizontal agar konten tidak terlalu rapat */
        }
    </style>
</head>

<body class="bg-gradient-login">
    {{-- 🌟 PEMUSATAN VERTIKAL DENGAN FLEXBOX 🌟 --}}
    <div class="container-login d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            
            {{-- 🌟 UKURAN CARD RAMPING (col-xl-4) 🌟 --}}
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
                                        <h1 class="h4 text-gray-900 mb-0">Forgot Password</h1>
                                        <hr class="mt-2 mb-4 w-25 mx-auto"> 
                                    </div>
                                    {{-- 🌟 END: BLOK LOGO & TEKS UTAMA 🌟 --}}
                                    
                                    {{-- Teks Instruksi Diletakkan di sini untuk konsistensi margin --}}
                                    <div class="text-center mb-4 small text-gray-700">
                                        Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                                    </div>

                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf 

                                        {{-- Menampilkan pesan status (misal: link terkirim) --}}
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Enter Email Address" name="email" value="{{ old('email') }}" required autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Reset Password
                                            </button>
                                        </div>
                                    </form>

                                    <hr>
                                    
                                    {{-- Link Bawah (Create Account & Already have Account) --}}
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="{{ route('register.form') }}">Create an Account!</a>
                                    </div>
                                    <div class="text-center pb-3"> {{-- pb-3 untuk padding bawah --}}
                                        <a class="font-weight-bold small" href="{{ route('login.form') }}">Already have an Account?</a>
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