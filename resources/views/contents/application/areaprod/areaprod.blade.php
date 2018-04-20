@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
<br>
<div class="tabs-container">
    <ul class="nav nav-tabs right">
        <li class="active" id="tab1"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cube"></i>MESA&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_mesa"></span></a></li>
        <li id="tab2"><a data-toggle="tab" href="#tab-2"><i class="fa fa-columns"></i>MOSTRADOR&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_most"></span></a></li>
        <li id="tab3"><a data-toggle="tab" href="#tab-3"><i class="fa fa-bicycle"></i>DELIVERY&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_del"></span></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcm">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>MESA</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>MOZO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_mesa"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-2" class="tab-pane">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcmo">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>CAJERO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_most"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-3" class="tab-pane">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcde">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>CAJERO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_del"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/js/plugins/buzz/buzz.min.js')}}"></script>
<script src="{{URL::to('rest/scripts/areaprod/func_areap.js')}}"></script>
<script type="text/javascript">
    $('#area-p').addClass("active");
</script>
@endsection