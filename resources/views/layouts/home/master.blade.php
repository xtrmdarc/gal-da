<!DOCTYPE html>
<html lang="es">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @yield('metas')
      <title>Gal-Da | Software para restaurantes gratis en línea </title>
      <meta name="google-site-verification" content="Uwkj6rtsfo0SZxzCbHpV5ZCFJqj3YB7p4f1fXQ5V35U" />
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
    
      
      <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Nunito:700,100,200,300">
      <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=PT+Sans:700,100,200,300,400">
      <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Montserrat:700,100,200,300,400">
          <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-49332747-5"></script>
      <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-49332747-5');
      </script>

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

      @include('layouts.home.head')
      @yield('content')
      @include('layouts.home.footer')
      <script type="text/javascript" src="{{ URL::to('home/js/jquery.js') }}"></script>
    
      <script type="text/javascript" src="{{ URL::to('home/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::to('home/js/lightbox.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::to('home/js/wow.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::to('home/js/main.js') }}"></script>
      <script type="text/javascript" src="{{ URL::to('home/js/register/register-step.js') }}"></script>
      <!-- Begin of Chaport Live Chat code -->
      <script type="text/javascript">
      (function(w,d,v3){
      w.chaportConfig = { appId : '5bc779bcc3874a4eb186196c' };

      if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);
      </script>
      @yield('scripts')
      <!-- End of Chaport Live Chat code -->
</body>
</html>