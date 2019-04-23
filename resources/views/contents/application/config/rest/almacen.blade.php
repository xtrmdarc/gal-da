@extends('layouts.application.master')

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox animated bounce">
                <div class="ibox-title">
                    
                    <h5><i class="fa fa-cubes"></i> Almacenes {{\Auth::user()->plan_id == 1?'1/1'  :''}}</h5>
                    <div class="pull-right">
                        @if(Auth::user()->plan_id != '1')

                            <button type="button" class="btn btn-primary btn-alm"><i class="fa fa-plus-circle"></i> Nuevo Almac&eacute;n</button>
                            @else
                            <h5>
                                Limite alcanzado - <a style="background-image: url('https://s3.amazonaws.com/galda-test-picture-empresas/btn-upgrade.png" class="btn btn-success btn-xs" href="/upgrade">Crecer</a>
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="ibox-content my-scroll">
                    <table class="table table-condensed table-striped table-hover" id="table-alm">
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
        <div class="col-lg-6">
            <div class="ibox animated bounce">
                <div class="ibox-title">
                    <h5><i class="fa fa-list-alt"></i> &Aacute;reas de Producci&oacute;n {{\Auth::user()->plan_id == 1?'1/1'  :''}}</h5>
                    <div class="pull-right">
                        @if(Auth::user()->plan_id != '1')
                            <button type="button" class="btn btn-primary btn-area"><i class="fa fa-plus-circle"></i> Nueva &Aacute;rea</button>
                        @else
                            <h5>
                                Limite alcanzado - <a class="btn btn-success btn-xs upgrade-btn-2" href="/upgrade">Crecer</a>
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="ibox-content my-scroll">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table class="table table-condensed table-striped table-hover" id="table-area">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Almac&eacute;n</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="lizq-s" style="display: block;" class="wrapper wrapper-content">
                <div class="text-center">
                    <div class="row">
                        <div class="col-sm-10 block-center">
                            <br>
                                <h1 class="ich m-t-none brand-color">M&oacute;dulo para Almacenes y &Aacute;reas de producci&oacute;n  </h1>
                            <br>
                            <p class="ng-binding ">Aqu&iacute; puedes crear, modificar y eliminar Almacenes y &Aacute;reas de Producción. Los almacenes te ayudarán a <strong class="brand-color"> administrar la rotación de productos </strong> de tu negocio. Las Áreas de Producción separan por categoría las operaciones productivas. <strong class="accent-color">La cocina, el bar, la dulcería son ejemplos de áreas de producción. </strong></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-almacen" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content animated bounceInRight">
            <form id="frm-almacen" class="unif_modal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <input type="hidden" name="cod_alm" id="cod_alm">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title mt"><strong id="title-alm"></strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <input type="text" name="nomb_alm" id="nomb_alm" class="form-control" placeholder="Ingrese nombre" autocomplete="off" required="required"/>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->plan_id != '1')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Sucursal</label>
                                    <div class="input-group">
                                        @foreach($user_sucursal as $r)
                                            <input type="text" id="id_sucursal" class="form-control" value="{{$r->nombre_sucursal}}" readonly />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input type="hidden" name="id_sucursal" id="id_sucursal" class="form-control" placeholder="Ingrese nombre" autocomplete="off" value ="{{$user_sucursal_plan->id}}" required="required" disabled/>
                                    <input type="text" name="" id="" class="form-control" placeholder="Ingrese nombre" autocomplete="off" value ="{{$user_sucursal_plan->nombre_sucursal}}" required="required" disabled/>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select name="estado_alm" id="estado_alm" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
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

<div class="modal inmodal fade" id="mdl-areaprod" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content animated bounceInRight">
            <form id="frm-areaprod" class="unif_modal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <input type="hidden" name="cod_area" id="cod_area">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title mt"><strong id="title-area"></strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <input type="text" name="nomb_area" id="nomb_area" class="form-control" placeholder="Ingrese nombre" autocomplete="off" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Almac&eacute;n</label>
                                <div class="input-group">
                                    <select name="id_almacen_g" id="id_almacen_g" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required>
                                        @if(Auth::user()->id_sucursal != null)
                                            <option value="">Seleccionar</option>
                                        @else
                                            echo '<option value="" selected>Seleccionar</option>';
                                            echo '<optgroup label="Seleccionar">';
                                                @endif
                                                <optgroup label="Seleccionar">
                                                    @foreach($lista_almacenes as $r)
                                                        <option value="{{$r->id_alm}}">{{$r->nombre}}</option>
                                                    @endforeach
                                                </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--/*
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Almac&eacute;n</label>
                                    <div id="combo_alm"></div>
                                </div>
                            </div>
                        </div>
                    */--}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select name="estado_area" id="estado_area" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                    <option value="a">ACTIVO</option>
                                    <option value="i">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-guardar"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ URL::to('rest/scripts/config/func_almacenes.js' ) }}"></script>
<script type="text/javascript">
    $(function() {
        $('#config').addClass("active");
    });
</script>

@endsection('content')