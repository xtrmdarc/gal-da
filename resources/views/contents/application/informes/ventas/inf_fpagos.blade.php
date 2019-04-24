@extends('layouts.application.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y");
$fechaa = date("m-Y");
?>

<style>
    .bootstrap-datetimepicker-widget{

        z-index: 99999 !import;
    }
</style>

<input type="hidden" id="moneda" value="{{session('moneda_session')}}"/>
<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <form id="frm-excel-informe" method="post" enctype="multipart/form-data" target="_blank" action="/informesDatosFpagoExcel">
            @csrf
            <div class="ibox-title">
                <div class="ibox-title-buttons pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Excel</button>
                    <a class="btn btn-warning" ui-sref="informes.ventas" href="/informes"> <i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
                </div>
                <h5><strong><i class="fa fa-list"></i> Ventas por forma de pago</strong></h5>
            </div>
            <div class="ibox-content" style="position: relative; min-height: 30px;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >Escoge un periodo</label>
                            <div class="input-group">
                                <input style="text-align: center;" type="text" name="start" id="start" class="form-control DatePicker" autocomplete="off" readonly="true" value="'01-'.{{$fechaa}}"/>
                                <!--<input type="text" class="form-control bg-r text-center" name="start" id="start" value="'01-'.{{$fechaa}}"/>-->
                                <span class="input-group-addon">al</span>
                                <!--<input type="text" class="form-control bg-r text-center" name="end" id="end" value="{{$fecha}}" />-->
                                <input style="text-align: center;" type="text" name="end" id="end" class="form-control DatePicker" autocomplete="off" readonly="true" value="{{$fecha}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="sucu_filter">Sucursal</label>
                            <select name="sucu_filter" id="sucu_filter" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                <option value="%" active>Todas las Sucursales</option>
                                @foreach($sucursales_filtro as $r)
                                    <option value="{{$r->id}}">{{$r->nombre_sucursal}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="sucu_filter">Tipos de Pago</label>
                            <select name="tipo_p" id="tipo_p" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                <option value="%" active>Todos los tipos de pago</option>
                                <option value="1">EFECTIVO</option>
                                <option value="2">TARJETA</option>
                                <option value="3">AMBOS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="punteo">
                    <div class="row">
                        <div class="col-lg-12">
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
                            <th>Fecha</th>
                            <th width="20%">Cliente</th>
                            <th>Documento</th>
                            <th>Num.doc.</th>
                            <th class="text-right" width="15%">Pagos</th>
                            <th class="text-right">Total venta</th>
                            <th class="text-right">Tipo de venta</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ URL::to('rest/scripts/informes/ventas/func-fpago.js' ) }}"></script>

@endsection('content')