$(function() {
    $('#dni').prop('required',true);
    $('#nombres').prop('required',true);
    //$('#dni').prop('required',true);

    $('#ruc').removeAttr('required');
    $('#razon_social').removeAttr('required');
    $('input:radio[id=td_dni]').on('ifChecked', function(event){
        $("#f_dni").css("display","block");
        $("#d_dni").css("display","block");
        $("#f_ruc").css("display","none");
        $("#d_ruc").css("display","none");
        $("#d_rs").css("display","none");
        $("#d_nombres").css("display","block");
        $("#d_apep").css("display","block");
        $("#d_apem").css("display","block");
        $("#d_fecha").css("display","block");
        $("#d_telefono").css("display","block");
        $("#d_correo").css("display","block");
        $('#tipo_cliente').val(1);
        
        $('#dni').prop('required',true);
        $('#nombres').prop('required',true);
        //$('#dni').prop('required',true);

        $('#ruc').removeAttr('required');
        $('#razon_social').removeAttr('required');
        
    });

    $('input:radio[id=td_ruc]').on('ifChecked', function(event){
        $("#f_dni").css("display","none");
        $("#d_dni").css("display","none");
        $("#f_ruc").css("display","block");
        $("#d_ruc").css("display","block");
        $("#d_rs").css("display","block");
        $("#d_nombres").css("display","none");
        $("#d_apep").css("display","none");
        $("#d_apem").css("display","none");
        $("#d_fecha").css("display","none");
        $("#d_telefono").css("display","none");
        $("#d_correo").css("display","none");
        $('#tipo_cliente').val(2);

        $('#ruc').prop('required',true);
        $('#razon_social').prop('required',true);

        $('#dni').removeAttr('required');
        $('#nombres').removeAttr('required');

        
    });

    /* Consultar dni del nuevo cliente */
    $("#frm-consulta-dni").submit(function(event) {
        event.preventDefault();
        
        $.getJSON("https://py-devs.com/api/dni/" + $("#dni_numero").val(), {
                format: "json"
            })
            .done(function(data) {
                $("#dni").val(data.dni);
                $("#nombres").val(data.nombres);
                $("#ape_paterno").val(data.ape_paterno);
                $("#ape_materno").val(data.ape_materno);
            });
    });

    /* Consultar ruc del nuevo cliente */
    $("#frm-consulta-ruc").submit(function(event) {
        
        event.preventDefault();
        let id_pais = $('#id_pais').val();
        console.log(id_pais);   
        // if(id_pais == 'PE')
        // {
            $.getJSON("https://api.sunat.cloud/ruc/" + $("#ruc_numero").val(), {
                format: "json"
            })
            .done(function(data) {
                console.log(data);
                $("#dni").val(data.numero_documento);
                $("#ruc").val(data.ruc);
                $("#razon_social").val(data.nombre);
                $("#direccion").val(data.domicilio_fiscal);
            });
        // }
       
    });
    
    $('.DatePicker')
        .datepicker({
        format: 'dd-mm-yyyy'
    });
});

$(".let input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[A-ZÁÉÍÓÚÑ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
        alert ("Mayusuclas");
    }
});

$(".letnum input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9A-ZÁÉÍÓÚÑ/ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".ent input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9]')!=0 && keycode!=8){
        return false;
    }
});

$('input[name=tipo_doc]').on('change',function(e){
    
    let rb = $(e.target);
    if(rb.val() == 1)
    {
        $('#div_dni').css('display','block');
        $('#div_ruc').css('display','none');
    }
    else{
        $('#div_dni').css('display','none');
        $('#div_ruc').css('display','block');
    }

   

});


$('#form-guardar-cliente').on('submit',function(e){

    e.preventDefault();
    let form = $(e.target);
    let btn = $('#btn-guardar-cliente');
    btn.prop('disabled',true);


    $.ajax({
        type:'POST',
        dataType: 'JSON',
        url: form.attr('action'),
        data: form.serialize(),
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            btn.prop('disabled',false);
            if(response.code == 0)
            {
                toastr.warning(response.message);
            }
            else if(response.code == 1 )
            {
                window.location.replace('/cliente');
                toastr.success(response.message);                
            }
        }
    });

});