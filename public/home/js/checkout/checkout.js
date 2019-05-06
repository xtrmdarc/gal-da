
let plan_billing =[];
let billing_page = {};

$(function(){

    $('#btn-pagar').prop('disabled',true);
    $('#wrapper-btn-pagar').popover({
        trigger: 'hover',
        html: true,
        content : `<span style="color:black">Confirma la información de facturación y agrega un método de pago</span>`,
        placement: 'top',
        //delay: {show: 0, hide: 3000}
    });
    //$('#btn-pagar').popover('show');
});

//Pagar 
$('#btn-pagar').click(function(){
    $('#btn-pagar').button('loading');
    $.ajax({
        url:'/pagar_subscripcion',
        dataType : 'JSON',
        type: 'POST',
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            plan_id: $('#plan-id').val()
        },
        success: function(response){
            
            // alert('se creo la subscripción exitosamente');
            $('#btn-pagar').button('reset');
            if(response.cod == 1)
            {
                window.location.replace('/payment_completed/'+response.plan_id);
            }
            else alert('Error. Contáctese con el administrador.');
        },
        error:function(e){
            console.log(e);
            $('#btn-pagar').button('reset');
        }
    });

});

//Editar la tarjeta
$('#btn-editar-tarjeta').click(function(){

    $('#btn-cancelar-editar').css('display','block'); 
    $('#card-stored').css('display','none');
    $('#add-card').css('display','block');
    
});

$('#btn-cancelar-editar').click(function(){

    $('#card-stored').css('display','block');
    $('#add-card').css('display','none');
    
});

//Cambiar de periodo mensual o anual
$('.btn-plan-periodo').click(function(e){

    $btn = $(e.target);
    
    $('.btn-plan-periodo').addClass('btn-inactive');
    $btn.removeClass('btn-inactive');

    let id_periodo = $btn.attr('period');
    console.log(id_periodo,plan_billing.precio_mensual);
    
    let plan_mensual = plan_billing.find(p=> p.id_periodicidad == 1);
    let plan_anual = plan_billing.find(p=> p.id_periodicidad == 2);
    $('#precio_mensual_regular').text('$ '+plan_mensual.precio);
    
    if(id_periodo == 1)
    {    
        $('#precio_mensual_actual').text('$ '+(parseFloat(plan_mensual.precio)).toFixed(2) );
        $('#precio_total').text('$ '+ (parseFloat(plan_mensual.precio)).toFixed(2));
        $('#automatic-payment').text('$'+ (parseFloat(plan_mensual.precio)).toFixed(2) + ' cada mes');
        $('#btn-pagar').text('Pagar $'+ (parseFloat(plan_mensual.precio)).toFixed(2));
        
        //plan_billing.es_anual = 0;
    }
    else if(id_periodo == 12 )
    {
        $('#precio_mensual_actual').text('$ '+( parseFloat(plan_anual.precio)/12).toFixed(2));
        $('#precio_total').text('$ '+parseFloat(plan_anual.precio).toFixed(2));
        $('#automatic-payment').text('$'+ (parseFloat(plan_anual.precio)).toFixed(2)+ ' cada año');
        $('#btn-pagar').text('Pagar $'+ (parseFloat(plan_anual.precio)).toFixed(2));
        //plan_billing.es_anual = 1;
    }
    
    
    
});

//verifica si puede pagar 
function SePuedePagar(){
    
    if(billing_page.tarjeta_added == true && billing_page.info_added == true)
    {
        $('#btn-pagar').prop('disabled',false);
        $('#wrapper-btn-pagar').popover('dispose');
    }
}

function GetPlanInfo(planes){
    
    planes.forEach(plan => {
        plan_billing.push(plan);
    });
    // plan_billing.nombre = plan.nombre;
    // plan_billing.precio_mensual = plan.precio_mensual;
    // plan_billing.precio_anual = plan.precio_anual;
    
}

function GetCardType(number)
{
    let tarjeta = {};
    
    // visa
    var re = new RegExp("^4");
    if (number.match(re) != null)
    {   
        tarjeta.nombre = "Visa";
        tarjeta.logo = "visa_logo.png";
        return tarjeta;
    }

    // Mastercard 
    // Updated for Mastercard 2017 BINs expansion
    if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)) 
    {   
        tarjeta.nombre = "Mastercard";
        tarjeta.logo = "mastercard_logo.png";
        return tarjeta;
    }
    
    

    // AMEX
    re = new RegExp("^3[47]");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "American Express";
        tarjeta.logo = "amex_logo.png";
        return tarjeta;
    }
        

    // Discover
    // re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
    // if (number.match(re) != null)
    //     return "Discover";

    // Diners
    re = new RegExp("^36");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Diners";
        tarjeta.logo = "diners_logo.png";
        return tarjeta;
    }
    

    // Diners - Carte Blanche
    re = new RegExp("^30[0-5]");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Diners - Carte Blanche";
        tarjeta.logo = "diners_logo.png";
        return tarjeta;
    }
        
    // JCB
    // re = new RegExp("^35(2[89]|[3-8][0-9])");
    // if (number.match(re) != null)
    //     return "JCB";

    // Visa Electron
    re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Visa electron";
        tarjeta.logo = "visa_logo.png";
        return tarjeta;
    }
    tarjeta.nombre = "";
    tarjeta.logo = "";
    
    return tarjeta;
}

