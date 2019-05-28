/* Nuevo Proveedor */
var nuevoProveedor = function(){
    $('#mdl-nuevo-proveedor').modal('show');
}

/* Consultar ruc del nuevo proveedor */
$("#frm-consulta-ruc").submit(function(event) {
    event.preventDefault();
    $.getJSON("http://py-devs.com/api/ruc/" + $("#ruc_numero").val(), {
            format: "json"
        })
        .done(function(data) {
            $("#dni").val(data.numero_documento);
            $("#ruc").val(data.ruc);
            $("#razon_social").val(data.nombre);
            $("#direccion").val(data.domicilio_fiscal);
        });
});


$('#RegistrarProveedor').on('click', function(){

		var ruc = $('#ruc').val(),
				razon_social = $('#razon_social').val(),
				direccion = $('#direccion').val(),
				telefono = $('#telefono').val(),
				email = $('#email').val(),
				contacto = $('#contacto').val();

		if(ruc.length == 11){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
						ruc:ruc,
						razon_social:razon_social,
						direccion:direccion,
						telefono:telefono,
						email:email,
						contacto:contacto
				},
				url: 'NuevoProv',
				dataSrc:'',   
            	headers:{
                	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            	},
				success: function(data){

					switch(data.type)
					{
						case 'warning' : {toastr.warning(data.message); break;}
						case 'success':{toastr.success(data.message);$('#mdl-nuevo-proveedor').modal('hide'); break;}
					}
					// if(data == 1){
					// 	toastr.warning('Advertencia, Datos duplicados.');
					// }else if(datos != 'existe'){
					// 	toastr.success('Datos registrados, correctamente.');
						
					// }
				}
			});
		}else{
			toastr.warning('Advertencia, Ingresar datos.');
      return false;
		}
});

$('#mdl-nuevo-proveedor').on('hidden.bs.modal', function() {
	
		$('#ruc_numero').val('');
    	$(this).find('#form_p')[0].reset();
});