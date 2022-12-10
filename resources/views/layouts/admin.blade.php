<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.css')}}">

    <link rel="stylesheet" href="{{asset('admin/vendors/iconly/bold.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/toastify/toastify.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/app.css')}}">

    @stack('css')
    <title>@yield('title')</title>
</head>
<body>

<div id="app">

    @include('common.admin.sidebar')

    <div id="main" class='layout-navbar'>

        @include('common.admin.header')

        <div id="main-content">
            @yield('main')

            @include('common.admin.footer')
        </div>
    </div>

</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
<!--javascript-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('landing/js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
<script src="{{asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/vendors/toastify/toastify.js')}}"></script>
@stack('pre-js')
<script src="{{asset('admin/js/main.js')}}"></script>
@stack('js')

</body>
</html>
