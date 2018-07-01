@extends('layouts.application.master')

@section('content')

        @php
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("d-m-Y h:i A");
        $fechaa = date("d-m-Y 12:00 ");

        @endphp
        <div class="page-wrapper">
                <input type="hidden" id="moneda" value=""/>

                <div class="wrapper wrapper-content animated shake">
                        <div class="ibox">
                                <div class="ibox-title">
                                        <div class="row">
                                                <div class="col-sm-12">
                                                        <h3 style="margin-bottom: 10px;">Resumen de Ventas - Tablero</h3>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-sm-1">
                                                        <i class="fa fa-info-circle"></i> Datos obtenidos:
                                                </div>
                                                <div class="col-sm-4">
                                                        <div class="form-group">
                                                                <div class="input-group">
                                                                        <input type="text" class="form-control bg-r" name="start" id="start" value="<?php echo $fechaa,' AM'; ?>" disabled/>
                                                                        <span class="input-group-addon">al</span>
                                                                        <input type="text" class="form-control bg-r" name="end" id="end" value="<?php echo $fecha; ?>" disabled/>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="totalVentasI">{{$total_venta}}</h2>
                                                                        <p class="m-b-0">Total Revenue</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="nVentasI">{{$total_n_venta}}</h2>
                                                                        <p class="m-b-0">Sales</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="nClientesI">{{$n_clientes}}</h2>
                                                                        <p class="m-b-0">Customer</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                                <div class="panel">
                                                                        <div class="panel-heading">
                                                                                <div class="panel-title">
                                                                                        <h4>Ventas contra Cantidad</h4>
                                                                                </div>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                                <canvas id="singelBarChart"></canvas>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                                <div class="panel">
                                                                        <div class="panel-heading">
                                                                                <div class="panel-title">
                                                                                        <h4>Dinero contra Ventast</h4>
                                                                                </div>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                                <canvas id="singelBarChart"></canvas>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>

        <div class="modal inmodal fade" id="detalle" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                        <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
                                </div>
                                <div class="modal-body">
                                        <div class="table-responsive">
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <table class="table table-hover table-condensed table-striped">
                                                        <thead>
                                                        <tr>
                                                                <th>Cantidad</th>
                                                                <th>Producto</th>
                                                                <th>P.U.</th>
                                                                <th class="text-right">Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="lista_p"></tbody>
                                                </table>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                        </div>
                </div>
        </div>
        </div>


@endsection('content')