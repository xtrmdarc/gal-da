@extends('layouts.application.master')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox animated bounce">
                    <div class="ibox-title">
                        <div class="ibox-title-buttons pull-right">
                            <button type="button" class="btn btn-primary btn-turno"><i class="fa fa-plus-circle"></i> Nuevo Turno</button>
                        </div>
                        <h5><i class="fa fa-newspaper-o"></i> Turnos</h5>
                    </div>
                    <div class="ibox-content my-scroll">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table class="table table-hover table-condensed table-striped" id="table-turnos">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>H. Inicio</th>
                                <th>H. Fin</th>
                                <th>Sucursal</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="wrapper wrapper-content">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-10 block-center">
                                <br>
                                <h1 class="ich m-t-none brand-color">Módulo de Turnos</h1>
                                <br>
                                <p class="ng-binding ">Aquí puedes crear, modificar y eliminar los turnos de tu negocio. Los turnos te ayudan a <strong class="brand-color">controlar el la efectividad y eficiencia</strong> de tus trabajadores y <strong class="brand-color"> de tu negocio </strong>en determinados periodos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

        <div class="modal inmodal fade" id="mdl-turno" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
            <div class="modal-dialog" style="max-width: 400px;">
                <div class="modal-content animated bounceInRight">
                    <form id="frm-turno" class="unif_modal" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input type="hidden" name="cod_turno" id="cod_turno">
                        <div class="modal-header mh-e">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                            <h4 class="modal-title mt"><strong id="title-turno"></strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" name="nomb_turno" id="nomb_turno" class="form-control" placeholder="Ingrese nombre" autocomplete="off" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Horario Inicial</label>
                                        <div class="input-group clockpicker">
                                            <input type="text" name="h_inicio_t" id="h_inicio_t" class="form-control"placeholder="Ingrese H. Inicio" autocomplete="off" required="required" value=""/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group clockpicker">
                                        <input type="text" name="h_fin_t" id="h_fin_t" class="form-control" placeholder="Ingrese H. Fin" autocomplete="off" required="required" value=""/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label">Sucursal</label>
                                        <div class="input-group">
                                            <select name="id_sucursal" id="id_sucursal" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required>
                                                @if(Auth::user()->id_usu != null)
                                                    <option value="">
                                                        Seleccionar
                                                    </option>
                                                @else
                                                    echo '<option value="" selected>Seleccionar</option>';
                                                    echo '<optgroup label="Seleccionar">';
                                                        @endif
                                                        <optgroup label="Seleccionar">
                                                            @foreach($user_sucursal as $r)
                                                                <option value="{{$r->id}}">{{$r->nombre_sucursal}}</option>
                                                            @endforeach
                                                        </optgroup>
                                            </select>
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

        <div class="modal inmodal fade" id="mdl-eliminar-turno" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content animated bounceInRight">
                    <form id="frm-eliminar-turno" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesEliminarCaja">
                        @csrf
                        <input type="hidden" name="cod_turno_e" id="cod_turno_e">
                        <div class="modal-header mh-p">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                            <i class="fa fa-trash-o modal-icon"></i>
                        </div>
                        <div class="modal-body">
                            <div id="mensaje-turno"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    

@endsection('content')
@section('scripts')
    <script src="{{URL::to('rest/scripts/config/func_turnos.js' )}}"></script>
    <script type="text/javascript">
        $(function() {
            $('#config').addClass("active");
        });
    </script>
@endsection