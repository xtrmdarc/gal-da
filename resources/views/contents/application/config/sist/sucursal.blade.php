@php
    $numero_sucursales = DB::table('empresa')
    ->leftjoin('sucursal', 'empresa.id', '=', 'sucursal.id_empresa')
    ->where('empresa.id',session('id_empresa'))->count();
@endphp
@extends('layouts.application.master')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox animated bounce">
                    <div class="ibox-title">
                        <div class="pull-right">
                            @if(Auth::user()->plan_id != '1')
                                @if(Auth::user()->plan_id == '2' && $numero_sucursales < 2)
                                    <button type="button" class="btn btn-primary btn-sucursal"><i class="fa fa-plus-circle"></i> Nueva Sucursal</button>
                                @else
                                    @if(Auth::user()->plan_id == '2')
                                        <p>
                                            Solo contamos con <b>2</b> <b>Sucursales</b> en el <b>Plan Basic</b>.
                                        </p>
                                    @endif
                                @endif
                                @if(Auth::user()->plan_id == '3')
                                    <button type="button" class="btn btn-primary btn-sucursal"><i class="fa fa-plus-circle"></i> Nueva Sucursal</button>
                                @endif
                            @else
                                @if(Auth::user()->plan_id == '1')
                                    <p>
                                        Solo contamos con <b>1</b> <b>Sucursal</b> en el <b>Plan Free</b>.
                                    </p>
                                @endif
                            @endif
                        </div>
                        <h5><i class="fa fa-newspaper-o"></i> Sucursales</h5>
                    </div>
                    <div class="ibox-content my-scroll">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table class="table table-hover table-condensed table-striped" id="table-sucursales">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Moneda</th>
                                <th>Estado</th>
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
                                @if(Auth::user()->plan_id == '1')
                                    <h1 class="ich m-t-none brand-color">M&oacute;dulo  para <b>1 </b> Sucursal</h1>
                                @endif
                                @if(Auth::user()->plan_id == '2')
                                    <h1 class="ich m-t-none brand-color">M&oacute;dulo  para <b>2 </b> Sucursales</h1>
                                @endif
                                @if(Auth::user()->plan_id == '3')
                                    <h1 class="ich m-t-none brand-color">M&oacute;dulo de Sucursales</h1>
                                @endif
                                <br>
                                <p class="ng-binding ">Aqu&iacute; puedes crear y modificar las Sucursales de tu negocio. Las Sucursales te ayudan a <strong class="brand-color">controlar todo los procesos</strong> de tu negocio. Las Sucursales son importante cuando el negocio crece con el tiempo para <strong class="accent-color">control y automatizaci&oacute;n de tu cadena de negocio <strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal inmodal fade" id="mdl-sucursal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
            <div class="modal-dialog" style="max-width: 400px;">
                <div class="modal-content animated bounceInRight">
                    <form id="frm-sucursal" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input type="hidden" name="cod_sucursal" id="cod_sucursal">
                        <div class="modal-header mh-e">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                            <h4 class="modal-title mt"><strong id="title-sucursal"></strong></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" name="nomb_sucursal" id="nomb_sucursal" class="form-control" placeholder="Ingrese nombre" autocomplete="off" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Direccion</label>
                                        <input type="text" name="direccion_sucursal" id="direccion_sucursal" class="form-control" placeholder="Ingrese Direccion" autocomplete="off" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Telefono</label>
                                        <input type="text" name="telefono_sucursal" id="telefono_sucursal" class="form-control" placeholder="Ingrese Telefono" autocomplete="off" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Moneda</label>
                                        <input type="text" name="moneda_sucursal" id="moneda_sucursal" class="form-control" placeholder="Ingrese moneda" autocomplete="off" required="required"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Estado</label>
                                        <select name="estado_sucursal" id="estado_sucursal" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
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
    
    <script src="{{URL::to('rest/scripts/config/func_sucursales.js' )}}"></script>
    <script type="text/javascript">
        $(function() {
            $('#config').addClass("active");
        });
    </script>

@endsection('content')