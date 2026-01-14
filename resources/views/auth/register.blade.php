<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman Register Absensi Magang">
    <meta name="author" content="Media Cepat Indonesia">
    
    <link href="{{ asset('assets1/img/logo.png') }}" rel="icon">
    <title>ABSENSI MAGANG - Register</title>
    
    <link href="{{ asset('assets1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/css/ruang-admin.min.css') }}" rel="stylesheet">
    
    <style>
        /* 🌟 BACKGROUND FULL SCREEN (Identik dengan Login) 🌟 */
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
        .btn-primary:hover { background-color: #5a67d8; }
        
        .password-container { position: relative; }
        .password-container input { padding-right: 40px !important; }
        .toggle-password { 
            position: absolute; top: 50%; right: 15px; 
            transform: translateY(-50%); cursor: pointer; 
            color: #ccc; z-index: 10; 
        }
        .toggle-password:hover { color: #6e707e; }
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
                                <h1 class="h4 text-gray-900">Register Account</h1>
                            </div>
                            
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group mb-3 password-container">
                                    <input type="password" class="form-control" id="regPass" placeholder="Password" name="password" required>
                                    <i class="far fa-eye toggle-password" data-target="regPass"></i>
                                </div>
                                <div class="form-group mb-4 password-container">
                                    <input type="password" class="form-control" id="regPassConfirm" placeholder="Repeat Password" name="password_confirmation" required>
                                    <i class="far fa-eye toggle-password" data-target="regPassConfirm"></i>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block shadow-sm">Register</button>
                                </div>
                            </form>
                            <hr class="my-4">
                            <div class="text-center">
                                <span class="small text-muted">Already have an Account?</span>
                                <a class="font-weight-bold small text-primary" href="{{ route('login.form') }}"> Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets1/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets1/js/ruang-admin.min.js') }}"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const target = document.getElementById(this.getAttribute('data-target'));
                target.type = target.type === 'password' ? 'text' : 'password';
                this.classList.toggle('fa-eye'); this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>