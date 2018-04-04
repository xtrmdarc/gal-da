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
                <a class="btn btn-warning" ui-sref="informes.ventas" href="/informes"> <i class="fa fa-arrow-left"></i> Atr&aacute;s </a>
            </div>
            <h5><strong><i class="fa fa-list"></i> Aperturas y cierres de caja</strong></h5>
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
                </form>
            </div>
            <div class="table-responsive">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>Caja</th>
                        <th style="width: 15%;">Usuario</th>
                        <th>Fecha apertura</th>
                        <th>Fecha cierre</th>
                        <th>Monto estimado</th>
                        <th>Monto real</th>
                        <th>Diferencia</th>
                        <th>Acciones</th>
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
                <i class="fa fa-newspaper-o modal-icon"></i>
                <h5 class="modal-title" style="font-size: 14px">Detalle de Caja</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="widget lazur-bg p-xl">
                            <h4>
                                <span id="d_cajero"></span>
                            </h4>
                            <ul class="list-unstyled m-t-md">
                                <li>
                                    <span class="fa fa-newspaper-o m-r-xs"></span>
                                    <label>Caja:</label>
                                    <span id="d_caja"></span>
                                </li>
                                <li>
                                    <span class="fa fa-clock-o m-r-xs"></span>
                                    <label>Turno:</label>
                                    <span id="d_turno"></span>
                                </li>
                                <li>
                                    <span class="fa fa-calendar m-r-xs"></span>
                                    <label>Fecha de Apertura:</label><br>
                                    <span id="d_fecha_a"></span>
                                </li>
                                <li>
                                    <span class="fa fa-calendar m-r-xs"></span>
                                    <label>Fecha de Cierre:</label><br>
                                    <span id="d_fecha_c"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div>
                            <span>Apertura Caja</span>
                            <small id="apc" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar progress-bar-info"></div>
                        </div>
                        <div>
                            <span>Ingresos</span>
                            <small id="t_ing" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar"></div>
                        </div>
                        <div>
                            <span>Egresos</span>
                            <small id="t_egr" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar progress-bar-danger"></div>
                        </div>
                        <div>
                            <span>Monto Estimado</span>
                            <small id="t_est" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar progress-bar-info"></div>
                        </div>
                        <div>
                            <span>Monto Real</span>
                            <small id="t_real" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar progress-bar-success"></div>
                        </div>
                        <div>
                            <span>Diferencia</span>
                            <small id="t_dif" class="pull-right"></small>
                        </div>
                        <div class="progress progress-small">
                            <div style="width: 100%;" class="progress-bar progress-bar-warning"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::to('scripts/informes/finanzas/func-cajas.js' )}}"></script>

@endsection('content')