@extends('layouts.master')
@section('content')
@php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y h:i A");
@endphp

<input type="hidden" id="moneda" value="{{ session('moneda') }}"/>
<input type="hidden" id="fechaC" value=" {{$fecha}}"/>
<input type="hidden" id="m" value="<?php //$_GET['m']; ?>"/>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2><i class="fa fa-desktop"></i> <a class="a-c" href="?c=ACaja">Caja</a></h2>
        <ol class="breadcrumb">
            <li class="active">
                <strong>Caja</strong>
            </li>
            <li>Apertura - Cierre de Caja</li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated bounce">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl-nueva-apertura"><i class="fa fa-plus-circle"></i> Nueva Apertura</button>
            </div>
            <h5><strong><i class="fa fa-list-ul"></i> Lista de Aperturas - Cierres de Caja</strong></h5>
        </div>
        <div class="ibox-content">
            <div class="row" >
                <div class="col-sm-4 col-sm-offset-8" style="text-align:right;" id="filter_global">
                    <div class="input-group">
                        <input class="form-control global_filter" id="global_filter" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn btn-primary"> <i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-condensed table-striped" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>Cajero</th>      
                            <th>Caja</th>
                            <th>Turno</th>
                            <th>Fecha de Apertura</th>
                            <th>Hora de Apertura</th>
                            <th>Monto de Apertura</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-nueva-apertura" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-nueva-apertura" method="post" enctype="multipart/form-data" action="?c=ACaja&a=Guardar">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Apertura de Caja</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <select name="id_usu" id="id_usu" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar Cajero" autocomplete="off" required="required">
                            @foreach($cajeros as $r)
                                <option value="{{ $r->id_usu}}">{{$r->ape_paterno.' '.$r->ape_materno.' '.$r->nombres }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <select name="id_caja" id="id_caja" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar Caja" autocomplete="off" required="required">
                            @foreach($cajas as $r)
                                <option value="{{$r->id_caja}}">{{$r->descripcion}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <select name="id_turno" id="id_turno" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar Turno" autocomplete="off" required="required">
                            @foreach($turnos as $r)
                                <option value=" {{$r->id_turno}}">{{$r->descripcion}}</option>
                            
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                      <div class="input-group dec">
                        <span class="input-group-addon">{{session('moneda')}}</span>
                        <input type="text" name="monto" class="form-control" placeholder="Ingrese monto" autocomplete="off" required="required"/>
                      </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-cierre-caja" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content animated bounceInRight">
        <form id="frm-cierre-caja" method="post" enctype="multipart/form-data" action="?c=ACaja&a=Guardar">
        <input type="hidden" name="cod_apc" id="cod_apc">
        <input type="hidden" name="monto_sistema" id="monto_sistema">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Cierre de Caja</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="mensaje"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Fecha de Apertura:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" name="fecha_aper" id="fecha_aper" value="" class="form-control" placeholder="Fecha de apertura" autocomplete="off" required="required" readonly="true" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Fecha de Cierre:</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" name="fecha_cierre" id="fecha_cierre" class="form-control" placeholder="Fecha de cierre" autocomplete="off" required="required" value="{{$fecha}}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Monto Estimado:</label>
                            <div class="input-group dec">
                                <span class="input-group-addon">{{session('moneda')}}</span>
                                <input type="text" name="monto_sis" id="monto_sis" value="0.00" class="form-control" placeholder="Monto Sistema" autocomplete="off" required="required" readonly="true" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Monto Real:</label>
                            <div class="input-group dec">
                                <span class="input-group-addon">{{session('moneda')}}</span>
                                <input type="text" name="monto" id="monto_c" class="form-control" placeholder="Ingrese monto" autocomplete="off" required="required"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </form>
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

<script src="{{URL::to('scripts/caja/func_caja.js')}}"></script>
@endsection