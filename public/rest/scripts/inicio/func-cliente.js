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
});

/* Nuevo Cliente */
var nuevoCliente = function(){
    $('#mdl-facturar').modal('hide');
    $('#mdl-nuevo-cliente').modal('show');
}

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

		if(dni.length == 8 || ruc.length == 11){
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
						direccion:direccion
                },
                dataSrc:'',   
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				url: '/inicio/NuevoCliente',
				success: function(datos){
					if(datos == 1){
						toastr.warning('Advertencia, Clientes duplicados.');
					}else {
						$('#mdl-nuevo-cliente').modal('hide');
						$('#mdl-facturar').modal('show');
						var tipoCliente = $('input:radio[name=tipo_docc]:checked').val();
						if( tipoCliente == 1){
                            $('#cliente_id').val(dni);
                            $("#nombre_c").val(nombres);
						} else{
                            $('#cliente_id').val(ruc);
                            $("#nombre_c").val(razon_social);
						}
                        toastr.success('Datos registrados, correctamente.');
					}
				}
			});
		}else{
			toastr.warning('Advertencia, Ingresar datos.');
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