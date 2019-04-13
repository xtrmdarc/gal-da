$(function() {
	$('.scroll_content').slimscroll({
        height: '210px'
    });
    $('input[type="radio"].flat-red').iCheck({
      radioClass: 'iradio_square-blue'
    });
    $("#correo").emailautocomplete({
    domains: [
        "gmail.com",
        "yahoo.com",
        "hotmail.com",
        "live.com",
        "facebook.com",
        "outlook.com"
        ]
    });
    // $("#d_fecha").css("display","none");
    // $("#d_fecha").prop('disabled',true);
});

/* Nuevo Cliente */
var nuevoCliente = function(){
    $('#mdl-facturar').modal('hide');
    $('#mdl-nuevo-cliente').modal('show');
    $('#div_dni').css('display','block');
    $('#div_ruc').css('display','none');
}

$('input:radio[id=td_dni]').on('ifChecked', function(event){
    $('#div_dni').css('display','block');
    $('#div_ruc').css('display','none');
    $("#f_dni").css("display","block");
    $("#f_ruc").css("display","none");
    $("#d_ruc").css("display","none");
    $("#d_rs").css("display","none");
    $("#d_nombres").css("display","block");
    $("#d_apep").css("display","block");
    $("#d_apem").css("display","block");

    // $("#d_fecha").css("display","none");
    // $("#d_fecha").prop('disabled',true);
    $('#dni').prop('required',true);
    $('#nombres').prop('required',true);
    //$('#dni').prop('required',true);

    $('#ruc').removeAttr('required');
    $('#razon_social').removeAttr('required');

});

$('input:radio[id=td_ruc]').on('ifChecked', function(event){
    $('#div_dni').css('display','none');
    $('#div_ruc').css('display','block');
    $("#f_dni").css("display","none");
    $("#f_ruc").css("display","block");
    $("#d_ruc").css("display","block");
    $("#d_rs").css("display","block");
    $("#d_nombres").css("display","none");
    $("#d_apep").css("display","none");
    $("#d_apem").css("display","none");

    // $("#d_fecha").css("display","none");
    // $("#d_fecha").prop('disabled',true);

    $('#ruc').removeAttr('required');
    $('#razon_social').removeAttr('required');

    $("#d_telefono").css("display","block");
    $("#d_correo").css("display","block");

    $("#d_telefono").css("display","none");
    $("#d_correo").css("display","none");
});

$("#form_consultadni").submit(function(event) {
    event.preventDefault();
    $.getJSON("http://py-devs.com/api/dni/last" + $("#dni_numero").val(), {
            format: "json"
        })
        .done(function(data) {
            $("#dni").val(data.dni);
            $("#nombres").val(data.nombres);
            $("#ape_paterno").val(data.ape_paterno);
            $("#ape_materno").val(data.ape_materno);
        });
});

$("#form_consultaruc").submit(function(event) {
    event.preventDefault();
    $.getJSON("http://py-devs.com/api/ruc/last" + $("#ruc_numero").val(), {
            format: "json"
        })
        .done(function(data) {
            $("#dni").val(data.numero_documento);
            $("#ruc").val(data.ruc);
            $("#razon_social").val(data.nombre);
            $("#direccion").val(data.domicilio_fiscal);
        });
});

$('#RegistrarCliente').on('click', function(){

		var ruc = $('#ruc').val();
		var dni = $('#dni').val();
		var nombres = $('#nombres').val();
		var ape_paterno = $('#ape_paterno').val();
		var ape_materno = $('#ape_materno').val();
		var fecha_nac = $('#fecha_nac').val();
		var telefono = $('#telefono').val();
		var correo = $('#correo').val();
		var razon_social = $('#razon_social').val();
		var direccion = $('#direccion').val();
        var tipoCliente = $('input:radio[name=tipo_docc]:checked').val();

        
		if(dni.length <= 15 || ruc.length <= 20){
                    
            let btn_guardar = $('#RegistrarCliente');
            btn_guardar.prop('disabled',true);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
						ruc:ruc,
						dni:dni,
						nombres:nombres,
						ape_paterno:ape_paterno,
						ape_materno:ape_materno,
						fecha_nac:fecha_nac,
						telefono:telefono,
						correo:correo,
						razon_social:razon_social,
                        direccion:direccion,
                        tipoCliente:tipoCliente
                },
                dataSrc:'',   
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				url: '/inicio/NuevoCliente',
				success: function(respuesta){
                    btn_guardar.prop('disabled',false);

					if(respuesta.dup > 0){
						toastr.warning('Advertencia, Clientes duplicados.');
					}else {
						$('#mdl-nuevo-cliente').modal('hide');
						$('#mdl-facturar').modal('show');
                        var tipoCliente = $('input:radio[name=tipo_docc]:checked').val();
                        $('#cliente_id').val(respuesta.id_cliente);
						if( tipoCliente == 1){
                            $("#nombre_c").val(nombres);
						} else{
                            $("#nombre_c").val(razon_social);
						}
                        toastr.success('Datos registrados, correctamente.');
					}
				}
			});
		}else{
			toastr.warning('Advertencia, Ingresar datos válidos');
            return false;
		}
});

$('#mdl-nuevo-cliente').on('hidden.bs.modal', function() {
		$('#dni_numero').val('');
		$('#ruc_numero').val('');
		$("#td_dni").iCheck('check');
    $(this).find('#form_c')[0].reset();
    $('#mdl-facturar').modal('show');
});
