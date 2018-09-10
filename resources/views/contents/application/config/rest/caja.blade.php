@extends('layouts.application.master')

@section('content')

    <div class="col-lg-6">
        <div class="wrapper wrapper-content animated bounce">
            <div class="row">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="ibox-title-buttons pull-right">
                            @if(Auth::user()->plan_id != '1')
                                <button type="button" class="btn btn-primary btn-caja"><i class="fa fa-plus-circle"></i> Nueva Caja</button>
                            @else
                                <p>
                                    Solo contamos con una caja  en el plan free.
                                </p>
                            @endif
                        </div>
                        <h5><i class="fa fa-newspaper-o"></i> Cajas</h5>
                    </div>
                    <div class="ibox-content">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table class="table table-hover table-condensed table-striped" id="table-caja">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Sucursal</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="wrapper wrapper-content">
            <div class="panel panel-transparent panel-dashed tip-sales text-center">
                <div class="row">
                    <div class="col-sm-8 col-sm-push-2">
                        <h2 class="ich m-t-none">Selecciona una caja</h2>
                        <i class="fa fa-long-arrow-left fa-3x"></i>
                        <p class="ng-binding">Navega por la lista de cajas y realize cambios..</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-caja" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog" style="max-width: 400px;">
            <div class="modal-content animated bounceInRight">
                <form id="frm-caja" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <input type="hidden" name="cod_caja" id="cod_caja">
                    <div class="modal-header mh-e">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <h4 class="modal-title mt"><strong id="title-caja"></strong></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" name="nomb_caja" id="nomb_caja" class="form-control" placeholder="Ingrese nombre" autocomplete="off" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Sucursal</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-renren"></i></span>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Estado</label>
                                    <select name="estado_caja" id="estado_caja" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                        <option value="a">ACTIVO</option>
                                        <option value="i">INACTIVO</option>
                                    </select>
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

    <div class="modal inmodal fade" id="mdl-eliminar-caja" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-eliminar-caja" method="post" enctype="multipart/form-data" action="/ajustesEliminarCaja">
                    @csrf
                    <input type="hidden" name="cod_caja_e" id="cod_caja_e">
                    <div class="modal-header mh-p">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <i class="fa fa-trash-o modal-icon"></i>
                    </div>
                    <div class="modal-body">
                        <div id="mensaje-caja"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{URL::to('rest/scripts/config/func_cajas.js' )}}"></script>
    <script type="text/javascript">
        $(function() {
            $('#config').addClass("active");
        });
    </script>

@endsection('content')