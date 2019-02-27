@extends('layouts.home.master_h_f_empty')

@section('content')

{{-- <div class="container-fluid">
    <div class="row "  style="background-color:#efefef;padding:10px;">
        <div class="col-sm-12" >
            <p>Actualizar plan</p>
        </div>
    </div>  
</div> --}}


<div class="container-fluid" style="background-color:#f9f9f9" >
    <div class="row ">
            
        <input id="plan-id" type="hidden" value="{{$plan->culqi_id}}">
        {{-- Informacion de pago --}}
        <div class="col-sm-8">
            <div class="row text-center" style="margin-top:20px;">
                <img src="{{URL::to('/home/images/logo-1.png')}}" width="200px" alt="Gal-Da Sistema para restaurantes">
            </div>
            <div class="row" style="padding:30px ">
                <div class="col-sm-12 col-md-10 col-lg-10 card billing-form" style="float:none;margin:auto" >

                    <div data-toggle="collapse" data-target="#div_billing_form" aria-expanded="true" aria-controls="#div_billing_form">
                        <h2 class="section-title">Información de facturación</h2>
                        <div id="summary_billing_info" style="display:none;">
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group empresarial-div-sum" >
                                        <label for="sum_dir">Razón social </label>
                                        <p id="sum_razon_social"value="" readonly >  {{$info_fact->RazonSocial}} </p>
                                    </div>

                                    <div class="form-group empresarial-div-sum">
                                        <label for="sum_dir">Identificador fiscal (RUC,NIF,etc) </label>
                                        <p id="sum_ruc"value="" readonly >  {{$info_fact->Ruc}} </p>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="sum_nomb">Nombre</label>
                                            <p id="sum_nomb" >{{$info_fact->Nombre}} </p>
                                        </div>
                
                                        <div class="form-group col-sm-6">
                                            <label for="sum_apell">Apellido</label>
                                            <p id="sum_apell"  >{{$info_fact->Apellido}}</p>
                                        </div>
                                    </div>
        
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="sum_pais">País</label>
                                            <p id="sum_pais"  readonly>{{$info_fact->CodigoPais}}</p>
                                        </div>
                
                                        <div class="form-group col-sm-6">
                                            <label for="sum_ciudad">Ciudad</label>
                                            <p id="sum_ciudad" > {{$info_fact->Ciudad}}</p>
                                        </div>

                                    </div>     

                                    <div class="form-group">
                                        <label for="sum_dir">Dirección </label>
                                        <p id="sum_dir"value="" readonly >  {{$info_fact->Direccion}} </p>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>

                    <div id="div_billing_form" class="collapse in" > 

                        <p  >Esta es la información de tu domicilio o la de tu empresa </p>
                        {{-- Tab de empresa o nombre propio --}}
                        <ul id="ul_empresarial" class="nav nav-pills nav-justified nav-billing " style="margin-top:20px;" >
                            <li empr="0" class=" {{$info_fact->EsEmpresarial==0?'active':''}} btn-half-width"><a data-toggle="pill" href="#tab_propio_billing_info" >A mi nombre</a></li>
                            <li empr="1" class="  {{$info_fact->EsEmpresarial==0?'':'active'}} btn-half-width"><a data-toggle="pill" href="#tab_empresa_billing_info">Empresa</a></li>
                        </ul>

                        <div class=" tab-content">
                            
                            {{-- Tab nombre propio --}}
                            <div id="tab_propio_billing_info" class="tab-pane fade  {{$info_fact->EsEmpresarial==0?'in active':''}} " >
                                <h3 class="section-title">Información de contacto</h3>
    
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="prop_nomb">Nombre</label>
                                        <input id="prop_nomb" class="form-control" type="text" value="{{$info_fact->Nombre}}">    
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="prop_apell">Apellido</label>
                                        <input id="prop_apell" class="form-control" type="text" value="{{$info_fact->Apellido}}">
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="prop_email">Email</label>
                                        <input id="prop_email" class="form-control" type="text" value="{{$info_fact->Email}}">    
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="prop_telef">Teléfono</label>
                                        <input id="prop_telef" class="form-control" type="text" value="{{$info_fact->Telefono}}" >    
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="prop_pais">País</label>
                                        <select name="prop_pais" id="prop_pais" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                            
                                            @foreach($paises as $r)
                                                <option  {{$info_fact->CodigoPais == $r->codigo?'selected':''}} value="{{$r->codigo}}">{{$r->nombre}}</option>
                                            @endforeach
                                                
                                        </select> 
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="prop_ciudad">Ciudad</label>
                                        <input id="prop_ciudad" class="form-control" type="text" value="{{$info_fact->Ciudad}}" >    
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="prop_dir">Dirección (se facturará a esta dirección)</label>
                                    <input id="prop_dir" class="form-control" type="text" value="{{$info_fact->Direccion}}" >    
                                </div>
    
    
                                
    
                            </div>
    
                            {{-- Tab empresa --}}
                            <div id="tab_empresa_billing_info" class="tab-pane fade {{$info_fact->EsEmpresarial==0?'':'in active'}}">
                                
                                <h3 class="section-title">Información de empresa</h3>
                                <div class="form-group">
                                    <label for="razon_social">Nombre o razón social</label>
                                    <input id="razon_social" name="razon_social" class="form-control" type="text" value="{{$info_fact->RazonSocial}}" >    
                                </div>
                                
                                <div class="form-group">
                                    <label for="ruc">Identificador fiscal (RUC,NIF,etc)</label>
                                    <input id="ruc" class="form-control" type="text" value="{{$info_fact->Ruc}}" >    
                                </div>
    
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="emp_pais">País</label>
                                        <select name="emp_pais" id="emp_pais" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                              
                                            @foreach($paises as $r)
                                                <option  {{$info_fact->CodigoPais == $r->codigo?'selected':''}} value="{{$r->codigo}}">{{$r->nombre}}</option>
                                            @endforeach
                                              
                                        </select>
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="emp_ciudad">Ciudad</label>
                                        <input id="emp_ciudad" class="form-control" type="text" value="{{$info_fact->Ciudad}}">    
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="emp_dir">Dirección (se facturará a esta dirección)</label>
                                    <input id="emp_dir" class="form-control" type="text"  value="{{$info_fact->Direccion}}">    
                                </div>
                                {{-- Información de contacto --}}
                                <h3 class="section-title">Información de contacto</h3>
    
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="emp_nomb">Nombre</label>
                                        <input id="emp_nomb" class="form-control" type="text" value="{{$info_fact->Nombre}}">    
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="emp_apell">Apellido</label>
                                        <input id="emp_apell" class="form-control" type="text" value="{{$info_fact->Apellido}}">    
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="emp_email">Email</label>
                                        <input id="emp_email" class="form-control" type="text" value="{{$info_fact->Email}}">    
                                    </div>
            
                                    <div class="form-group col-sm-6">
                                        <label for="emp_telef">Teléfono</label>
                                        <input id="emp_telef" class="form-control" type="text" value="{{$info_fact->Telefono}}">    
                                    </div>
                                </div>
                                
                                
    
                            </div>
    
                            <div class="row">
                                <div class="col-sm-12">
                                    <button id="btn-confirmar-billing-info" class="btn btn-brand-color" style="float:right;width:120px;"  data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> "> Confirmar</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
            </div>

            <div class="row" style="padding:30px;margin-top:-30px;">
                <div class="col-sm-12 col-md-10 col-lg-10 card billing-form" style="float:none;margin:auto" >

                    <div data-toggle="collapse" data-target="#div_card_info" aria-expanded="true" aria-controls="#div_card_info">
                        <h2 class="section-title" style="margin-bottom:20px;">Método de pago</h2>
                    </div>

                    <div id="div_card_info" class="collapse in">

                        <div class=" radio" style="margin-bottom:30px;">
                            <label for="rb_tc"  >
                                <input  type="radio" id="rb_tc"  name="rb_tc" checked>Tarjeta de crédito/débito
                            </label> 
                        </div>

                        {{-- tarjeta de crédito --}}
                        <div id="card-stored" class="row "  style="display:none">
                            <div class="col-sm-12 ">
                                <div class="col-sm-10 " style="float:none;margin:auto">
                                        
                                    <div class="card">

                                        <p  style="float:right">Activo</p>
                                        <div class="row" style="float:left;">
                                            <div class="col-sm-12 form-group">
                                                <label for="card[number]">Número de tarjeta</label>
                                                <p id="numero-tarjeta" class="text-left" style="font-size:16px;letter-spacing:4px;" >********4111</p>
                                            </div>
                                        </div>
                
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 form-group" >
                                                <label>Fecha creación</label>
                                                <div class="row ">
                                                    <div class="col-sm-12 " >
                                                        <p id="fecha-creacion" class="text-left">12/01/2018</p>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-sm-12"> 
                                            <button  id="btn-editar-tarjeta" class="btn btn-brand-color " style="float:right;margin-left:20px;">Editar</button>
                                            
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>

                        {{-- Formulario tarjeta de crédito --}}
                        <div id="add-card" class="row"  >
                            <div class="col-sm-12">
                                <div class="col-sm-10" style="float:none;margin:auto">

                                    <form id="frm-agregar-tarjeta" >
                                        <input type="text" style="display:none;" size="50" data-culqi="card[email]" id="card[email]" value="{{isset(\Auth::user()->info_fact_id)?$info_fact->Email:''}} ">
                                        <div class="row">
                                            <div class="col-sm-12 form-group">
                                                <label for="card[number]">Número de tarjeta</label>
                                                <input class="form-control credit-card" type="tel" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" size="20" data-culqi="card[number]" id="card[number]" maxlength="20" style="letter-spacing:3px;word-spacing:20px;">
                                            </div>
                                        </div>
                
                                        <div class="row">
                                            <div class="col-sm-5 col-md-4 form-group" >
                                                <label>F. Venc. (MM/YYYY)</label>
                                                <div class="row ">
                                                    <div class="col-xs-6 " >
                                                        <input class="form-control text-center" size="2" data-culqi="card[exp_month]" id="card[exp_month]" type="text"   placeholder="MM" maxlength="2" minlength="2">
                                                    </div>
                                                    
                                                    <div class="col-xs-6" style="padding-left :0px;">
                                                        <input class="form-control text-center" size="4" data-culqi="card[exp_year]" id="card[exp_year]" type="text" placeholder="YYYY" maxlength="4" minlength="4">     
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-3" style="float:right;">
                                                <label for="card[cvv]">CVV</label>
                                                <input class="form-control text-center" type="text" size="4" data-culqi="card[cvv]" id="card[cvv]" placeholder="___"maxlength="4" minlength="3" > 
                                            </div>
                                            
                                        </div>

                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-sm-12"> 
                                                <button id="btn-agregar-tarjeta" class="btn btn-brand-color" style="float:right;width:120px;" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> ">Añadir tarjeta</button>
                                                <button class="btn  " id="btn-cancelar-editar" style="float:right;display:none ">Cancelar</button>
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



        {{-- Summary right --}}
        <div class="col-sm-4 billing-summary-bar"  style="background-color:#1fbdb7;">
            <div class="row" style="margin-top:30px;" >
                
                <h1 class="text-center " >Resumen de compra</h2>
                
                
                <div class="col-sm-12" style="margin-top:20px;">
                    <div class="col-sm-6 text-center" >
                        <button period="1" class="btn btn-half-width btn-plan-periodo  ">Mensual</button>    
                    </div>
                    <div class="col-sm-6 text-center" style="margin:0px">
                        <button period="12" class="btn btn-half-width btn-plan-periodo btn-inactive">Anual</button>    
                    </div>

                    <div class="col-sm-12" style="margin-top:50px; margin-bottom:1000px;" >
                        
                        {{-- <div class="col-xs-8">
                            <p>Plan Gal-Da Basic</p>
                        </div>
                        <div class="col-xs-4 text-right">
                            <p>$39.90</p>
                        </div> --}}

                        <div class="col-sm-12">
                            <span class="text-left">Plan Gal-Da <span id="nombre_plan">{{$plan->nombre}} </span> </span>
                            <span style="float:right;">1</span>
                        </div>
                       
                        <div class="col-sm-12 " style="margin-top:30px;height:20px;border-top-style:dashed;border-width:0.9px;"></div>

                        <div class="col-sm-12 mt-1">
                            <span class="text-left">Precio regular mensual</span>
                            <span style="float:right;" id="precio_mensual_regular" >$ {{number_format($plan->precio_mensual,2,'.','')}}</span>
                        </div>
                        <div class="col-sm-12 mt-1">
                            <span class="text-left">Tu precio por mes</span>
                            <span style="float:right;" id="precio_mensual_actual"> $ {{number_format($plan->precio_mensual,2,'.','')}}</span>
                        </div>

                        <div class="col-sm-12 " style="margin-top:30px;height:20px;border-top-style:dashed;border-width:0.9px;"></div>

                        <div class="col-sm-12 text-center">
                            <span class="title precio" id="precio_total" >$ {{number_format($plan->precio_mensual,2,'.','')}} </span>
                        </div>
                        <div class="col-sm-12" style="margin-top:60px;opacity:0.9;font-size:12px;line-height:12px;">
                                <p>Se le cobrará atuomáticamente <span id="automatic-payment"> ${{number_format($plan->precio_mensual,2,'.','')}} cada mes </span>
                                por renovación de su plan. Puede cancelar la 
                                renovación en cualquier momento.</p>
                        </div>
                        <div class="col-sm-12 text-center " id="wrapper-btn-pagar" style="margin-top:3px;"  >
                            <button class="btn btn-cta btn-block"  id="btn-pagar" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>"> Pagar ${{number_format($plan->precio_mensual,2,'.','')}} </button>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>

