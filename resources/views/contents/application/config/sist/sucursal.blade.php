@extends('layouts.application.master')

@section('content')
    
        <div class="col-lg-6">
            <div class="wrapper wrapper-content animated bounce">
                <div class="row">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-title-buttons pull-right">
                                <button type="button" class="btn btn-primary btn-sucursal"><i class="fa fa-plus-circle"></i> Nueva Sucursal</button>
                            </div>
                            <h5><i class="fa fa-newspaper-o"></i> Sucursales</h5>
                        </div>
                        <div class="ibox-content">
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
            </div>
        </div>

        <div class="col-lg-6">
            <div class="wrapper wrapper-content">
                <div class="panel panel-transparent panel-dashed tip-sales text-center">
                    <div class="row">
                        <div class="col-sm-8 col-sm-push-2">
                            <h2 class="ich m-t-none">Selecciona una Sucursal</h2>
                            <i class="fa fa-long-arrow-left fa-3x"></i>
                            <p class="ng-binding">Navega por la lista de sucursales  y realize cambios..</p>
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