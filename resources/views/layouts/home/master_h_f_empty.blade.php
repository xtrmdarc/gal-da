<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gal-Da | Sistema</title>
    <link href="{{ URL::to('home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/lightbox.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/main.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/auth/auth.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/home/styles.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/home/header.css') }}" rel="stylesheet">
    <link href="{{ URL::to('home/css/home/pricing.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ URL::to('home/js/html5shiv.js') }}"></script>
    <script src="{{ URL::to('home/js/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ URL::to('https://s3.amazonaws.com/galda-test-picture-empresas/Vector+3.2.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::to('home/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::to('home/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::to('home/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ URL::to('home/images/ico/apple-touch-icon-57-precomposed.png') }}">

    <script type="text/javascript" src="{{ URL::to('home/js/jquery.js') }}"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:700,100,200,300">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=PT+Sans:700,100,200,300,400">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Montserrat:700,100,200,300,400">

      <!-- Facebook Pixel Code -->
      <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '2056800597741705');
            fbq('track', 'PageView');
      </script>
          <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=2056800597741705&ev=PageView&noscript=1"
          /></noscript>
      <!-- End Facebook Pixel Code -->
</head><!--/head-->

<body>

    @yield('content')
</body>

<script type="text/javascript" src="{{ URL::to('home/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('home/js/lightbox.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('home/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('home/js/main.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('home/js/register/register-step.js') }}"></script>
      @yield('scripts')
</html>