</div>




{{-- <div class="price-tables" style="height:100%;">
    <div class="container register-form-step-plan active">
    
        <div class="price-table">
            <div class="row center-block" >
                <div style="">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8"> 
                            <div class="row  justify-content-center">
                                <div  style="overflow:hidden;margin-bottom:2em;">
                                    <div class="col-sm-6 align-self-center">
                                        <h3>Mensualmente</h3>
                                        <span>$29</span>
                                    </div>
                                    <div class="col-sm-6 align-self-center">
                                        <h3>Anualmente</h3>
                                        <span>$290</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="payment-card" >
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <form id="frm-pagar-subscripcion">
                                                        <div class="form-group">
                                                            <label >Correo Electrónico</label> 
                                                            <input class="form-control" type="text" size="50" data-culqi="card[email]" id="card[email]">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Número de tarjeta</label>
                                                            <input class="form-control" type="text" size="20" data-culqi="card[number]" id="card[number]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>CVV</label>
                                                            <input class="form-control"  type="text" size="4" data-culqi="card[cvv]" id="card[cvv]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fecha expiración (MM/YYYY)</label>
                                                            <input size="2" data-culqi="card[exp_month]" id="card[exp_month]">
                                                            <span>/</span>
                                                            <input size="4" data-culqi="card[exp_year]" id="card[exp_year]">
                                                        </div>
                                                        <button id="buyButton" type="submit" class="btn btn-primary pull-right">PAGAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                </div>
                
            </div>
        </div>
    </div>
</div> --}}


