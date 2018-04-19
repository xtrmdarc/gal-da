@extends('layouts.application.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y h:i A");
$fechaa = date("m-Y h:i: A");
?>
<div class="page-wrapper">
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
                <a class="btn btn-warning" ui-sref="informes.ventas" href="/informes"> <i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
            </div>
            <h5><strong><i class="fa fa-list"></i> Ventas por producto</strong></h5>
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
                    <div class="col-sm-2">
                        &nbsp;
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input class="form-control global_filter" id="global_filter" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn btn-primary"> <i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 35%">Producto</th>
                        <th>Categor&iacute;a</th>
                        <th>Cantidad vendida</th>
                        <th class="text-right">P.V.</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tfoot>
            ������������<tr>
            ����������������<th colspan="4"></th>
            ����������������<th style="width: 25%;text-align:right;"></th>
            ������������</tr>
            ��������</tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/informes/ventas/func-prod.js' )}}"></script>
<script src="{{URL::to('rest/js/plugins/tinycon/tinycon.min.js' )}}"></script>

@endsection('content')