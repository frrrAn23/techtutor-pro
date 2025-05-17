<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>TechTutor Pro | Registrasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo-techtutor-pro-only.jpg') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Registrasi gratis</h5>
                                        <p>Buat akun TechTutor Pro untuk mulai belajar.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{ url('/') }}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('images/logo-techtutor-pro-only.jpg') }}" alt="" class="rounded-circle" height="50">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                            <form method="POST" action="{{ route('register') }}" class="form-horizontal">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukan nama" name="name" value="{{ old('name') }}">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Masukan username" name="username" value="{{ old('username') }}">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukan email" name="email" value="{{ old('email') }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukan password" name="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password-confirm" placeholder="Ketik ulang password anda" name="password_confirmation">

                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-1 text-center">
                                    <div class="mt-1 text-center">
                                        <p class="text-muted mb-2">Atau registrasi dengan</p>
                                        <div class="d-grid justify-content-center gap-2" > <!-- justify-content-center bisa dtambahkan/dihapus -->
                                            <a href="{{ route('register.google') }}" class="btn btn-outline-primary hover-effect"> <!-- Mengganti btn btn-light border dengan btn btn-outline-primary hover-effect -->
                                                <img src="{{ asset('./images/google.svg') }}" alt="Google" height="20" class="me-2">
                                                Sign in with Google
                                            </a>
                                            <a href="" class="btn btn-outline-primary hover-effect">
                                                <img src="{{ asset('./images/facebook.svg') }}" alt="Facebook" height="20" class="me-2">
                                                Sign in with Facebook
                                            </a>
                                            <a href="{{ route('register.github') }}" class="btn btn-outline-primary hover-effect"> 
                                                <img src="{{ asset('./images/GitHub_light.svg') }}" alt="GitHub" height="20" class="me-2">
                                                Sign in with GitHub
                                            </a>
                                        </div>
                                    </div>
                                </div>

                    <div class="mt-3 text-center">
                        <div>
                            <p class="mb-1">Sudah punya akun ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Login</a> </p>
                            <p>© {{ date('Y') }} TechTutor Pro. Made with <i class="mdi mdi-heart text-danger"></i> by TechTutor Pro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
