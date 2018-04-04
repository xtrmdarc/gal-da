@extends('Layouts.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y");
$fechaa = date("m-Y");
?>

<input type="hidden" id="moneda" value=""/>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a class="btn btn-warning" href="/informes"> <i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
            </div>
            <h5><strong><i class="fa fa-list"></i> Compras por proveedor</strong></h5>
        </div>
        <div class="ibox-content" style="position: relative; min-height: 30px;">
            <div class="row">
                <form method="post" enctype="multipart/form-data" target="_blank" action="#">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-r text-center" name="start" id="start" value="'01-'.{{$fechaa}}"/>
                                        <span class="input-group-addon">al</span>
                                        <input type="text" class="form-control bg-r text-center" name="end" id="end" value="{{$fecha}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <select name="cod_prov" id="cod_prov" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                <option value="%" active>Todos los proveedores</option>
                                @foreach($Proveedores as $r)
                                    <option value="{{$r->id_prov}}">{{$r->ruc}} - {{$r->razon_social}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                <option value="%" active>Todos los comprobantes</option>
                                <option value="1">BOLETA</option>
                                <option value="2">FACTURA</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="punteo">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="no-margins"><strong>Subtotal</strong></h5>
                        <h1 class="no-margins"><strong id="subt_c"></strong></h1>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="no-margins"><strong>IGV</strong></h5>
                        <h1 class="no-margins"><strong id="igv_c"></strong></h1>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="no-margins"><strong>Total</strong></h5>
                        <h1 class="no-margins"><strong id="total_c"></strong></h1>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                    <thead>
                    <tr>
                        <th width="10%">Fecha</th>
                        <th>Documento</th>
                        <th>Serie - Nro.</th>
                        <th style="width: 30%">Proveedor</th>
                        <th class="text-right">Total</th>
                        <th>Forma de pago</th>
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
                <h5 class="modal-title" style="font-size: 18px">Detalle</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>P.U.</th>
                            <th class="text-right">Importe</th>
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

<div class="modal inmodal fade" id="m_detalle" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
            </div>
            <div class="modal-body">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Interes</th>
                        <th class="text-right">Importe</th>
                        <th class="text-center">Estado</th>
                        <th class="text-right">Opciones</th>
                    </tr>
                    </thead>
                    <tbody id="list_cd"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="m_detallec" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
            </div>
            <div class="modal-body">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>Cajero</th>
                        <th>Fecha/Hora</th>
                        <th class="text-right">Importe</th>
                    </tr>
                    </thead>
                    <tbody id="list_cdc"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Atr&aacute;s</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::to('scripts/informes/compras/func-proveedores.js' ) }}"></script>

@endsection('content')