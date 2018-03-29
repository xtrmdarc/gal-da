$(function(){
    listarCajas();
});

$(function() {
    $('#frm-caja')
    .formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
        }
    })
    .on('success.form.fv', function(e) {

    e.preventDefault();
    var $form = $(e.target),
    fv = $form.data('formValidation');
            
    cod_caja = $('#cod_caja').val();
    nomb_caja = $('#nomb_caja').val();
    estado_caja = $('#estado_caja').val();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '?c=Config&a=CrudCaja',
        data: {
            cod_caja: cod_caja,
            nomb_caja: nomb_caja,
            estado_caja: estado_caja
        },
        success: function (cod) {
            if(cod == 0){
                toastr.warning('Advertencia, Datos duplicados.');
                return false;
            } else if(cod == 1){
                listarCajas();
                $('#mdl-caja').modal('hide');
                toastr.success('Datos registrados, correctamente.');
            } else if(cod == 2) {
                listarCajas();
                $('#mdl-caja').modal('hide');
                toastr.success('Datos modificados, correctamente.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }    
    });
        return false;
    });
});

/* Mostrar datos en la tabla caja */
var listarCajas = function(){

    var token = $('meta[name="csrf-token"]').attr('content');
	var table = $('#table-caja')
	.DataTable({
	  "destroy": true,
    "responsive": true,
    "dom": "ftp",
    "bSort": false,
    "ajax":{
      "method": "POST",
      "url": "/ajustesListaCaja",
        headers: {
            'X-CSRF-TOKEN': token
        }
      /*
      "beforeSend": function (request) {
        $('#loader').css('display','none');
      }
      */
    },
	  "columns":[
	    {"data":"descripcion"},
	    {"data":null,"render": function ( data, type, row) {
	      if(data.estado == 'a'){
	        return '<span class="label label-primary">ACTIVA</span>';
	      } else if (data.estado == 'i'){
	        return '<span class="label label-danger">INACTIVA</span>'
	      }
	    }},
      {"data":null,"render": function ( data, type, row) {
         return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.estado+'\');"><i class="fa fa-edit"></i>Editar</button>';
      }}
	  ]
	});
}

/* Editar caja */
var editarCaja = function(cod,nomb,est){
	$('#cod_caja').val(cod);
	$('#nomb_caja').val(nomb);
	$('#estado_caja').selectpicker('val', est);
	$('#title-caja').text('Editar Caja');
  $('#mdl-caja').modal('show');
}

/* Boton nueva caja */
$('.btn-caja').click( function() {
  $('#cod_caja').val('');
  $('#title-caja').text('Nueva Caja');
  $('#mdl-caja').modal('show');
});

$('#mdl-caja').on('hidden.bs.modal', function() {
  $(this).find('form')[0].reset();
	$('#frm-caja').formValidation('resetForm', true);
  $('#estado_caja').selectpicker('val', 'a');
});