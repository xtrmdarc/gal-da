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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{URL::to('js/socket.io.js') }}"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('https://s3.amazonaws.com/galda-test-picture-empresas/Vector+3.2.png') }}">
    <title>Gal-Da | Sistema</title>

    
    <link href="{{ URL::to('rest/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('rest/css/plugins/iCheck/skins/all.css') }}" rel="stylesheet" />
    @php /* <link href="{{ URL::to('rest/css/plugins/select/bootstrap-select.css') }}" rel="stylesheet"> */ @endphp
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link href="{{ URL::to('application/css/lib/owl.theme.default.min.css') }}" rel="stylesheet" />
    {{--<link href="{{ URL::to('application/css/lib/calendar2/semantic.ui.min.css') }}" rel="stylesheet" />--}}
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('rest/css/plugins/dataTables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    {{--<link href="{{ URL::to('application/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">--}}

    <!-- Custom CSS -->
    <link href="{{ URL::to('application/css/unificado.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/helper.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('rest/css/plugins/datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <link href="{{ URL::to('rest/css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

    <!-- Any Chart -->
    <script src="https://cdn.anychart.com/releases/8.2.1/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.1/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.2.1/js/anychart-exports.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.1/css/anychart-ui.min.css" />
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/8.2.1/fonts/css/anychart-font.min.css" />

    <!-- Custom REST CSS -->

    <link  rel="stylesheet" href="{{ URL::to('rest/css/bootstrap-clockpicker.min.css') }}"/>

    <!--hopscotch-->
    <link href="{{ URL::to('application/css/hopscotch/hopscotch.min.css') }}" rel="stylesheet">
    <!-- Custom PATCH CSS -->

    <link rel="stylesheet" href="{{URL::to('application/css/driver.min.css') }}">

    {{--<script src="{{ URL::to('rest/js/jquery-2.1.1.js') }}"></script>--}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
    <!--Custom JavaScript -->
    <script src="{{ URL::to('application/js/custom.min.js') }}"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="{{ URL::to('rest/js/bootstrap.min.js') }}"></script>
    
    <!-- Start of Async Drift Code -->
    <script>
        "use strict";
        
        !function() {
            var t = window.driftt = window.drift = window.driftt || [];
            if (!t.init) {
            if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
            t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
            t.factory = function(e) {
                return function() {
                var n = Array.prototype.slice.call(arguments);
                return n.unshift(e), t.push(n), t;
                };
            }, t.methods.forEach(function(e) {
                t[e] = t.factory(e);
            }), t.load = function(t) {
                var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
                o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
                var i = document.getElementsByTagName("script")[0];
                i.parentNode.insertBefore(o, i);
            };
            }
        }();
        
    </script>
    <!-- End of Async Drift Code -->
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
    @if(Auth::user()->id_rol == 1 ||  Auth::user()->id_rol == 2 ) 
        @include('layouts.application.sidebar')
    @endif


    <div class="page-wrapper">
        <div class="row page-titles" {{isset($vista_amplia)? "style=display:none" :'' }} >
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">{{isset($titulo_vista)?$titulo_vista:'Excelente Jornada!'}}</h3> 
            </div>
            <div class="col-md-7 align-self-center">
                @if(isset($breadcrumb))
                {{Breadcrumbs::render($breadcrumb)}}
                @endif 
            </div>
        </div>
    
        
        @yield('content')
    
    </div>
    
    @include('layouts.application.footer')
    <!-- customiza patrones para los operativos!-->

  

    @if(Auth::user()->id_rol == 3 ||  Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5  ) 
        <script>
            NonSideBarCssStyles();
        </script>
    @endif

</div>
<!-- End Wrapper -->s
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


<script src="{{ URL::to('application/js/lib/weather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/weather/weather-init.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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
@php /* <script src="{{ URL::to('rest/js/plugins/select/bootstrap-select.min.js') }}"></script> */ @endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
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
<script src="{{ URL::to('rest/js/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ URL::to('rest/scripts/footer.js') }}"></script>
<script src="{{ URL::to('application/js/driver.min.js') }}"></script>
{{--
<script>
    console.log(''+{!! json_encode(Auth::user()->id_rol)  !!}, ' areap : '+{!! json_encode(Auth::user()->id_rol)!!} );
    console.log({!!Auth::user()!!});
</script>
--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>--}}
<!-- Notification toastr setup -->        
<script type="text/javascript">
    @if(Session::has('message'))
      var type = "{!! Session::get('alert-type', 'info') !!}";
      
      switch(type){
          case 'info':
              toastr.info("{!! Session::get('message') !!}");
              break;
          
          case 'warning':
              toastr.warning("{!! Session::get('message') !!}");
              break;
  
          case 'success':
              toastr.success("{!! Session::get('message') !!}");
              break;
  
          case 'error':
              toastr.error("{!! Session::get('message') !!}");
              break;
      }
    @endif

    $(function(){
        /*
        setTimeout(function(){

        drift.SNIPPET_VERSION = '0.3.1';
        drift.load('4i42nk6d6zuw');
        },3000);

        */
       
    });
</script>

@yield('scripts')


</body>

</html>