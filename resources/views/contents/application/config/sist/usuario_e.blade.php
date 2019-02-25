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
                    <input type="hidden" name="id_usu" value="{{is_null($id_usu) ? '' : $id_usu}}" />
                    <div class="ibox-content">
                        <div class="row">
                                    <div class="col-lg-6" style="display:none">   
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

                                    <div class="col-lg-6  sides_padding15">
                                        <div class="form-group">
                                            <label class="control-label">Cargo</label>
                                            <div class="input-group">
                                                <select name="id_rol" id="id_rol" class="show-tick form-control" data-live-search="false"  autocomplete="off" required>

                                                    <optgroup label="Seleccionar">
                                                        @foreach($user_rol as $r)
                                                            @if($r->id_rol == $id_rol)
                                                            <option selected="selected" value="{{$r->id_rol}}">{{$r->descripcion}}</option>
                                                                {{--/*
                                                                    En Free no puedan cambiarle al editar de Rol a sus Trabajadores
                                                                    @else
                                                                    <option value="{{$r->id_rol}}">{{$r->descripcion}}</option>
                                                                */--}}
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 sides_padding15 " id="dni_div">
                                        <div class="form-group">
                                            <label class="control-label">Dni</label>
                                            <input type="text" name="dni" id="dni" value="{{is_null($id_usu) ? '' : $dni}}" class="form-control validanumericos" placeholder="Ingrese dni" maxlength="8" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                
                                
                                    <div class="col-lg-12 sides_padding15" id="nombres_div">
                                        <div class="form-group">
                                            <label class="control-label">Nombres</label>
                                            <input type="text" name="nombres" value="{{is_null($id_usu) ? '' : $nombres}}" class="form-control" placeholder="Ingrese nombres" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 sides_padding15" id="app_div">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Paterno</label>
                                            <input type="text" name="ape_paterno" value="{{is_null($id_usu) ? '' : $ape_paterno}}" class="form-control" placeholder="Ingrese apellido paterno" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 sides_padding15" id="apm_div">
                                        <div class="form-group">
                                            <label class="control-label">Apellido Materno</label>
                                            <input type="text" name="ape_materno" value="{{is_null($id_usu) ? '' : $ape_materno}}" class="form-control" placeholder="Ingrese apellido materno" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 sides_padding15" id="email_div">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="email" name="email" id="email" value="{{is_null($id_usu) ? '' : $email}}" class="form-control" placeholder="Ingrese email" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                
                                        
                                    <div class="col-lg-6 sides_padding15" id="usr_div">
                                        <div class="form-group">
                                            <label class="control-label">Usuario</label>
                                            <div class="row ">
                                                <div class="input-group  col-sm-6">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    {{--/*
                                                        Aun no se pueda editar el usuario.
                                                    <input type="text" name="usuario" value="{{is_null($id_usu) ? '' : $usuario}}" class="form-control" placeholder="Ingrese usuario" autocomplete="off" required="required" />
                                                    */--}}
                                                    <span style="font-size:16px; margin-top:auto;margin-bottom:auto;">{{$usuario}}</span>
                                                </div>
                                                {{--/*
                                                <div class="input-group col-sm-6">
                                                    <span style="font-size:16px; margin-top:auto;margin-bottom:auto;">{{$usuario.'@'.$nombre_empresa}}</span>
                                                </div>
                                                */--}}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 sides_padding15"  id="pass_div">
                                        <div class="form-group">
                                            <label class="control-label">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                                                <input type="password" name="contrasena" id="contrasena_show" value="{{is_null($id_usu) ? '' : $contrasena}}" class="form-control" placeholder="Ingrese contrase&ntilde;a" autocomplete="off" required="required" />
                                                <span toggle="#contrasena_show" class="fa input-group-addon  fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6  sides_padding15" id="pin_div" >
                                        <div class="form-group">
                                            <label class="control-label">PIN</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-certificate"></i></span>    
                                                <input type="password" name="pin" id="pin_field_e" value="{{$pin}}" class="form-control validanumericos" placeholder="Ingrese 4 digitos" minlength="4" maxlength="4" autocomplete="off" required="required" />
                                                <span toggle="#pin_field_e" class="fa input-group-addon  fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->plan_id == '1' && Auth::user()->parent_id == null)
                                        <div class="col-lg-6  sides_padding15" id="sc_div">
                                            <div class="form-group">
                                                <label class="control-label">Sucursal</label>
                                                <div class="input-group">
                                                    {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                    <select name="id_sucursal" id="id_sucursal" class="selectpicker show-tick form-control" @if (Auth::user()->plan_id == 1 )readonly="readonly"@endif data-live-search="true" autocomplete="off" required="required" >
                                                        @foreach($user_sucursal as $r)
                                                            <option @if($r->id == $id_sucursal)selected @endif  value="{{$r->id}}">{{$r->nombre_sucursal}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        
                                    <div class="col-lg-6 sides_padding15" id="area-p" style="display: none" >
                                        <div class="form-group">
                                            <label class="control-label">&Aacute;rea de Producci&oacute;n</label>
                                            <div class="input-group">
                                                {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                <select name="cod_area" id="cod_area" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required">
                                                    <optgroup label="Seleccionar">
                                                        @foreach($user_areaProd as $r)
                                                            <option value="{{$r->id_areap}}">{{$r->nombre}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
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
    <script src="{{URL::to('js/plugins/wizard/jquery.bootstrap.wizard.js' )}}" type="text/javascript"></script>
    <script src="{{URL::to('js/plugins/wizard/wizard.js' )}}"></script>
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