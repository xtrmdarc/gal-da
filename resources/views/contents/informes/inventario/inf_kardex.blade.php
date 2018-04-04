@extends('Layouts.master')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y");
$fechaa = date("m-Y");
?>

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
            <h5><strong><i class="fa fa-list"></i> Informe de kardex</strong></h5>
        </div>
        <div class="ibox-content" style="position: relative; min-height: 30px;">
            <div class="row">
                <form method="post" enctype="multipart/form-data" target="_blank" action="#">
                    <!--
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control bg-r" name="start" id="start" value="<?php echo '01-'.$fechaa; ?>" readonly/>
                                        <span class="input-group-addon">hasta</span>
                                        <input type="text" class="form-control bg-r" name="end" id="end" value="<?php echo $fecha; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        &nbsp;
                    </div>
                    -->
                    <div class="col-sm-2">
                        <div class="form-group">
                            <select name="tipo_ip" id="tipo_ip" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                <option value="1">INSUMOS</option>
                                <option value="2">PRODUCTOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select name="id_ip" id="id_ip" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" data-size="8">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="table-responsive">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 15%">Fecha</th>
                                <th style="width: 25%">Almac&eacute;n</th>
                                <th style="width: 30%">Motivo</th>
                                <th>U.M.</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="punteo">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><strong>ENTRADAS</strong></h5>
                                <h1><strong id="stock_e"></strong></h1>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><strong>STOCK ACTUAL</strong></h5>
                                <h1 class="text-navy"><strong id="stock_a"></strong></h1>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><strong>SALIDAS</strong></h5>
                                <h1><strong id="stock_s"></strong></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::to('scripts/informes/inventario/func-kardex.js' ) }}"></script>

@endsection('content')