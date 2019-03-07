@extends('layouts.application.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y h:i A");
$fechaa = date("m-Y h:i: A");
?>
<style>
.bootstrap-datetimepicker-widget{
   
    z-index: 99999 !import;
}
</style>
<input type="hidden" id="moneda" value="{{session('moneda_session')}}"/>

<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <form id="frm-excel-informe" method="post" enctype="multipart/form-data" target="_blank" action="/informesDatosVentasExcel">
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
                                <div class="form-group">
                                    <label >Escoge un periodo</label>
                                    <div class="input-group">
                                        <!--<input type="text" class="form-control bg-r text-center" name="start" id="start" value="'01-'.{{$fechaa}}"/>-->
                                        <input style="text-align: center;" type="text" name="start" id="start" class="form-control DatePicker" autocomplete="off" readonly="false" value="'01-'.{{$fechaa}}"/>
                                        <span class="input-group-addon">al</span>
                                        <input style="text-align: center;" type="text" name="end" id="end" class="form-control DatePicker" autocomplete="off" readonly="false" value="{{$fecha}}"/>
                                        <!--<input type="text" class="form-control bg-r text-center" name="end" id="end" value="{{$fecha}}" />-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="tipo_ped">Tipos de Pedido</label>
                            <select name="tipo_ped" id="tipo_ped" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                <option value="%" active>Todos</option>
                                @foreach($TipoPedido as $r)
                                    <option value="{{$r->id_tipo_pedido}}">{{$r->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="tipo_doc">Comprobantes</label>
                            <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control"  data-live-search="true" autocomplete="off">
                                <option value="%" active>Todos</option>
                                @foreach($Comprobantes as $r)
                                    <option value="{{$r->id_tipo_doc}}">{{$r->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="cod_cajas">Cajas</label>
                            <select name="cod_cajas" id="cod_cajas" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                <option value="%">Todas</option>
                                @foreach($Cajas as $r)
                                    <option value="{{$r->id_caja}}">{{$r->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2" style="display: none">
                        <div class="form-group">
                            <label for="tipo_ped">Clientes</label>
                            <select name="cliente" id="cliente" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">

                                <option value="%" active>Todos</option>
                                @foreach($Clientes as $r)
                                    <option value="{{$r->id_cliente}}">{{$r->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="punteo">
            <div class="row">
                <div class="col-lg-3">
                    <h5 class="no-margins"><strong>Descuento</strong></h5>
                    <h1 class="no-margins"><strong id="des_v"></strong></h1>
                </div>
                <div class="col-lg-3">
                    <h5 class="no-margins"><strong>Subtotal</strong></h5>
                    <h1 class="no-margins"><strong id="subt_v"></strong></h1>
                </div>
                <div class="col-lg-3">
                    <h5 class="no-margins"><strong>IGV</strong></h5>
                    <h1 class="no-margins"><strong id="igv_v"></strong></h1>
                </div>
                <div class="col-lg-3">
                    <h5 class="no-margins"><strong>Total</strong></h5>
                    <h1 class="no-margins"><strong id="total_v"></strong></h1>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                <thead>
                <tr>
                    <th width="10%">Fecha</th>
                    <th>Caja</th>
                    <th width="20%">Cliente</th>
                    <th>Documento</th>
                    <th class="text-right" width="15%">Pagos</th>
                    <th class="text-right">Total venta</th>
                    <th>Tipo de venta</th>
                    <th class="text-center">Estado</th>
                    <th class="text-right">Opciones</th>
                </tr>
                </thead>
            </table>
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

<script src="{{URL::to('rest/scripts/informes/ventas/func-ventas.js' )}}"></script>

@endsection('content')