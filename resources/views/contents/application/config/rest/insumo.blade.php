@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
<input type="hidden" id="m" value=""/>

<div class="wrapper wrapper-content ng-scope">
    <div class="ibox has-grid">
        <div class="ibox-content bg-gray-l1">
            <div class="row">
                <div class="col-md-3 ibox-col animated bounce">
                    <br>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <h2 class="ich"><i class="fa fa-tasks"></i> Categor�as</h2>
                                <a onclick="lista_tablei('%')" class="file-control active">Todos</a>
                                <div class="hr-line-dashed"></div>
                                <div id="boton-catg" style="display: block">
                                    <button class="btn btn-primary btn-block btn-catg"><i class="fa fa-plus-circle"></i> A&ntilde;adir nueva categor&iacute;a</button>
                                </div>
                                <form id="frm-categoria" method="post" enctype="multipart/form-data" action="/ajustesCrudCatgI">
                                    @csrf
                                    <input type="hidden" name="id_catg" id="id_catg">
                                    <div id="nueva-catg" style="display: none">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group display-flex">
                                                    <label class="control-label">Nombre</label>
                                                    <input class="form-control" type="text" autocomplete="off" placeholder="Nueva categor&iacute;a" name="nombre_catg" id="nombre_catg" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Sucursal</label>
                                                    <div class="input-group">
                                                        {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                        <select name="id_sucursal" id="id_sucursal" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                                            @if($id_usu != null)
                                                                <option value="">

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
                                            <div class="col-sm-6">
                                                <a class="btn btn-default btn-c-catg">Cancelar</a>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <button class="btn btn-primary" type="submit">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="hr-line-dashed"></div>
                                <ul class="folder-list" style="padding: 0">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div id="ul-categorias"></div>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 ibox-col b-l-gray-l1">
                    <div class="row bg-writhe-l1">
                        <div class=" col-sm-12">
                            <div class="ibox m-t">
                                <div class="ibox-content display-flexx">
                                    <div class="btn-flex btn-group m-r-sm">
                                        <a class="btn dim display-flexx display-flexx-v btn-default" href="/ajustesProductos">
                                            <img class="filtered" src="{{ URL::to('img/otros/icon-01.png' ) }}" width="80" height="40">
                                            <span>Platos/bebidas</span>
                                        </a>
                                        <!--<a class="btn dim btn-default m-n btn-prodnuevo"><i class="fa fa-lg fa-plus"></i></a>-->
                                    </div>
                                    <div class="btn-flex btn-group m-r-sm">
                                        <a class="btn dim display-flexx display-flexx-v btn-primary">
                                            <img class="filtered" src="{{ URL::to('img/otros/icon-02.png' ) }}" width="80" height="40">
                                            <span>Insumos</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 bg-writhe-l1 b-r-gray-l1">
                            <a id="btn-insumo" class="btn btn-primary btn-block btn-ins"><i class="fa fa-plus-circle"></i> Nuevo insumo </a>
                            <br>
                            <div class="row">
                                <div class="col-sm-12" style="text-align:right;" id="filter_global">
                                    <div class="input-group m-b">
                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                        <input class="form-control global_filter" id="global_filter" type="text" placeholder="Buscar insumo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <table class="table table-condensed table-hover" id="table-insumos" width="100%">
                                        <thead>
                                        <th>C&oacute;digo</th>
                                        <th>Nombre</th>
                                        <th>Categor&iacute;a</th>
                                        <th>Unidad</th>
                                        <th>�Activo?</th>
                                        <th style="text-align: right">Acciones</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-insumo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" style="max-width:400px;">
        <div class="modal-content animated bounceInRight">
            <form id="frm-insumo" method="post" enctype="multipart/form-data" action="/ajustesCrudIns">
                @csrf
                <input type="hidden" name="cod_ins" id="cod_ins">
                <div class="modal-header mh-e">
                    <h4 class="modal-title mt"><strong>Detalle del insumo</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group display-flex">
                                <input class="form-control input-lg" type="text" autocomplete="off" placeholder="Nombre del insumo" name="nombre_ins" id="nombre_ins" required="required" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">C&oacute;digo</label>
                                <input class="form-control" type="text" autocomplete="off" name="codigo_ins" id="codigo_ins"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label">Unidad de medida</label>
                                <select name="cod_med" id="cod_med" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" title="Seleccionar" data-size="5">
                                    @foreach($unidadM as $r)
                                        <option value="{{$r->id_med}}">{{$r->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Categor&iacute;a</label>
                                <div id="combo_catg">
                                    <select name="cod_catg" id="cod_catg" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" data-size="5">
                                        @foreach($comboCatg as $r)
                                            <option value="{{$r->id_catg}}">{{$r->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Stock m&iacute;nimo</label>
                                <input class="form-control" type="text" autocomplete="off" name="stock_min" id="stock_min" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select name="estado" id="estado" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                    <option value="a">ACTIVO</option>
                                    <option value="i">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-guardar"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/config/func_insumos.js' )}}"></script>
<script type="text/javascript">
    $(function() {
        $('#config').addClass("active");
        function filterGlobal () {
            $('#table-insumos').DataTable().search(
                    $('#global_filter').val()
            ).draw();
        }
        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        });
    });
</script>

@endsection('content')