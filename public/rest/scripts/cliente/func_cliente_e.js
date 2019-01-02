$(function() {
    $('input:radio[id=td_dni]').on('ifChecked', function(event){
        $("#f_dni").css("display","block");
        $("#f_ruc").css("display","none");
        $("#d_ruc").css("display","none");
        $("#d_rs").css("display","none");
        $("#d_nombres").css("display","block");
        $("#d_apep").css("display","block");
        $("#d_apem").css("display","block");
        $("#d_fecha").css("display","block");
        $("#d_telefono").css("display","block");
        $("#d_correo").css("display","block");
    });

    $('input:radio[id=td_ruc]').on('ifChecked', function(event){
        $("#f_dni").css("display","none");
        $("#f_ruc").css("display","block");
        $("#d_ruc").css("display","block");
        $("#d_rs").css("display","block");
        $("#d_nombres").css("display","none");
        $("#d_apep").css("display","none");
        $("#d_apem").css("display","none");
        $("#d_fecha").css("display","none");
        $("#d_telefono").css("display","none");
        $("#d_correo").css("display","none");
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
        $.getJSON("https://py-devs.com/api/ruc/" + $("#ruc_numero").val(), {
                format: "json"
            })
            .done(function(data) {
                $("#dni").val(data.numero_documento);
                $("#ruc").val(data.ruc);
                $("#razon_social").val(data.nombre);
                $("#direccion").val(data.domicilio_fiscal);
            });
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