<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="techtutorpro platform kursus online teknologi">
<meta name="keywords" content="techtutor, techtutorpro, kursus online, platform kursus online">
<meta name="google-site-verification" content="aEPRquVrya1KgKn5TXMgqpF5A47i050myHGriD61xXA" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>TechTutor Pro | {{ $pageTitle ?? '' }}</title>

<link rel="shortcut icon" href="{{ asset('images/logo-techtutor-pro-only.jpg') }}">

<!-- Toastr -->
<link rel="stylesheet" type="text/css" href="{{ asset('libs/toastr/build/toastr.min.css') }}">

<!-- Sweet Alert-->
<link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Bootstrap Css -->
<link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<link href="{{ asset('libs/prism/prism.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<!-- Custom Style Global -->
<style>

</style>

<!-- Custom Style -->
@stack('style')
