<?php
//$du = $_SESSION["datosusuario"];
//$de = $_SESSION["datosempresa"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema para restaurantes, cevicherias, entre otros</title>

    <link href="{{ URL::to('img/restepe.ico') }}" rel='shortcut icon' type='image/x-icon'/>
    <link href="{{ URL::to('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ URL::to('jquery-ui-1.12.1/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/stylep.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/select/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/formvalidation/formValidation.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/wizard/wizard.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/iCheck/skins/all.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/dataTables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{ URL::to('css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ URL::to('js/jquery-2.1.1.js') }}"></script>
</head>

<body class="canvas-menu fixed-nav">
    @include('Layouts.head')
        @yield('content')
    @include('Layouts.footer')