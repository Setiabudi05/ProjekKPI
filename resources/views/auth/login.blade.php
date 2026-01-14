<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman Login Absensi Magang">
    <meta name="author" content="Media Cepat Indonesia">

    <link href="{{ asset('assets1/img/logo.png') }}" rel="icon">
    <title>ABSENSI MAGANG - Login</title>

    <link href="{{ asset('assets1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets1/css/ruang-admin.min.css') }}" rel="stylesheet">

    <style>
        /* 🌟 BACKGROUND FULL SCREEN 🌟 */
        .bg-gradient-login {
            background-image: linear-gradient(rgba(50, 70, 100, 0.5), rgba(50, 70, 100, 0.5)), 
                              url("{{ asset('assets1/img/bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
        }

        /* 🌟 PERAPIAN CARD 🌟 */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }

        .login-form {
            padding: 40px 30px !important;
        }

        .btn-primary {
            background-color: #6777ef;
            border-color: #6777ef;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #5a67d8;
        }

        /* 🌟 TOGGLE PASSWORD 🌟 */
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px !important;
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
            color: #6e707e;
        }

        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
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
                                <h1 class="h4 text-gray-900">Login</h1>
                            </div>

                            <form class="user" method="POST" action="{{ route('login') }}">
                                @csrf

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                        <strong>Gagal!</strong> Periksa email atau password Anda.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="form-group mb-3 password-container">
                                    <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" name="password" required>
                                    <i class="far fa-eye toggle-password" id="togglePassword"></i>
                                </div>

                                <div class="form-group mb-4 auth-options">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="font-weight-bold small text-primary" href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block shadow-sm">Login</button>
                                </div>

                                <div class="text-center my-3">
                                    <span class="text-muted small">Atau</span>
                                </div>

                                <a href="{{ route('socialite.google.redirect') }}" class="btn btn-outline-danger btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                            </form>

                            <hr class="my-4">
                            
                            <div class="text-center">
                                <span class="small text-muted">Belum punya akun?</span>
                                <a class="font-weight-bold small text-primary" href="{{ route('register.form') }}"> Buat Akun!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets1/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets1/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets1/js/ruang-admin.min.js') }}"></script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('exampleInputPassword');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>