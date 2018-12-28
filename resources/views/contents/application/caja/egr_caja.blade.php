@extends('layouts.application.master')
@section('content')

<input type="hidden" id="cod_ape" value="{{session('apertura')}}"/>
<input type="hidden" id="moneda" value="{{session('moneda')}}"/>
<input type="hidden" id="m" value="<?php //echo $_GET['m']; ?>"/>

<div class="wrapper wrapper-content animated bounce">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl-nuevo-gasto"><i class="fa fa-plus-circle"></i> Nuevo Egreso</button>
            </div>
            <h5><strong><i class="fa fa-list-ul"></i> Lista de Egresos</strong></h5>
        </div>
        <div class="ibox-content">
            <div class="row" >
                <div class="col-sm-4 col-sm-offset-8" style="text-align:right;" id="filter_global">
                    <div class="input-group">
                        <input class="form-control global_filter" id="global_filter" type="text">
                        <button class="btn btn btn-primary"> <i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed table-striped" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th>Motivo</th>
                            <th>Importe</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!--
                    class="tdi"
                    class="dtdml"
                    class="dtdm"
                    class="dtdf"
                    -->
                    @foreach($lista1 as $r)
                      <tr>
                        <td><i class="fa fa-calendar"></i>{{' '.date('d-m-Y',strtotime($r->fecha_re))}}
                        </td>
                        <td><i class="fa fa-clock-o"></i>{{' '.date('h:i A',strtotime($r->fecha_re))}}
                        </td>
                        <td>{{$r->des_tg}}</td>
                        <td>{{$r->desc_per.' - '.$r->motivo}}</td>
                        <td>{{session('moneda').' '.number_format($r->importe,2)}}</td>
                        <td style="text-align: center">
                            @if($r->estado == 'a')
                                    <span class="label label-primary">APROBADO</span>  
                            @elseif($r->estado == 'i')
                                    <span class="label label-danger">ANULADO</span> 
                            @endif
                            
                        </td>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-danger btn-xs" onclick="anularGasto({{$r->id_ga}});"><i class="fa fa-ban"></i> Anular</button>
                        </td>
                      </tr>     
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-nuevo-gasto" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
        <form id="frm-nuevo-gasto" class="unif_modal" method="post" enctype="multipart/form-data" action="egr/Guardar">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Egreso Administrativo</h4>
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
                        <div style="text-align: left;">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label><input name="rating" type="radio" value="1" id="rating_0" class="flat-red" checked="true"> Compras</label>
                                </div>
                                <div class="col-sm-4">
                                    <label><input name="rating" type="radio" value="2" id="rating_1" class="flat-red"> Servicios</label>
                                </div>
                                <div class="col-sm-4">
                                    <label><input name="rating" type="radio" value="3" id="rating_2" class="flat-red"> Remuneraci&oacute;n</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Tipo de documento</label>
                            <select name="id_tipo_doc" id="id_tipo_doc" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Tipo de Documento" autocomplete="off" required="required" >
                            @foreach($tdocumentos as $r)
                                <option value="{{$r->id_tipo_doc}}"> {{$r->descripcion}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Importe</label>
                            <div class="input-group dec">
                                <span class="input-group-addon">{{session('moneda')}}</span>
                                <input type="text" name="importe" id="importe" class="form-control" placeholder="Ingrese Importe" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="opc" style="display: block;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Serie/Nro.</label>
                            <div class="input-group display-flex">
                                <input type="text" name="serie_doc" id="serie_doc" class="form-control text-right validanumericos" placeholder="Serie" autocomplete="off" />
                                <span class="input-group-addon">-</span>
                                <input type="text" name="num_doc" id="num_doc" class="form-control validanumericos" placeholder="N&uacute;mero" autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Fecha del Comprobante</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" name="fecha_comp" id="fecha_comp" class="form-control DatePicker" placeholder="Fecha Comprobante" autocomplete="off" readonly="true"/>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div id="opc-per" style="display: none;">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label">Personal administrativo</label>
                        <div class="form-group">
                            <select name="id_per" id="id_per" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar Personal" autocomplete="off">
                            <optgroup label="Seleccionar Personal">
                                @foreach($personal as $r)
                                    <option value="{{$r->id_usu}}">{{ $r->ape_paterno.' '.$r->ape_materno.' '.$r->nombres}}</option>
                                @endforeach
                            </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Motivo</label>
                            <textarea name="motivo" id="motivo" class="form-control" placeholder="Ingrese motivo"></textarea>
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

<div class="modal inmodal fade" id="mdl-anular-gasto" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-anular-gasto" class="unif_modal" method="post" enctype="multipart/form-data" action="/caja/egr/Estado">
        @csrf
        <input type="hidden"  name="cod_ga" id="cod_ga">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <i class="fa fa-ban modal-icon"></i>
            </div>
            <div class="modal-body">
                <center><h3>¿Desea anular este Egreso?</h3></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-validar-apertura" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <a href="{{session('home')}}" class="btn btn-default">Volver</a>
                <a href="{{route('apercaja')}}" class="btn btn-primary" style="margin-right:8px">Aperturar Caja</a>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::to('rest/scripts/caja/func_egr.js')}}"></script>
<script type="text/javascript">
    $(function(){

        $('.validanumericos').keypress(function(e) {
            if(isNaN(this.value + String.fromCharCode(e.charCode)))
                return false;
        })
                .on("cut copy paste",function(e){
                    e.preventDefault();
                });

    });
</script>
@endsection