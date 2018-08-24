@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
<input type="hidden" id="cod_ape" value="{{session('apertura')}}"/>
<input type="hidden" id="moneda" value="{{session('moneda')}}"/>
<input type="hidden" id="m" value=""/>

<div class="wrapper wrapper-content animated bounce">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl-nuevo-ing"><i class="fa fa-plus-circle"></i> Nuevo Ingreso</button>
            </div>
            <h5><strong><i class="fa fa-list-ul"></i> Lista de Ingresos</strong></h5>
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
                <table class="table table-hover table-condensed table-striped" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Importe</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($lista1 as $r)
                        <tr>
                            <td><i class="fa fa-calendar"></i>{{' '.date('d-m-Y',strtotime($r->fecha_reg))}}
                            </td>
                            <td><i class="fa fa-clock-o"></i>{{' '.date('h:i A',strtotime($r->fecha_reg))}}
                            </td>
                            <td>{{$r->motivo}}</td>
                            <td>{{session('moneda').' '.number_format($r->importe,2)}}</td>
                            <td style="text-align: center">
                                
                                    @if($r->estado == 'a')
                                        <span class="label label-primary">APROBADO</span>
                                    @elseif($r->estado == 'i')
                                        <span class="label label-danger">ANULADO</span>
                                    @endif
                                
                            </td>
                            <td style="text-align: center">
                                <button type="button" class="btn btn-danger btn-xs" onclick="anularIngreso({{$r->id_ing}});"><i class="fa fa-ban"></i> Anular</button>
                            </td>
                        </tr>     
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-nuevo-ing" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-nuevo-ing" method="post" enctype="multipart/form-data" action="ing/Guardar">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Ingreso Administrativo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Caja</label>
                            <select name="cb_caja" id="cb_caja" class="form-control selectpicker">
                                @foreach ($cajas as $caja)
                                <option value="{{$caja->id_apc}}" >{{$caja->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Importe</label>
                            <div class="input-group dec">
                                <span class="input-group-addon">{{session('moneda')}}</span>
                                <input type="text" name="importe" id="importe" class="form-control" placeholder="Ingrese Importe" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Motivo</label>
                            <textarea name="motivo" id="motivo" class="form-control" rows="5" placeholder="Ingrese motivo"></textarea>
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

<div class="modal inmodal fade" id="mdl-anular-ing" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-anular-ing" method="post" enctype="multipart/form-data" action="ing/Estado">
        @csrf
        <input type="hidden" name="cod_ing" id="cod_ing">
            <div class="modal-header mh-p">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <i class="fa fa-ban modal-icon"></i>
            </div>
            <div class="modal-body">
                <center><h4>¿Desea anular este Ingreso?</h4></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-validar-apertura" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-transparent text-center p-md"> <i class="fa fa-warning fa-3x text-warning"></i> <h2 class="m-t-none m-b-sm">Advertencia</h2> <p>Para poder realizar esta operaci&oacute;n es necesario Aperturar Caja.</p></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="text-left">
                            <a href="{{session('home')}}" class="btn btn-default">Volver</a>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <div class="text-right">
                            <a href="{{route('apercaja')}}" class="btn btn-primary">Aperturar Caja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/caja/func_ing.js')}}"></script>
@endsection