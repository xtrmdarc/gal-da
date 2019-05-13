@extends('layouts.application.master')
@section('content')
    
        <div class="wrapper wrapper-content animated fadeIn ">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-two">
                            <div class="card-body p-b-0">
                                <h1 class="card-title"><i class="fa fa-user mid-icon"></i> Administración de Cuenta</h1>
                                <h3 style="margin: 18px 0 32px;">Hola <b>{{$nombres}}</b></h3>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#u_perfil" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Perfil</span></a> </li>
                                    @if(\Auth::user()->parent_id == '' )
                                        @if(\Auth::user()->plan_id == 2)
                                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#u_pago" role="tab"><span class="hidden-sm-up"><i class="ti-credit-card"></i></span> <span class="hidden-xs-down">Facturación</span></a> </li>
                                        @endif
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#u_suscripcion" role="tab"><span class="hidden-sm-up"><i class="ti-check"></i></span> <span class="hidden-xs-down">Suscripción</span></a> </li>
                                    @endif
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="u_perfil" role="tabpanel">
                                        <div class="row">
                                            <div {{ \Auth::user()->id_rol == 1 ? 'class=col-lg-6' : 'class=col-lg-12' }} ">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material" method="post" enctype="multipart/form-data" action="/perfil">
                                                        @csrf
                                                        <h4><i class="fa fa-user mid-icon"></i><b> Información Personal</b></h4>
                                                        <span>Administra tu cuenta e información personal</span>

                                                        <header style="padding-top: 129px;padding-bottom: 20px;">
                                                            <div class="avatar">
                                                                <img src="{{ $imagen_g }}" id="picture-profile-preview" />
                                                                <input type="hidden" name="imagen_p" value="{{$imagen_g}}" />
                                                            </div>
                                                            <input type="file" name="imagen_p" id="picture-profile"/>
                                                        </header>
                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Nombres</label>
                                                            <div class="col-md-12">
                                                                <input type="text" id="nombres_p" name="nombres_p" placeholder="Ingrese sus Nombres" class="form-control form-control-line" value="{{$nombres}}" maxlength="30">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-6">Apellido Paterno</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="a_paterno_p" name="a_paterno_p" placeholder="Ingrese su Apellido Paterno" class="form-control form-control-line" value="{{$ape_paterno}}" maxlength="30">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-6">Apellido Materno</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="a_materno_p" name="a_materno_p" placeholder="Ingrese su Apellido Materno" class="form-control form-control-line" value="{{$ape_materno}}" maxlength="30">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-email" class="col-md-6">Email</label>
                                                            <div class="col-md-6">
                                                                <input type="email" placeholder="Ingrese su Email" class="form-control form-control-line" name="email_p" id="email_p" value="{{$email}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-6">Dni
                                                                    <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                                                        <span class="tooltiptext-g">Documento de Identidad</span>
                                                                    </div>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="dni_p" name="dni_p" placeholder="Ingrese su Dni" class="form-control form-control-line " maxlength="20" value="{{$dni}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-12">Telefono/Celular</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <select name="cod_phone" id="cod_phone" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                                                    <optgroup label="Seleccionar">
                                                                        @foreach($cod_telefonos as $r)
                                                                            @if($r->phone_codigo == $codigo_phone)
                                                                                <option selected="selected" value="{{$codigo_phone}}">{{$r->nombre}}+({{$r->phone_codigo}})</option>
                                                                            @else
                                                                                <option value="{{$r->phone_codigo}}">{{$r->nombre}}+({{$r->phone_codigo}})</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="telefono_p" name="telefono_p" placeholder="Ingrese su Telefono" class="form-control form-control-line validanumericos" value="{{$phone}}" maxlength="13">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-3" style="float: right;">
                                                                <button type="submit" class="btn btn-success" style="width: 100px;"> Guardar </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @if(\Auth::user()->parent_id == '')
                                                <div class="col-lg-6">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <h4><i class="fa fa-list mid-icon"></i><b> Contraseña</b></h4>
                                                    <span>Modifica tu contraseña</span>

                                                    <div id="form-change-password" class="form-horizontal form-material">
                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Contraseña</label>
                                                            <div class="col-md-12">
                                                                <input type="password" value="*************" class="form-control form-control-line" disabled>
                                                            </div>
                                                        </div>

                                                        <button id="cambiar_password_s" type="button" class="btn btn-success">Cambiar contraseña</button>
                                                    </div>
                                                    <form id="form-change-password-reset" class="form-horizontal form-material" method="post" style="display: none;" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Contraseña Actual</label>
                                                            <div class="col-md-12">
                                                                <input id="current-password" type="password" name="data[user][current_password]" class="form-control form-control-line" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">Nueva Contraseña</label>
                                                            <div class="col-md-12">
                                                                <input id="new-password" type="password" name="data[user][password]" class="form-control form-control-line" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">Confirmar nueva Contraseña</label>
                                                            <div class="col-md-12">
                                                                <input id="confirm-new-password" type="password" name="data[user][password_confirmation]" class="form-control form-control-line" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <button id="btn_guardar_pass" type="submit" class="btn btn-success" style="width: 100px;"> Guardar </button>
                                                            </div>
                                                            <div class="col-sm">
                                                                <button id="cambiar_password_h" type="reset" class="btn btn-default btn-outline m-b-10">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </div></div>
                                    <div class="tab-pane p-20" id="u_pago" role="tabpanel">
                                        @if(\Auth::user()->parent_id == '' && \Auth::user()->plan_id == '2' )
                                            <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body" style="padding-bottom: 20px;">
                                                    <h4><i class="fa fa-user mid-icon"></i><b> Tipo de Pago</b></h4>
                                                    <span>Ingrese su método de pago preferido</span>

                                                    <div id="add-card" class="row" style="margin-top: 20px;">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-10">
                                                                <div id="form-change-card" class="form-horizontal form-material">
                                                                    <div class="form-group" style="padding-top: 20px;">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 form-group">
                                                                                <label for="card[number]">Número de tarjeta</label>
                                                                                @if($r_cod == 0)
                                                                                    <input type="tel" value="{{$card_brand}} {{$card_number}}" class="form-control form-control-line" disabled>
                                                                                @else
                                                                                    <input type="tel" value="{{$card_brand}} ****{{$card_number}}" class="form-control form-control-line" disabled>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if($r_cod == 0)
                                                                        <button id="cambiar_tarjeta" type="button" class="btn btn-success">Agregar Tarjeta</button>
                                                                    @else
                                                                        <button id="cambiar_tarjeta" type="button" class="btn btn-success">Cambiar Tarjeta</button>
                                                                    @endif
                                                                </div>
                                                                <div id="form-change-card-h" style="display: none;">
                                                                    <form id="form-agregar-tarjeta" method="POST" action="/actualizarTarjeta">
                                                                        @csrf
                                                                        <input type="text" style="display:none;" size="50" data-culqi="card[email]" id="card[email]" value="{{isset(\Auth::user()->info_fact_id)?$info_fact->Email:''}} ">
                                                                        <div class="row">
                                                                            <div class="col-sm-6 form-group">
                                                                                <label for="card[number]">Número de tarjeta</label>
                                                                                <input class="form-control credit-card" type="tel" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" size="20" data-culqi="card[number]" id="card[number]" maxlength="20" style="letter-spacing:3px;word-spacing:20px;">
                                                                            </div>
                                                                            <div class="col-sm-5 col-md-4 form-group" >
                                                                                <label>F. Venc. (MM/YYYY)</label>
                                                                                <div class="row ">
                                                                                    <div class="col-xs-6">
                                                                                        <input class="form-control text-center" size="2" data-culqi="card[exp_month]" id="card[exp_month]" type="text"   placeholder="MM" maxlength="2" minlength="2">
                                                                                    </div>

                                                                                    <div class="col-xs-6" style="padding-left :0px;">
                                                                                        <input class="form-control text-center" size="4" data-culqi="card[exp_year]" id="card[exp_year]" type="text" placeholder="YYYY" maxlength="4" minlength="4">
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4 col-md-2" style="float:right;">
                                                                                <label for="card[cvv]">CVV</label>
                                                                                <input class="form-control text-center" type="text" size="4" data-culqi="card[cvv]" id="card[cvv]" placeholder="___"maxlength="4" minlength="3" >
                                                                            </div>
                                                                        </div>
                                                                        {{--/*
                                                                        <div class="row">
                                                                            <div class="col-sm-5 col-md-4 form-group" >
                                                                                <label>F. Venc. (MM/YYYY)</label>
                                                                                <div class="row ">
                                                                                    <div class="col-xs-6">
                                                                                        <input class="form-control text-center" size="2" data-culqi="card[exp_month]" id="card[exp_month]" type="text"   placeholder="MM" maxlength="2" minlength="2">
                                                                                    </div>

                                                                                    <div class="col-xs-6" style="padding-left :0px;">
                                                                                        <input class="form-control text-center" size="4" data-culqi="card[exp_year]" id="card[exp_year]" type="text" placeholder="YYYY" maxlength="4" minlength="4">
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4 col-md-2" style="float:right;">
                                                                                <label for="card[cvv]">CVV</label>
                                                                                <input class="form-control text-center" type="text" size="4" data-culqi="card[cvv]" id="card[cvv]" placeholder="___"maxlength="4" minlength="3" >
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <button  type="submit" id="btn-agregar-tarjeta" class="btn btn-success" style="float:right;width:100px;" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> ">Guardar</button>
                                                                            </div>
                                                                            <div class="col-sm">
                                                                                <button id="cambiar_tarjeta_h" type="reset" class="btn btn-default btn-outline m-b-10">Cancelar</button>
                                                                            </div>
                                                                        </div>
                                                                        */--}}
                                                                        <div class="row">
                                                                            <div class="col-sm-2">
                                                                                <button  type="submit" id="btn-agregar-tarjeta" class="btn btn-success" style="float:right;width:100px;" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> ">Guardar</button>
                                                                            </div>
                                                                            <div class="col-sm">
                                                                                <button id="cambiar_tarjeta_h" type="reset" class="btn btn-default btn-outline m-b-10">Cancelar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body">
                                                    <form class="form-horizontal form-material">
                                                        <h4><i class="fa fa-list mid-icon"></i><b> Recibos</b></h4>
                                                        <span>Revisa tus recibos mensuales.</span>

                                                        <table class="table table-striped" style="margin-top: 20px;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>Kolor Tea Shirt For Man, January 22</td>
                                                                <td class="color-primary">$21.56</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>Kolor Tea Shirt For Women, January 30</td>
                                                                <td class="color-success">$55.32</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">3</th>
                                                                <td>Blue Backpack For Baby, January 25</td>
                                                                <td class="color-danger">$14.85</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="u_suscripcion" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body">
                                                    @if(\Auth::user()->parent_id == '')
                                                        <h4><i class="fa fa-list mid-icon"></i><b> Plan Actual</b></h4>
                                                        <span>Administra tu actual suscripcion, actualiza tu plan.</span>

                                                        <input type="hidden" name="plan_id" value="1">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <h5 class="m-t-30"><b style="color: #1fbdb7;">Plan {{$subscription->nombre }} </b> - <b>{{$subscription->precio}} USD {{$subscription->id_periodicidad==1?'mensual':'anual'}}</b> </h5>
                                                                @if($subscription->plan_id == 2 && $subscription->estado == 1)
                                                                    <h5>Renovación Automática: <b style="color: #1fbdb7;"> <i class="fa fa-check"></i> Activada </b></h5>
                                                                @else
                                                                    @if($subscription->plan_id == 2 && $subscription->estado == 2)
                                                                        <h5>Renovación Automática: <b style="color: #ef5350;"> <i class="fa fa-close"></i> Desactivada </b></h5>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            @if(\Auth::user()->plan_id == 2 && $subscription->estado == 1)
                                                                <div class="col-sm">
                                                                    <h5 class="m-t-30" style="float: right;"><b>Tu suscripción se renueva el:</b> {{$f_renovacio}}</h5>
                                                                </div>
                                                            @else
                                                                @if(\Auth::user()->plan_id == 2 && $subscription->estado == 2)
                                                                    <div class="col-sm">
                                                                        <h5 class="m-t-30" style="float: right;"><b>Tu suscripción finalizará el:</b> {{$f_renovacio}}</h5>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <h5 class="m-t-30">Nro de Ventas en este mes: <span><b>{{ $nventas  }} </b> {{ \Auth::user()->plan_id == 1? 'de 1000' : '' }} </span> <span class="pull-right">{{ $nventas  }}</span></h5>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{ $nventas  }}" aria-valuemin="0" aria-valuemax="1000" style="width:{{ $nventas  }}px; height:6px;"> <span class="sr-only">50% Complete</span> </div>
                                                        </div>

                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <a class="btn btn-success" href="/upgrade">Administrar Plan</a>
                                                        </div>
                                                        @if(\Auth::user()->plan_id == 2 && $subscription->estado == 1)
                                                            <div class="col-sm">
                                                                <a id="cancelar_plan" class="btn btn-danger">Cancelar Renovación</a>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal fade" id="mdl-cancelar-plan" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content animated bounceInRight">
                    <form id="frm-cancelar-plan" class="unif_modal" method="post" enctype="multipart/form-data" action="/cancelar_subscripcion">
                        @csrf
                        <input type="hidden" name="cod_subs" id="cod_subs" value="{{$subscription->culqi_id }}">
                        <div class="modal-header mh-p" style="border: none;">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                            <i class="fa fa-exclamation-circle modal-icon"></i>
                        </div>
                        <div class="modal-body" style="background: none; padding: 10px 30px 80px 30px;">
                            <h2 style="text-align: center;">¿Estas seguro de cancelar tu Plan?</h2>
                            <h5 style="text-align: center;">Siempre podras adquirir nuevamente el plan o cancelarlo</h5>
                            <center>
                                <a style="text-decoration-line: underline!important;color: #4680ff;" href="/upgrade">Administrar Plan</a>
                            </center>
                        </div>
                        <div class="modal-footer" style="background: #f8fafb;">
                            <div class="row" style="width: 100%;">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-danger">Sí, cancelo mi plan</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">No, no cancelo mi plan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="{{URL::to('rest/scripts/usuario/usuario_perfil.js' )}}"></script>
    <script src="https://checkout.culqi.com/v2"></script>

    <script type="text/javascript">
        $('#navbar-c').addClass("white-bg");
        $('#informes').addClass("active");
    </script>
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#picture-profile-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#picture-profile").change(function() {
            readURL(this);
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
    <script type="text/javascript">

        Culqi.publicKey = 'pk_test_xwCI0lmt8MrIT9N1';
        Culqi.init();

        $('#form-agregar-tarjeta').on('submit', function(e) {

            if($('#card\\[email\\]').val()=='') return;

            $('#btn-agregar-tarjeta').prop('disabled',true);
            Culqi.createToken();
            e.preventDefault();

            console.log('llego aquí');
        });

        function culqi() {

            if (Culqi.token) { // ¡Objeto Token creado exitosamente!
                var token = Culqi.token.id;
                //alert('Se ha creado un token:' + token);
                console.log('llego '+token );
                $.ajax({
                    type: "POST",
                    url: '/actualizarTarjeta',
                    data: {
                        token: token
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response){
                        if(response.cod === 1) {
                            toastr.success('Se ha actualizado correctamente su tarjeta!');
                            window.location = "/perfil";
                        } else {
                            $('#btn-agregar-tarjeta').button('reset');
                            $('#btn-agregar-tarjeta').prop('disabled',false);
                            toastr.error('No hemos podido actualizar tu tarjeta.');
                        }
                    }
                });
            } else { // ¡Hubo algún problema!
                // Mostramos JSON de objeto error en consola
                console.log(Culqi.error);
                alert(Culqi.error.user_message);
                $('#btn-agregar-tarjeta').button('reset');
            }
        };
    </script>
@endsection