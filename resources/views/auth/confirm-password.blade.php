<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('assets1/img/logo.png') }}" rel="icon">
    <title>ABSENSI MAGANG - Confirm Password</title>
    
    <link href="{{ asset('assets1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/css/ruang-admin.min.css') }}" rel="stylesheet">
    
    <style>
        .bg-gradient-login {
            background-image: linear-gradient(rgba(50, 70, 100, 0.5), rgba(50, 70, 100, 0.5)), url("{{ asset('assets1/img/bg.jpg') }}"); 
            background-size: cover;
            background-position: center; 
            background-attachment: fixed;
            height: 100vh;
        }
        .card { border: none; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important; }
        .login-form { padding: 40px 30px !important; }
        .btn-primary { background-color: #6777ef; border-color: #6777ef; font-weight: 600; }
        .password-container { position: relative; }
        .password-container input { padding-right: 40px !important; }
        .toggle-password { position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer; color: #ccc; z-index: 10; }
    </style>
</head>

<body class="bg-gradient-login">
    <div class="container-login d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100 mx-0">
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-10">
                <div class="card shadow-lg my-3">
                    <div class="card-body p-0">
                        <div class="login-form">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets1/img/logo.png') }}" alt="Logo" style="max-height: 50px;" class="mb-3">
                                <h2 class="h5 text-gray-900 font-weight-bold mb-0">Absensi Magang</h2>
                                <p class="text-gray-600 small">PT Media Cepat Indonesia</p>
                                <hr class="mt-2 mb-4 w-25 mx-auto">
                                <h1 class="h4 text-gray-900">Confirm Password</h1>
                            </div>

                            <div class="mb-4 small text-gray-700 text-center">
                                Harap konfirmasi kata sandi Anda sebelum melanjutkan.
                            </div>

                            <form class="user" method="POST" action="{{ route('password.confirm') }}">
                                @csrf 
                                <div class="form-group mb-4 password-container">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="confirmPassword" placeholder="Password" name="password" required>
                                    <i class="far fa-eye toggle-password" data-target="confirmPassword"></i> 
                                    @error('password')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block shadow-sm">Confirm Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets1/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>