@extends('layouts.application.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y h:i A");
$fechaa = date("-m-Y h:i A");
?>


<style>
    .bootstrap-datetimepicker-widget{

        z-index: 99999 !import;
    }
</style>

<input type="hidden" id="moneda" value="{{session('moneda_session')}}"/>

<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <form id="frm-excel-informe" method="post" enctype="multipart/form-data" target="_blank" action="/informesDatosRemunExcel">
            @csrf
            <div class="ibox-title">
                <div class="ibox-title-buttons pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Excel</button>
                    <a class="btn btn-warning" ui-sref="informes.ventas" href="/informes"> <i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
                </div>
                <h5><strong><i class="fa fa-list"></i> Egresos por remuneraci&oacute;n</strong></h5>
            </div>
            <div class="ibox-content" style="position: relative; min-height: 30px;">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label >Escoge un periodo</label>
                            <div class="input-group">
                                <input style="text-align: center;" type="text" name="start" id="start" class="form-control DatePicker" autocomplete="off" readonly="true" value="{{'01'.$fechaa}}"/>
                                <!--<input type="text" class="form-control bg-r text-center" name="start" id="start" value="'01-'.{{$fechaa}}"/>-->
                                <span class="input-group-addon">al</span>
                                <!--<input type="text" class="form-control bg-r text-center" name="end" id="end" value="{{$fecha}}" />-->
                                <input style="text-align: center;" type="text" name="end" id="end" class="form-control DatePicker" autocomplete="off" readonly="true" value="{{$fecha}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
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
                </div>
                <div class="table-responsive">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Caja</th>
                            <th>Usuario</th>
                            <th>Entregado a</th>
                            <th>Concepto</th>
                            <th class="text-center">Estado</th>
                            <th class="text-right">Monto</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ URL::to('rest/scripts/informes/finanzas/func-remuneraciones.js' ) }}"></script>

@endsection('content')