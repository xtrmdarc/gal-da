@extends('layouts.application.master')

@section('content')

    <input type="hidden" id="m" value=""/>
    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-lg-8">
                <div class="ibox animated bounce">
                    <form action="/ajustesFacturacion" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="ibox-title">
                            <h5><i class="fa fa-vcard-o"></i> Facturaci&oacute;n</h5>
                        </div>
                        <div class="ibox-content my-scroll">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="div_comprobantes_enviar" class="col-sm-12 p-2 border border-info bg-light rounded mb-3" style="display: block;">
                                        <p style="margin: 0px;">Tu usuario y contrase&ntilde;a no se guarda en nuestro sistema por tu seguridad.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">USUARIO</label>
                                                <input type="text" name="usuario_f" value="" class="form-control" placeholder="Ingrese su usuario" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">CONTRASE&Ntilde;A</label>
                                                <input type="password" name="contrasenia_f" value="" class="form-control" placeholder="Ingrese su contrase&ntilde;a" maxlength="23" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 0px;">
                                     <div class="form-group">
                                         <label class="control-label">CERTIFICADO DIGITAL</label>
                                         @if(empty($certificado_d))
                                             <h5><b style="color: #ef5350;"> <i class="fa fa-close"></i> Sin Guardar </b></h5>
                                             <div class="picture">
                                                 <input type="file" name="file_f">
                                             </div>
                                         @else
                                             <div id="save_certificado">
                                                 <div class="row">
                                                     <div class="col-sm-2">
                                                         <h5><b style="color: #1fbdb7;"> <i class="fa fa-check"></i> Guardado </b></h5>
                                                     </div>
                                                     <div class="col-sm-10" style="padding-top: 5px;">
                                                         <a id="edit_certi" style="text-decoration-line: underline!important;color: #4680ff;" class="file-control active">Editar</a>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div id="edit_certificado" style="display: none;">
                                                 <div class="row">
                                                     <div class="col-sm-3">
                                                         <h5><b style="color: #ef5350;"> <i class="fa fa-close"></i> Sin Guardar </b></h5>
                                                     </div>
                                                 </div>
                                                 <div class="row">
                                                     <div class="col-sm-4">
                                                         <div class="picture">
                                                             <input type="file" name="file_f">
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-8" style="padding-top: 5px;">
                                                         <a id="cancel_certi" style="text-decoration-line: underline!important;color: #4680ff;" class="file-control active">Cancelar</a>
                                                     </div>
                                                 </div>
                                             </div>
                                         @endif
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <div class="text-right">
                                <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="wrapper wrapper-content">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-10 block-center">
                                <br>
                                <h1 class="ich m-t-none brand-color">M&oacute;dulo de Facturaci&oacute;n</h1>
                                <br>
                                <p class="ng-binding ">Ingresa tu usuario, contrase&ntilde;a y adjunta tu certificado digital. Para que puedas facturar electr&oacute;nicamente y <strong class="accent-color"> potenciar tus ventas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{URL::to('rest/scripts/config/func_facturacion.js' )}}"></script>
    <script type="text/javascript">
        $('#config').addClass("active");
    </script>
@endsection('content')