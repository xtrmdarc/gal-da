@extends('layouts.application.master')
@section('content')


<div class="wrapper wrapper-content animated shake">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><i class="fa fa-user"></i> Datos del cliente</h5>
                <div class="ibox-tools">
                    <label>
                        <input name="tipo_doc" type="radio" value="1" id="td_dni" class="flat-red" checked="true"> DNI
                        &nbsp;
                        <input name="tipo_doc" type="radio" value="2" id="td_ruc" class="flat-red"> RUC
                    </label> 
                </div>
            </div>
            <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-6" id="f_dni" style="display: block;">
                <form method="post" id="frm-consulta-dni">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="dni_numero" id="dni_numero" class="form-control" placeholder="Buscar por DNI" autocomplete="off" />
                            <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="col-lg-6 col-lg-offset-6" id="f_ruc" style="display: none;">
                <form method="post" id="frm-consulta-ruc">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="ruc_numero" id="ruc_numero" class="form-control" placeholder="Buscar por RUC" autocomplete="off" />
                            <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <form id="form" action="/cliente_e/RUCliente" method="post" enctype="multipart/form-data">
                @csrf
            <input type="hidden" name="id_cliente" value="{{isset($cliente)?$cliente->id_cliente:''}}" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6" id="d_ruc" style="display: none;">
                                <div class="form-group">
                                    <label>RUC</label>
                                    <input type="text" name="ruc" id="ruc" data-mask="99999999999" value="{{isset($cliente)?$cliente->ruc:''}}" class="form-control" placeholder="Ingrese ruc" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>DNI</label>
                                    <input type="text" name="dni" id="dni" data-mask="99999999" value="{{isset($cliente)?$cliente->dni:''}}" class="form-control" placeholder="Ingrese dni" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-lg-6" id="d_nombres" style="display: block;">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" name="nombres" id="nombres" value="{{isset($cliente)?$cliente->nombres:''}}" class="form-control" placeholder="Ingrese nombres" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-lg-6" id="d_apep" style="display: block;">
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input type="text" name="ape_paterno" id="ape_paterno" value="{{isset($cliente)?$cliente->ape_paterno:''}}" class="form-control" placeholder="Ingrese apellido paterno" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6" id="d_apem" style="display: block;">
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input type="text" name="ape_materno" id="ape_materno" value="{{isset($cliente)?$cliente->ape_materno:''}}" class="form-control" placeholder="Ingrese apellido materno" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6" id="d_fecha" style="display: block;">
                                <div class="form-group">
                                    <label>Fecha de Nacimiento</label>
                                    <input type="text" name="fecha_nac" id="fecha_nac" data-mask="99-99-9999" value="{{isset($cliente)?$cliente->fecha_nac:''}}" class="form-control DatePicker" placeholder="Ingrese fecha de nacimiento" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6" id="d_telefono" style="display: block;">
                                <div class="form-group">
                                    <label>Tel&eacute;fono</label>
                                    <input type="text" name="telefono" id="telefono" data-mask="999999999" value="{{isset($cliente)?$cliente->telefono:''}}" class="form-control" placeholder="Ingrese tel&eacute;fono" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-12" id="d_correo" style="display: block;">
                                <div class="form-group">
                                    <label>Correo electr&oacute;nico</label>
                                    <input type="text" name="correo" id="correo" value="{{isset($cliente)?$cliente->correo:''}}" class="form-control" placeholder="Ingrese correo electr&oacute;nico" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="d_rs" style="display: none;">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Raz&oacute;n Social</label>
                            <input type="text" name="razon_social" id="razon_social" value="{{isset($cliente)?$cliente->razon_social:''}}" class="form-control" placeholder="Ingrese raz&oacute;n social" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Direcci&oacute;n</label>
                            <input type="text" name="direccion" id="direccion" value="{{isset($cliente)?$cliente->direccion:''}}" class="form-control" placeholder="Ingrese direcci&oacute;n" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                <div class="text-right">
                    <a href="/cliente" class="btn btn-white"> Cancelar</a>
                    <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="{{URL::to('rest/scripts/cliente/func_cliente_e.js')}}"></script>
<script src="{{URL::to('rest/js/plugins/wizard/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>
<script src="{{URL::to('rest/js/plugins/wizard/wizard.js')}}"></script>
<script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js')}}"></script>
<script type="text/javascript">
  $(function () {
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_square-blue'
    });
    $("#correo").emailautocomplete({
        domains: [
            "gmail.com",
            "yahoo.com",
            "hotmail.com",
            "live.com",
            "facebook.com",
            "outlook.com"
            ]
        });
    });
</script>
@endsection