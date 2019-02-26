@extends('layouts.application.master')

@section('content')

    <input type="hidden" id="m" value=""/>


<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox animated bounce">
                <div class="ibox-title">
                    <div class="ibox-title-buttons pull-right">
                        <button type="button" class="btn btn-primary" onclick="editarSalon();"><i class="fa fa-plus-circle"></i> Nueva Sala</button>
                    </div>
                    <h5><i class="fa fa-cubes"></i> Salones</h5>
                </div>
                <div class="ibox-content my-scroll">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table class="table table-condensed table-striped table-hover" id="table-s" style="width:100%">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Mesas</th>
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
            <div id="lizq-s" style="display: block;" class="wrapper wrapper-content">
                <div class="text-center">
                    <div class="row">
                        <div class="col-sm-10 block-center">
                            <br>
                                <h1 class="ich m-t-none brand-color">M&oacute;dulo de Salones y Mesas</h1>
                            <br>
                            <p class="ng-binding ">Aqu&iacute; puedes crear, modificar y eliminar los salones y sus respectivas mesas. Los salones te ayudan a <strong class="brand-color"> agrupar y organizar las mesas </strong> en secciones que puedes controlar. La mesas te ayudan a <strong class="brand-color"> organizar, controlar y automatizar tus operaciones </strong> de venta dentro del local.<strong class="accent-color"> Selecciona un salón para adminsitrar sus mesas</strong> </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="lizq-i" style="display: none;">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mesa(s) de <span id="title-mesa"></span> - <span id="mesas_count">{{$mesas_actual}}</span>/{{(session('plan_actual')->mesa_max)}}</h5>
                        <div class="ibox-title-buttons pull-right" {{$mesas_actual>= session('plan_actual')->mesa_max?'style=display:none':""}} id="btn-nuevo"></div>
                        <h5 id="limite_mesas_txt" class="pull-right" {{$mesas_actual< session('plan_actual')->mesa_max?"style=display:none":""}}  >Limite alcanzado - <a class="btn btn-success btn-xs upgrade-btn-2" href="/upgrade">Crecer</a></h5>
                    </div>
                    <div class="ibox-content my-scroll">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table class="table table-hover table-condensed table-striped" id="table-m" style="width:100%">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Sala</th>
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
</div>

<div class="modal inmodal fade" id="mdl-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <form id="frm-mesa" method="post" class="unif_modal" enctype="multipart/form-data" action="/ajustesCrudMesas">
                @csrf
                <input type="hidden" name="cod_mesa" id="cod_mesa">
                <input type="hidden" name="id_catg" id="id_catg">
                <input type="hidden" name="id_sucursal_m" id="id_sucursal_m">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-edit modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ent">
                                <label class="control-label">Nro de Mesa</label>
                                <input type="text" name="nro_mesa" id="nro_mesa" class="form-control" placeholder="Ingrese Nro Mesa" maxlength="5" autocomplete="off" required="required"/>
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

<div class="modal inmodal fade" id="mdl-eliminar-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <form id="frm-eliminar-mesa" class="unif_modal" method="post" enctype="multipart/form-data" action="ajustesEliminarM">
                @csrf
                <input type="hidden" name="cod_mesae" id="cod_mesae">
                <div class="modal-header mh-p">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-trash-o modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div id="mensaje-em"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-salon" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <form id="frm-salon" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesCrudSalones">
                @csrf
                <input type="hidden" name="cod_sala" id="cod_sala">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-edit modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Nombre de Sala</label>
                                <input type="text" name="descripcion" id="desc_sala" class="form-control" placeholder="Ingrese descripci&oacute;n" autocomplete="off" required="required"/>
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
                                            <option value="">Seleccionar</option>
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
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select name="est_salon" id="est_salon" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off" required="required">
                                    <option value="a" selected="true">ACTIVO</option>
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

<div class="modal inmodal fade" id="mdl-eliminar-salon" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <form id="frm-eliminar-salon" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesEliminarS">
                @csrf
                <input type="hidden" name="cod_salae" id="cod_salae">
                <input type="hidden" name="id_sucursal_s" id="id_sucursal_s">
                <div class="modal-header mh-p">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-trash-o modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div id="mensaje-es"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-estado-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <form id="frm-estado-mesa" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesEstadoM">
                @csrf
                <input type="hidden" name="codi_mesa" id="codi_mesa">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-stack-exchange modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select name="est_mesa" id="est_mesa" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off" required="required">
                                    <option value="a">ACTIVA</option>
                                    <option value="m">INACTIVA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ URL::to('rest/scripts/config/func_mesas.js' ) }}"></script>
<script type="text/javascript">
    $(function() {
        $('#config').addClass("active");
        limite_mesas = {!!session('plan_actual')->mesa_max !!}
    });
</script>

@endsection('content')