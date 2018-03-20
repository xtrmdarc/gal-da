<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('application/images/favicon.png') }}">
    <title>Ela - Bootstrap Admin Dashboard Template</title>

    <link href="{{ URL::to('application/css/lib/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/lib/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('application/css/lib/owl.theme.default.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('application/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::to('application/css/helper.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/style.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
</head>

<body class="fix-header fix-sidebar">
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- Main wrapper  -->
<div id="main-wrapper">
    <!-- header header  -->
    @guest
      {{--/*@include('layouts.application.error_pages.404')*/--}}
    <h2>AUN NO :v </h2>
    <a href="{{ redirect('/login')}}">Regresa</a>
    @else
        @include('layouts.application.head')
        @include('layouts.application.sidebar')
        @yield('content')
        @include('layouts.application.footer')
        @endguest
</div>
<!-- End Wrapper -->
<!-- All Jquery -->
<script src="{{ URL::to('application/js/lib/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ URL::to('application/js/lib/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ URL::to('application/js/jquery.slimscroll.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ URL::to('application/js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ URL::to('application/js/lib/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>


<script src="{{ URL::to('application/js/lib/datamap/d3.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/datamap/topojson.js') }}"></script>
<script src="{{ URL::to('application/js/lib/datamap/datamaps.world.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/datamap/datamap-init.js') }}"></script>

<script src="{{ URL::to('application/js/lib/weather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/weather/weather-init.js') }}"></script>
<script src="{{ URL::to('application/js/lib/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/owl-carousel/owl.carousel-init.js') }}"></script>


<script src="{{ URL::to('application/js/lib/chartist/chartist.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/chartist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/chartist/chartist-init.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ URL::to('application/js/custom.min.js') }}"></script>

</body>

</html>