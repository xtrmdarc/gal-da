@extends('Layouts.master')

@section('content')

    <input type="hidden" id="m" value=""/>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2><i class="fa fa-cogs"></i> <a class="a-c" href="{{ url('/ajustes') }}">Ajustes</a></h2>
        <ol class="breadcrumb">
            <li class="active">
                <strong>Restaurante</strong>
            </li>
            <li>Salones y mesas</li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox animated bounce">
                <div class="ibox-title">
                    <div class="ibox-title-buttons pull-right">
                        <button type="button" class="btn btn-primary" onclick="editarSalon();"><i class="fa fa-plus-circle"></i> Nueva Sala</button>
                    </div>
                    <h5><i class="fa fa-cubes"></i> Salones</h5>
                </div>
                <div class="ibox-content">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table class="table table-condensed table-striped table-hover" id="table-s">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Mesas</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div id="lizq-s" style="display: block;">
                <div class="panel panel-transparent panel-dashed tip-sales text-center">
                    <div class="row">
                        <div class="col-sm-8 col-sm-push-2">
                            <h2 class="ich m-t-none">Selecciona un sal&oacute;n</h2>
                            <i class="fa fa-long-arrow-left fa-3x"></i>
                            <p class="ng-binding">Navega por la lista de Salones y selecciona uno.</p> <p><strong>Aquí podrás ver las mesas que contiene.</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lizq-i" style="display: none;">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mesa(s) de <span id="title-mesa"></span></h5>
                        <div class="ibox-title-buttons pull-right" id="btn-nuevo"></div>
                    </div>
                    <div class="ibox-content">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table class="table table-hover table-condensed table-striped" id="table-m">
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
            <form id="frm-mesa" method="post" enctype="multipart/form-data" action="/ajustesCrudMesas">
                @csrf
                <input type="hidden" name="cod_mesa" id="cod_mesa">
                <input type="hidden" name="id_catg" id="id_catg">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-edit modal-icon"></i>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ent">
                                <label class="control-label">Nro de Mesa</label>
                                <input type="text" name="nro_mesa" id="nro_mesa" class="form-control" placeholder="Ingrese Nro Mesa" autocomplete="off" required="required"/>
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
            <form id="frm-eliminar-mesa" method="post" enctype="multipart/form-data" action="ajustesEliminarM">
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
            <form id="frm-salon" method="post" enctype="multipart/form-data" action="/ajustesCrudSalones">
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
            <form id="frm-eliminar-salon" method="post" enctype="multipart/form-data" action="/ajustesEliminarS">
                @csrf
                <input type="hidden" name="cod_salae" id="cod_salae">
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
            <form id="frm-estado-mesa" method="post" enctype="multipart/form-data" action="?c=Config&a=EstadoM">
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

<script src="{{ URL::to('scripts/config/func_mesas.js' ) }}"></script>
<script type="text/javascript">
    $(function() {
        $('#config').addClass("active");
    });
</script>

@endsection('content')