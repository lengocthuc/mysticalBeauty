<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <style>
        #auth {
            position: relative;
        }
        #auth::before{
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-size: cover !important;
            filter: blur(2px);
            background: url('{{asset('/img/background-login.jpg')}}')
        }
        .danger{
            background: #FD5D5D !important;
        }
        .success{
            background: #6BCB77 !important;
        }
        .info{
            background: #92B4EC !important;
        }
    </style>
    @stack('css')
    <title>@yield('title')</title>
</head>

<body>
<div id="auth" class="vh-100">
    @yield('main')
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="{{asset('landing/js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
<script src="{{asset('/landing/js/vendor/bootstrap.min.js')}}"></script>
<script>
    function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
            if (!timer) {
                func.apply(this, args);
            }
            clearTimeout(timer);
            timer = setTimeout(() => {
                timer = undefined;
            }, timeout);
        };
    }
</script>
@stack('js')
</body>

</html>
