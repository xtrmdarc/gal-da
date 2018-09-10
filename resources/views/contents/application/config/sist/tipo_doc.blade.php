@extends('layouts.application.master')

@section('content')

<input type="hidden" id="m" value=""/>


<div class="col-lg-6">
    <div class="wrapper wrapper-content animated bounce">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-text"></i> Documentos</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">&nbsp;</div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <table class="table table-hover table-condensed table-striped" id="table">
                        <thead class="thd">
                        <tr>
                            <th>Orden</th>
                            <th>Descripci&oacute;n</th>
                            <th>Serie</th>
                            <th>N&uacute;mero</th>
                            <th>Acci&oacute;n</th>
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
        <div class="row">
            <div class="panel panel-transparent panel-dashed tip-sales text-center">
                <div class="row">
                    <div class="col-sm-8 col-sm-push-2">
                        <h2 class="ich m-t-none">Selecciona un tipo de documento</h2>
                        <i class="fa fa-long-arrow-left fa-3x"></i>
                        <p class="ng-binding">Navega por la lista de documentos y realize cambios..</p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-tipodoc" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-tipodoc" method="post" enctype="multipart/form-data" action="/ajustesGuardarTipoDocumento">
                    @csrf
                    <input type="hidden" name="cod_td" id="cod_td">
                    <div class="modal-header mh-e">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <i class="fa fa-edit modal-icon"></i>
                    </div>
                    <div class="modal-body">
                        <div id="mensaje"></div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group ent">
                                        <input type="text" name="serie" id="serie" class="form-control" placeholder="Serie" autocomplete="off"/>
                                        <span class="input-group-addon">-</span>
                                        <input type="text" name="numero" id="numero" class="form-control" placeholder="N�mero" autocomplete="off"/>
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

    <script src="{{URL::to('rest/scripts/config/func_td.js' )}}"></script>
    <script type="text/javascript">
        $('#config').addClass("active");
    </script>

@endsection('content')