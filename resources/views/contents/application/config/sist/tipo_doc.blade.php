@extends('layouts.application.master')

@section('content')

<input type="hidden" id="m" value=""/>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox animated bounce">
                <div class="ibox-title">
                    <h5><i class="fa fa-file-text"></i> Documentos</h5>
                </div>
                <div class="ibox-content my-scroll">
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

        <div class="col-lg-6">
            <div class="wrapper wrapper-content">
                <div class="text-center">
                    <div class="row">
                        <div class="col-sm-10 block-center">
                            <br>
                            <h1 class="ich m-t-none brand-color">Módulo de Documentos</h1>
                            <br>
                            <p class="ng-binding ">Aquí puedes crear, modificar y eliminar los tipos de documentos de tu negocio. Los tipos de documento te ayudan a <strong class="brand-color">organizar tus operaciones de venta</strong> y  <strong class="accent-color"> automatizar cálculos importantes</strong> para la continuidad de tu empresa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal inmodal fade" id="mdl-tipodoc" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-tipodoc" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesGuardarTipoDocumento">
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
                                        <input type="text" name="serie" id="serie" class="form-control validanumericos" placeholder="Serie" autocomplete="off"/>
                                        <span class="input-group-addon">-</span>
                                        <input type="text" name="numero" id="numero" class="form-control validanumericos" placeholder="Número" autocomplete="off"/>
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