@extends('layouts.application.master')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox animated bounce">
                    <div class="ibox-title">
                        <div class="pull-right">
                            
                            <button type="button" id="btn-nueva-sucursal" {{$numero_sucursales>= session('plan_actual')->sucursal_max?'style=display:none':""}}  class="btn btn-primary btn-sucursal"><i class="fa fa-plus-circle"></i>Nueva Sucursal</button>
                            <h5 id="limite_sucursales_txt" class="pull-right" {{$numero_sucursales< session('plan_actual')->sucursal_max?"style=display:none":""}}  >Limite alcanzado - <a class="btn btn-success btn-xs upgrade-btn-2" href="/upgrade">Crecer</a></h5>
                        </div>
                        <h5><i class="fa fa-newspaper-o"></i> Sucursales - <span id="sucursales_count">{{$numero_sucursales}}</span>/{{(session('plan_actual')->sucursal_max)}}</h5>
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
                                    <h1 class="ich m-t-none brand-color">M&oacute;dulo  para Sucursales</h1>
                                <br>
                                <p class="ng-binding ">Aqu&iacute; puedes crear y modificar las Sucursales de tu negocio. Las Sucursales te ayudan a <strong class="brand-color">controlar todo los procesos</strong> de tu negocio. Las Sucursales son importantes cuando el negocio crece para <strong class="accent-color">control y automatizaci&oacute;n de tu cadena de establecimientos. </strong></p>
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
                <form id="frm-sucursal" class="unif_modal" method="post" enctype="multipart/form-data">
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
                                    <input type="text" name="telefono_sucursal" id="telefono_sucursal" class="form-control validanumericos" placeholder="Ingrese Telefono" autocomplete="off" required="required"/>
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
            limite_sucursal = {!! session('plan_actual')->sucursal_max!!}
        });
    </script>
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
@endsection('content')