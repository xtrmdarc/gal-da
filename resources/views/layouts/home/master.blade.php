<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | Triangle</title>
    <link href="{{ URL::to('home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/lightbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/main.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/responsive.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{ URL::to('home/js/html5shiv.js') }}"></script>
    <script src="{{ URL::to('home/js/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ URL::to('home/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::to('home/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to('home/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to('home/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ URL::to('home/images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->

<body>

        @include('layouts.home.head')
        @yield('content')
        @include('layouts.home.footer')

    <script type="text/javascript" src="{{ URL::to('home/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('home/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('home/js/lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('home/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('home/js/main.js') }}"></script>
</body>
</html>