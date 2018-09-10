@extends('layouts.application.master')

@section('content')

    @php
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
    $fecha = date("d-m-Y h:i A");
    $fechaa = date("m-Y h:i: A");
    @endphp
    
        <input type="hidden" id="moneda" value=""/>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-9">
                <h2></h2>
            </div>
        </div>

        <div class="wrapper wrapper-content animated shake">
            <div class="ibox">
                <form method="post" enctype="multipart/form-data" target="_blank" action="/informesDatosVentasExcel">
                    @csrf
                    <div class="ibox-title">
                        <div class="ibox-title-buttons pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Excel</button>
                            <a class="btn btn-warning" href="/informes"><i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
                        </div>
                        <h5><strong><i class="fa fa-list"></i> Total de las Ventas</strong></h5>
                    </div>
                    <div class="ibox-content" style="position: relative; min-height: 30px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group padding_infF">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-r text-center" name="start" id="start" value="'01-'.{{$fechaa}}"/>
                                                <span class="input-group-addon">al</span>
                                                <input type="text" class="form-control bg-r text-center" name="end" id="end" value="{{$fecha}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group padding_infF">
                                    <select name="tipo_ped" id="tipo_ped" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                        <option value="%" active>Todos los TipoPedidos</option>
                                        @foreach($TipoPedido as $r)
                                            <option value="{{$r->id_tipo_pedido}}">{{$r->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group padding_infF">
                                    <select name="cod_cajas" id="cod_cajas" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                        <option value="%">Todas las cajas</option>
                                        @foreach($Cajas as $r)
                                            <option value="{{$r->id_caja}}">{{$r->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group padding_infF">
                                    <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control"  data-live-search="true" autocomplete="off">
                                        <option value="%" active>Todos los comprobantes</option>
                                        <option value="1">BOLETA</option>
                                        <option value="2">FACTURA</option>
                                        <option value="3">TICKET</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2 id="totalVentasI"></h2>
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
                                    <h2 id="nVentasI"></h2>
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
                                    <h2 id="nClientesI"></h2>
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
    
    <script src="{{URL::to('rest/scripts/informes/ventas/func-ventasF.js' )}}"></script>

@endsection('content')