$('.credit-card').keyup(event,function(){
    re = new RegExp("[0-9]");
    // if(!($(event.target).val()).match(re))
    //     return;
    
    var tarjeta = GetCardType($(event.target).val() );
    
    if(tarjeta.nombre)
        $(event.target).css('background','#fff url(/home/images/icons/'+tarjeta.logo+') no-repeat right ');
    else $(event.target).css('background','none');

    $(event.target).css('background-size','48px');
    $(event.target).css('background-position','99%');
});


$('#btn-confirmar-billing-info').on('click',function(){

    var $this = $(this);

    

    // setTimeout(function() {
    //      $this.button('reset');
    // }, 8000);

   var  direccion ='' , 
        ciudad ='',
        pais ='',
        email ='',
        nombre ='',
        apellido ='',
        telefono ='',
        es_empresarial ='',
        razon_social ='',
        ruc='';
    
    //Obtener variables
    let errores = 0;
    es_empresarial = $('#ul_empresarial li.active').attr('empr');
    if(es_empresarial ==1)
    {
        let empresa_inputs = [$('#emp_dir'),$('#emp_ciudad'),$('#emp_pais'),$('#emp_email')
                                ,$('#emp_nomb'),$('#emp_apell'),$('#emp_telef'),$('#razon_social')
                                ,$('#ruc')
                            ];
        
        empresa_inputs.forEach(input => {
            if(!input.val())
            {
                input.after('<p style="color:red;"> Este campo es obligatorio </p>');
                errores = 1;
                return;
            }
        });
        if(errores==1) return;
        direccion = $('#emp_dir').val();
        ciudad = $('#emp_ciudad').val();
        pais = $('#emp_pais').val();
        email = $('#emp_email').val();
        nombre = $('#emp_nomb').val();
        apellido = $('#emp_apell').val();
        telefono = $('#emp_telef').val();
        razon_social = $('#razon_social').val();
        ruc = $('#ruc').val();

    }
    else
    {
        let empresa_inputs = [$('#prop_dir'),$('#prop_ciudad'),$('#prop_pais'),$('#prop_email')
                                ,$('#prop_nomb'),$('#prop_apell'),$('#prop_telef')
                            ];

        empresa_inputs.forEach(input => {
            if(!input.val())
            {
                errores =1;
                input.after('<p style="color:red"> Este campo es obligatorio </p>');
                return;
            }
        });

        
        direccion = $('#prop_dir').val();
        ciudad = $('#prop_ciudad').val();
        pais = $('#prop_pais').val();
        email = $('#prop_email').val();
        nombre = $('#prop_nomb').val();
        apellido = $('#prop_apell').val();
        telefono = $('#prop_telef').val();

        if(/\d/.test(nombre))
        {
            $('#prop_nomb').after('<p style="color:red"> Este campo no puede contener números.</p>');
            return ;
        }
        else if(/\d/.test(apellido))
        {
            $('#prop_apell').after('<p style="color:red"> Este campo no puede contener números.</p>');
            return;
        }
        if(errores==1) return;
    }

    $('#ul_empresarial')
    $this.button('loading');
    $.ajax({
        url:'/ConfirmarInfoFact',
        type:'POST',
        dataType:'json',
        headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        data:{
            direccion : direccion,
            ciudad : ciudad ,
            pais : pais,
            email : email ,
            nombre : nombre ,
            apellido : apellido ,
            telefono : telefono ,
            es_empresarial : es_empresarial ,
            razon_social : razon_social,
            ruc : ruc 
        },
        success: function(response){
            $('#btn-confirmar-billing-info').button('reset');
            $('#card\\[email\\]').val(response.email);
            console.log(response.email,$('#card\\[email\\]').val());
            if(response.status == 1)
            {
                $('.empresarial-div-sum').css('display','none');
                

                if(response.es_empresarial == 1)
                {
                    $('#sum_razon_social').text(response.razon_social);
                    $('#sum_ruc').text(response.ruc);
                    $('.empresarial-div-sum').css('display','block');
                }
                $('#sum_nomb').text(response.nombre);
                $('#sum_apell').text(response.apell);
                $('#sum_pais').text(response.pais);
                $('#sum_ciudad').text(response.ciudad);
                $('#sum_dir').text(response.direccion);
                
                $('#div_billing_form').collapse('hide');
                $('#summary_billing_info').css('display','block');

                $('#div_card_info').collapse('show');
                billing_page.info_added = true;

                SePuedePagar();
            }
        }
    });

});

