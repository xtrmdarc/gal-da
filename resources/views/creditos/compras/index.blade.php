@extends('Layouts.master')


@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2><i class="fa fa-credit-card"></i> <a href="?c=Credito" class="a-c">Cr&eacute;ditos</a></h2>
            <ol class="breadcrumb">
                <li class="active">
                    <strong>Compras</strong>
                </li>
                <li>
                    Lista
                </li>
            </ol>
        </div>
    </div>

    <input type="hidden" id="moneda" value=""/>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="ibox">
            <div class="ibox-title">
                <div class="ibox-title-buttons pull-right">
                </div>
                <h5><i class="fa fa-credit-card"></i> Lista de Compras al Cr&eacute;dito</h5>
            </div>
            <div class="ibox-content" style="position: relative; min-height: 30px;">
                <div class="row">
                    <form method="post" enctype="multipart/form-data" target="_blank" action="#">
                        <div class="col-sm-6 col-sm-offset-6">
                            <div class="form-group">
                                <select name="cod_prov" id="cod_prov" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                                    <option value="%" active>Todos los proveedores</option>

                                    <option value=""></option>

                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="punteo">
                    <div class="row">
                        <div class="col-lg-3">
                            <h5 class="no-margins"><strong>Deuda</strong></h5>
                            <h1 class="no-margins"><strong id="t_deuda"></strong></h1>
                        </div>
                        <div class="col-lg-3">
                            <h5 class="no-margins"><strong>Inter&eacute;s</strong></h5>
                            <h1 class="no-margins"><strong id="t_inte"></strong></h1>
                        </div>
                        <div class="col-lg-3">
                            <h5 class="no-margins"><strong>Amortizado</strong></h5>
                            <h1 class="no-margins"><strong id="t_amor"></strong></h1>
                        </div>
                        <div class="col-lg-3">
                            <h5 class="no-margins"><strong>Total</strong></h5>
                            <h1 class="no-margins"><strong id="t_total"></strong></h1>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>Fecha pago</th>
                            <th style="width: 30%">Proveedor</th>
                            <th>Documento</th>
                            <th>Serie - Nro.</th>
                            <th>Monto deuda</th>
                            <th>Inter&eacute;s</th>
                            <th>Amortizado</th>
                            <th>Pendiente</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-compra-credito" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-compra-credito" method="post" enctype="multipart/form-data" action="?c=Credito&a=PagarCuota">
                    <input type="hidden" name="cod_cuota" id="cod_cuota">
                    <input type="hidden" name="total_cuota" id="total_cuota">
                    <input type="hidden" name="amort_cuota" id="amort_cuota">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <strong>Fecha: </strong>
                                <span id="fecha_comp"></span>
                            </div>
                            <div class="col-sm-12">
                                <strong>Proveedor: </strong>
                                <span id="datos_prov"></span>
                            </div>
                            <div class="col-sm-12">
                                <strong>Monto pendiente: </strong><span id="monto_pend"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Monto</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" name="pago_cuo" id="pago_cuo" class="form-control" placeholder="Ingrese el monto" required="required" autocomplete="off">
                                        <span class="input-group-addon"><span class="fa fa-money"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">Egreso de caja</label><br>
                                <label style="font-weight: 500"><input name="egre_caja" id="egre_caja" type="checkbox" class="flat-red egre_caja"> Registrar como egreso</label>
                            </div>
                            <div id="cont-egre">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" ><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-detalle" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>Cajero</th>
                            <th>Fecha/Hora</th>
                            <th class="text-right">Importe</th>
                        </tr>
                        </thead>
                        <tbody id="lista_cuotas"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::to('assets/scripts/creditos/compras/func-compras.js' ) }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#creditos').addClass("active");
            $('#cr-compras').addClass("active");
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-red',
                radioClass: 'iradio_flat-red'
            });
        });
    </script>

@endsection('content')