@endsection('content')

@section('scripts')

<script src="{{URL::to('/home/js/checkout/checkout.js')}} "></script>
<script src="https://checkout.culqi.com/v2"></script>
<script>

    GetPlanInfo({!! json_encode($plan) !!});

    Culqi.publicKey = 'pk_test_xwCI0lmt8MrIT9N1';
    Culqi.init();
    
    $(function(){
        //console.log($info_fact);
        let aux_existe_tarjeta = {!! isset($info_fact->CardId)?'true':'false' !!};
        if(aux_existe_tarjeta)
        {
            billing_page.tarjeta_added = true;
            $('#add-card').css('display','none');
            $('#numero-tarjeta').text('*********'+ {!! $tarjeta->last_four!!} );
            $('#fecha-creacion').text( new Date( ({!!  $tarjeta->creation_date !!}) ));
            $('#card-stored').css('display','block');
            
        }

        console.log(billing_page);
        //console.log($info_fact->CardId);
    });

    $('#frm-agregar-tarjeta').on('submit', function(e) {
        // Crea el objeto Token con Culqi JS
        if($('#card\\[email\\]').val()=='') return;

        $('#btn-agregar-tarjeta').button('loading');
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
                url: '/agregar_tarjeta',
                data: {
                    token: token
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(response){
                    console.log(response);
                    $('#add-card').css('display','none');
                    $('#numero-tarjeta').text('*********'+response.source.last_four);
                    $('#fecha-creacion').text(new Date(response.source.creation_date));
                    $('#card-stored').css('display','block');
                        
                    $('#btn-agregar-tarjeta').button('reset');
                    
                    billing_page.tarjeta_added = true;
                    SePuedePagar();
                    console.log();
                }
            });
        } else { // ¡Hubo algún problema!
            // Mostramos JSON de objeto error en consola
            console.log(Culqi.error);
            alert(Culqi.error.user_message);
        }
    };
    
</script>
@endsection