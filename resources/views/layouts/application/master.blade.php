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
    
    
    <link href="{{ URL::to('rest/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('rest/css/plugins/iCheck/skins/all.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('rest/css/plugins/select/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/lib/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/lib/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('application/css/lib/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('application/css/lib/calendar2/semantic.ui.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('rest/css/plugins/dataTables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    
    <link href="{{ URL::to('application/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ URL::to('application/css/helper.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('rest/css/plugins/datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    
    <link href="{{ URL::to('rest/css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    
    
    <!-- Custom REST CSS -->
    
    
    <!-- Custom PATCH CSS -->
    
    
    <script src="{{ URL::to('rest/js/jquery-2.1.1.js') }}"></script>
    

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

        @include('layouts.application.head')
        @include('layouts.application.sidebar')
        @yield('content')
        @include('layouts.application.footer')

</div>
<!-- End Wrapper -->
<!-- All Jquery -->
@php /* <script src="{{ URL::to('application/js/lib/jquery/jquery.min.js') }}"></script> */@endphp
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

<script src="{{ URL::to('application/js/lib/owl-carousel/owl.carousel-init.js') }}"></script>


<script src="{{ URL::to('application/js/lib/chartist/chartist.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/chartist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/chartist/chartist-init.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ URL::to('application/js/custom.min.js') }}"></script>

<script src="{{ URL::to('rest/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ URL::to('rest/js/inspinia.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/pace/pace.min.js') }}"></script>
<!-- Chosen -->
<script src="{{ URL::to('rest/js/plugins/chosen/chosen.jquery.js') }}"></script>
<!-- DatePicker -->
<script src="{{ URL::to('rest/js/plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::to('rest/js/plugins/select/bootstrap-select.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ URL::to('rest/js/plugins/formvalidation/formValidation.min.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/formvalidation/framework/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::to('rest/js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- TouchSpin -->
<script src="{{ URL::to('rest/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<!-- Toastr script -->
<script src="{{ URL::to('rest/js/plugins/toastr/toastr.min.js') }}"></script>
<!-- Moment script -->
<script src="{{ URL::to('rest/js/plugins/moment/moment.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/moment/moment-with-locales.js') }}"></script>
<!-- Input Mask-->
<script src="{{ URL::to('rest/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
<!-- Datatable -->
<script src="{{ URL::to('rest/js/plugins/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('rest/js/plugins/dataTables/dataTables.bootstrap.min.js') }}"></script>
<!-- DataTimePicker -->
<script src="{{ URL::to('rest/js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ URL::to('rest/scripts/footer.js') }}"></script>

</body>

</html>