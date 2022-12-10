<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('landing/css/bootstrap.min.css')}}">
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('landing/css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/hero-slider.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/owl-carousel.css')}}">
    <link rel="stylesheet" href="{{asset('/landing/vendors/toastify/toastify.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/style.css')}}">
    <script src="{{asset('landing/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
    @stack('css')
    <title>@yield('title')</title>
</head>
<body>
    @include('common.landing.header')

    @yield('main')

    @include('common.landing.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="{{asset('landing/js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>

    <script src="{{asset('landing/js/vendor/bootstrap.min.js')}}"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="{{asset('landing/js/datepicker.js')}}"></script>
    <script src="{{asset('landing/js/plugins.js')}}"></script>
    <script src="{{asset('/landing/vendors/toastify/toastify.js')}}"></script>
    <script src="{{asset('landing/js/main.js')}}"></script>
    @stack('js')
</body>
</html>
