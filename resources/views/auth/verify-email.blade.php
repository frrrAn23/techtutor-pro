<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>TechTutor Pro | Verifikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo-techtutor-pro-only.jpg') }}">

    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/toastr/build/toastr.min.css') }}">

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
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 text-muted">
                        <a href="{{ url('/') }}" class="d-block auth-logo">
                            <img src="{{ asset('images/logo-techtutorpro-horizontal.png') }}" alt="" height="50" class="auth-logo-dark mx-auto">
                            <img src="{{ asset('images/logo-techtutorpro-horizontal.png') }}" alt="" height="50" class="auth-logo-light mx-auto">
                        </a>
                        <p class="mt-3">Kursus online teknologi</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body">

                            <div class="p-2">
                                <div class="text-center">

                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <h4>Verifikasi email anda</h4>
                                        <p>Kami telah mengirimkan anda link verifikasi ke email <span class="fw-semibold">{{ Auth::user()->email }}</span>, anda perlu memverifikasi email anda untuk menggunakan techtutorpro</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Tidak menerima email ?
                            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-md">Kirim ulang</button>
                            </form>
                        </p>

                        <p>© {{ date('Y') }} TechTutor Pro. Made with <i class="mdi mdi-heart text-danger"></i> by TechTutor Pro
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

    <!-- Toastr -->
    <script src="{{ asset('libs/toastr/build/toastr.min.js') }}"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: 300,
            hideDuration: 1000,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        }
    </script>

    @if (session('success'))
        <script>toastr["success"]("{{ session('success') }}", "Success")</script>
    @elseif (session('error'))
        <script>toastr["error"]("{{ session('error') }}", "Error")</script>
    @endif
</body>
</html>
