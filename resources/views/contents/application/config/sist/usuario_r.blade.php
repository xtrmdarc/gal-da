@extends('layouts.application.master')

@section('content')

    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Usuario</h5>
                    </div>
                    <form id="frm-usuario" action="/ajustesRUsuario" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_usu" value="" />
                        <input type="hidden" name="nombre_empresa" value="{{$nombre_empresa}}" />  
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6" style="display:none;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ct-wizard-azzure" id="wizardProfile">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        @if($id_usu != null)
                                                            <img src="assets/img/usuarios/" class="picture-src" id="wizardPicturePreview" title=""/>
                                                            <input type="hidden" name="imagen" value="" />
                                                            <input type="file" name="imagen" id="wizard-picture">
                                                        @else
                                                            <img src="assets/img/usuarios/default-avatar.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                                            <input type="hidden" name="imagen" value="default-avatar.png" />
                                                            <input type="file" name="imagen" id="wizard-picture">
                                                        @endif
                                                    </div>
                                                    <h6>Cambiar Imagen</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 ">
                                    <div class="row">
                                       
                                        <div class="col-lg-6  sides_padding15">
                                            <div class="form-group">
                                                <label class="control-label">Cargo</label>
                                                <div class="input-group">
                                                    {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                    <select name="id_rol" id="id_rol" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required>
                                                                <optgroup label="Seleccionar">
                                                                    @foreach($user_rol as $r)
                                                                        <option value="{{$r->id_rol}}">{{$r->descripcion}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                       
                                        <div class="col-lg-6  sides_padding15  " id="dni_div">
                                            <div class="form-group">
                                                <label class="control-label">DNI
                                                    <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                                        <span class="tooltiptext-g">Documento de Identidad</span>
                                                    </div>
                                                </label>
                                                <input type="text" name="dni" value="" class="form-control " placeholder="Ingrese dni" maxlength="15" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-lg-12  sides_padding15" id="nombres_div">
                                            <div class="form-group">
                                                <label class="control-label">Nombres</label>
                                                <input type="text" name="nombres" value="" class="form-control" placeholder="Ingrese nombres" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6  sides_padding15 " id="app_div">
                                            <div class="form-group">
                                                <label class="control-label">Apellido Paterno</label>
                                                <input type="text" name="ape_paterno" value="" class="form-control" placeholder="Ingrese apellido paterno" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6  sides_padding15 " id="apm_div">
                                            <div class="form-group">
                                                <label class="control-label">Apellido Materno</label>
                                                <input type="text" name="ape_materno" value="" class="form-control" placeholder="Ingrese apellido materno" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-lg-6  sides_padding15" id="email_div">
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" id="email" value="" class="form-control" placeholder="Ingrese email" autocomplete="off" required="required" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6  sides_padding15">
                                            <div class="form-group">
                                                <label class="control-label">Sucursal</label>
                                                <div class="input-group">
                                                    @foreach($user_sucursal as $r)
                                                        <input type="text" class="form-control" value="{{$r->nombre_sucursal}}" readonly />
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6  sides_padding15" id="usr_div">
                                            <div class="form-group">
                                                <label class="control-label">Usuario
                                                    <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                                        <span class="tooltiptext-g">Este será el Usuario con el que accederá al sistema.</span>
                                                    </div>
                                                </label>
                                                <div class="row sides_padding15">

                                                
                                                <div class="input-group col-xs-6">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" name="usuario" value="" class="form-control" placeholder="Ingrese usuario" autocomplete="off" required="required" />
                                                </div>
                                                <div class="input-group col-xs-6">
                                                    <span style="font-size:16px; margin-top:auto;margin-bottom:auto; margin-right:auto; margin-left:auto;">{{'@'.$nombre_empresa}}</span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-6  sides_padding15" id="pass_div">
                                            <div class="form-group">
                                                <label class="control-label">Contraseña
                                                    <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                                        <span class="tooltiptext-g">Por su seguridad no mostramos la contraseña, puede ingresar otra contraseña si desea cambiarla.</span>
                                                    </div>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                                                    <input type="password" name="contrasena" value="" class="form-control" placeholder="Ingrese contrase&ntilde;a" autocomplete="off" required="required" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  sides_padding15" id="pin_div" style="display: none">
                                            <div class="form-group">
                                                <label class="control-label">PIN
                                                    <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                                        <span class="tooltiptext-g">Es un código secreto para que el Mozo realice un pedido en la Vista de Multimozo.</span>
                                                    </div>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i  class="fa fa-certificate"></i></span>
                                                    <input type="password" name="pin" id="pin_field" value="" class="form-control validanumericos" placeholder="Ingrese 4 digitos" maxlength="4" minlength="4" autocomplete="off" required="required" />
                                                    <span toggle="#pin_field" class="fa input-group-addon  fa-eye field-icon toggle-password"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if((Auth::user()->plan_id == '1' && Auth::user()->parent_id == null) || Auth::user()->plan_id == '2' && Auth::user()->parent_id == null)
                                            <div class="col-lg-6  sides_padding15" id="sc_div">
                                                <div class="form-group">
                                                    <label class="control-label">Sucursal</label>
                                                    <div class="input-group">
                                                        {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                        <select name="id_sucursal" id="id_sucursal" class="selectpicker show form-control" @if ((Auth::user()->plan_id == 1) || (Auth::user()->plan_id == 2))readonly="readonly"@endif autocomplete="off" required="required" placeholder="Seleccionar" >
                                                            @foreach($user_sucursal as $r)
                                                                <option value="{{$r->id}}">{{$r->nombre_sucursal}}</option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-lg-6 sides_padding15" id="area-p" style="display: none">
                                            <div class="form-group">
                                                <label class="control-label">&Aacute;rea de Producci&oacute;n</label>
                                                <div class="input-group">
                                                    {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                    <select name="cod_area" id="cod_area" class="selectpicker show form-control" title="Seleccionar" autocomplete="off" required="required">
                                                            <option value="" disabled selected>Seleccionar</option>
                                                            @foreach($user_areaProd as $r)
                                                                <option value="{{$r->id_areap}}">{{$r->nombre}}</option>
                                                            @endforeach
                                                           
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <div class="text-right">
                                <a href="/ajustesUsuarios" class="btn btn-default">Cancelar</a>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
<script src="{{URL::to('rest/scripts/config/func_usuario_e.js' )}}"></script>
<script src="{{URL::to('rest/js/plugins/wizard/jquery.bootstrap.wizard.js' )}}" type="text/javascript"></script>
<script src="{{URL::to('rest/js/plugins/wizard/wizard.js' )}}"></script>
<script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js' )}}"></script>
<script type="text/javascript">
    $(function () {
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
@endsection
    
