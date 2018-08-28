@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2><i class="fa fa-cogs"></i> <a class="a-c" href="{{ url('/ajustes') }}">Ajustes</a></h2>
            <ol class="breadcrumb">
                <li class="active">
                    <strong>Sistema</strong>
                </li>
                <li class="active">
                    <strong><a href="{{ url('/ajustesUsuarios') }}">Usuarios</a></strong>
                </li>
                <li>Edici&oacute;n</li>
            </ol>
        </div>
    </div>

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
                                                        @if($id_usu != null)
                                                            <option value="">

                                                            </option>
                                                        @else
                                                            echo '<option value="" selected>Seleccionar</option>';
                                                            echo '<optgroup label="Seleccionar">';
                                                                @endif
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
                                                <label class="control-label">DNI</label>
                                                <input type="text" name="dni" value="" class="form-control" placeholder="Ingrese dni" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6  sides_padding15 " id="nombres_div">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombres</label>
                                                        <input type="text" name="nombres" value="" class="form-control" placeholder="Ingrese nombres" autocomplete="off" required="required" />
                                                    </div>
                                                </div>
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
                                        
                                        <div class="col-lg-6  sides_padding15" id="usr_div">
                                            <div class="form-group">
                                                <label class="control-label">Usuario</label>
                                                <div class="row">

                                                
                                                <div class="input-group col-sm-6">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" name="usuario" value="" class="form-control" placeholder="Ingrese usuario" autocomplete="off" required="required" />
                                                </div>
                                                <div class="input-group col-sm-6">
                                                    <span style="font-size:16px; margin-top:auto;margin-bottom:auto;">{{'@'.$nombre_empresa}}</span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6  sides_padding15" id="pass_div">
                                            <div class="form-group">
                                                <label class="control-label">Contrase&ntilde;a</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                                                    <input type="password" name="contrasena" value="" class="form-control" placeholder="Ingrese contrase&ntilde;a" autocomplete="off" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6  sides_padding15" id="pin_div" style="display: none">
                                            <div class="form-group">
                                                <label class="control-label">PIN</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i  class="fa fa-certificate"></i></span>
                                                    <input type="password" name="pin" id="pin_field" value="" class="form-control" placeholder="Ingrese 4 digitos" autocomplete="off" required="required" />
                                                    <span toggle="#pin_field" class="fa input-group-addon  fa-eye field-icon toggle-password"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if(Auth::user()->plan_id == '1' && Auth::user()->parent_id == null)
                                            <div class="col-lg-6  sides_padding15" id="sc_div">
                                                <div class="form-group">
                                                    <label class="control-label">Sucursal</label>
                                                    <div class="input-group">
                                                        {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                                        <select name="id_sucursal" id="id_sucursal" class="selectpicker show-tick form-control" @if (Auth::user()->plan_id == 1 )readonly="readonly"@endif data-live-search="true" autocomplete="off" required="required" placeholder="Seleccionar" >
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
                                                    <select name="cod_area" id="cod_area" class="selectpicker show-tick form-control" title="Seleccionar" data-live-search="true" autocomplete="off" required="required">
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
</div>
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

@endsection('content')