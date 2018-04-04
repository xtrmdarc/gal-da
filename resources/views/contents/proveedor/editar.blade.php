@extends('layouts.master')

@section('content')

<div class="row wrapper border-bott om white-bg page-heading">
    <div class="col-lg-9">
        <h2><i class="fa fa-truck"></i> <a href="?c=Proveedor" class="a-c">Proveedores</a></h2>
        <ol class="breadcrumb">
            <li class="active">
                <strong>Proveedores</strong>
            </li>
            <li>
                Edici&oacute;n
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated shake">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><i class="fa fa-truck"></i> Datos del proveedor</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-6">
                    <form method="post" id="frm-consulta-ruc">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="ruc_numero" id="ruc_numero" class="form-control" placeholder="Ingrese RUC" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                                </span>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            <form id="frm-proveedor" action="/proveedores/RUProveedor" method="post" enctype="multipart/form-data">
                @csrf
            <input type="hidden" name="id_prov" value="{{$proveedor->id_prov}}" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Raz&oacute;n Social</label>
                                    <input type="text" name="razon_social" id="razon_social" value="{{$proveedor->razon_social}}" class="form-control" placeholder="Ingrese raz&oacute;n social" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">RUC</label>
                                    <input type="text" name="ruc" id="ruc" data-mask="99999999999" value="{{$proveedor->ruc}}" class="form-control" placeholder="Ingrese ruc" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Direcci&oacute;n</label>
                                    <input type="text" name="direccion" id="direccion" value="{{$proveedor->direccion}}" class="form-control" placeholder="Ingrese direcci&oacute;n" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Tel&eacute;fono</label>
                                    <input type="text" name="telefono" id="telefono" data-mask="999999999" value="{{$proveedor->telefono}}" class="form-control" placeholder="Ingrese tel&eacute;fono" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Correo electr&oacute;nico</label>
                                    <input type="text" name="email" id="email" value="{{$proveedor->email}}" class="form-control" placeholder="Ingrese correo electr&oacute;nico de la empresa" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Contacto</label>
                                    <input type="text" name="contacto" id="contacto" value="{{$proveedor->contacto}}" class="form-control" placeholder="Ingrese nombre del contacto" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
              <div class="text-right">
                    <a href="lista_comp_prov.php" class="btn btn-white"> Cancelar</a>
                    <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Guardar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="{{URL::to('scripts/compras/proveedores/func_prov_e.js')}}"></script>
<script src="{{URL::to('js/jquery.email-autocomplete.min.js')}}"></script>
<script type="text/javascript">
  $(function () {
    $('#compras').addClass("active");
    $('#c-proveedores').addClass("active");
    $("#email").emailautocomplete({
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