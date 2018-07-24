$(function(){
	listarAlmacenes();
	listarAreaProd();
});

$(function() {
  /* Formulario de Almacen */
  $('#frm-almacen')
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
          var token = $('meta[name="csrf-token"]').attr('content');
            
    cod_alm = $('#cod_alm').val();
    nomb_alm = $('#nomb_alm').val();
    estado_alm = $('#estado_alm').val();
    id_sucursal = $('#id_sucursal').val();

    $.ajax({
      dataType: 'JSON',
      type: 'POST',
      url: '/ajustesCrudAlmacen',
      data: {
          cod_alm: cod_alm,
          nomb_alm: nomb_alm,
          estado_alm: estado_alm,
          id_sucursal: id_sucursal,
          _token : token
      },
      success: function (cod) {
          if(cod == 0){
              toastr.warning('Advertencia, Datos duplicados.');
              return false;
          } else if(cod == 1){
              listarAlmacenes();
              listarAreaProd();
              $('#mdl-almacen').modal('hide');
              toastr.success('Datos registrados, correctamente.');
          } else if(cod == 2) {
              listarAlmacenes();
              listarAreaProd();
              $('#mdl-almacen').modal('hide');
              toastr.success('Datos modificados, correctamente.');
          }
      },
      error: function(jqXHR, textStatus, errorThrown){
          console.log(errorThrown + ' ' + textStatus);
      }   
    });
  	return false;
  });

  /* Formulario de area de produccion */
  $('#frm-areaprod')
  .formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
    }
    })
  .on('success.form.fv', function(e) {
    if ($('#id_almacen_g').val().trim() === '') {
      toastr.warning('Seleccione un almac&eacute;n!');
      $('.btn-guardar').removeAttr('disabled');
      $('.btn-guardar').removeClass('disabled');
      return false;

    } else {

    e.preventDefault();
    var token = $('meta[name="csrf-token"]').attr('content');
    var $form = $(e.target),
    fv = $form.data('formValidation');
            
    cod_area = $('#cod_area').val();
    cod_alma = $('#id_almacen_g').val();
    nomb_area = $('#nomb_area').val();
    estado_area = $('#estado_area').val();

      $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '/ajustesCrudAreaP',
        data: {
            cod_area: cod_area,
            cod_alma: cod_alma,
            nomb_area: nomb_area,
            estado_area: estado_area,
            _token : token
        },
        success: function (cod) {
            if(cod == 0){
                toastr.warning('Advertencia, Datos duplicados.');
                return false;
            } else if(cod == 1){
                listarAreaProd();
                $('#mdl-areaprod').modal('hide');
                toastr.success('Datos registrados, correctamente.');
            } else if(cod == 2) {
                listarAreaProd();
                $('#mdl-areaprod').modal('hide');
                toastr.success('Datos modificados, correctamente.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
      });
    	return false;
    }
  });
});

/* Mostrar datos en la tabla Almacen */
var listarAlmacenes = function(){
    var token = $('meta[name="csrf-token"]').attr('content');
	var table = $('#table-alm')
	.DataTable({
	  "destroy": true,
    "responsive": true,
    "dom": "ftp",
    "bSort": false,
    "ajax":{
      "method": "POST",
      "url": "/ajustesListaAlmacen",
        "dataSrc" : "",
        headers: {
            'X-CSRF-TOKEN': token
        }
    },
	  "columns":[
	    {"data":"nombre"},
        {"data":"nombre_sucursal"},
	    {"data":null,"render": function ( data, type, row) {
	      if(data.estado == 'a'){
	        return '<span class="label label-primary">ACTIVO</span>';
	      } else if (data.estado == 'i'){
	        return '<span class="label label-danger">INACTIVO</span>'
	      }
	    }},
      {"data":null,"render": function ( data, type, row) {
         return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editar_alm('+data.id_alm+',\''+data.nombre+'\',\''+data.id_sucursal+'\',\''+data.estado+'\');"><i class="fa fa-edit"></i>Editar</button>';
      }}
	  ]
	});
}

/* Mostrar datos en la tabla Area de produccion */
var listarAreaProd = function(){
    var token = $('meta[name="csrf-token"]').attr('content');
	var table = $('#table-area')
	.DataTable({
	  "destroy": true,
    "responsive": true,
    "dom": "ftp",
    "bSort": false,
    "ajax":{
      "method": "POST",
      "url": "/ajustesListaAreasP",
        headers: {
            'X-CSRF-TOKEN': token
        },
      "data": function ( d ) {
         d.codigo = '%'
      }
    },
	  "columns":[
      {"data":"nombre"},
	    {"data":"Almacen.nombre"},
	    {"data":null,"render": function ( data, type, row) {
	      if(data.estado == 'a'){
	        return '<span class="label label-primary">ACTIVO</span>';
	      } else if (data.estado == 'i'){
	        return '<span class="label label-danger">INACTIVO</span>'
	      }
	    }},
      {"data":null,"render": function ( data, type, row) {
         return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editar_area('+data.id_areap+','+data.id_alm+');"><i class="fa fa-edit"></i>Editar</button>';
      }}
	  ]
	});
}

/* Combo almacen */
var comboAlmacen = function(){
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/ajustesComboAlm",
        data: {
            _token : token
        },
        success: function (response) {
            $('#combo_alm').html(response);
            $('#cod_alma').selectpicker();
        },
        error: function () {
            $('#combo_alm').html('There was an error!');
        }
    });
}

/* Editar Almacen */
var editar_alm = function(cod,nomb,sucur,est){
	$('#cod_alm').val(cod);
	$('#nomb_alm').val(nomb);
    $('#id_sucursal').selectpicker('val', sucur);
	$('#estado_alm').selectpicker('val', est);
	$('#title-alm').text('Editar Almacén');
    $('#mdl-almacen').modal('show');
}

/* Editar Area de produccion */
var editar_area = function(cod){
    var token = $('meta[name="csrf-token"]').attr('content');
    //comboAlmacen();
    $.ajax({
      type: "POST",
      url: "/ajustesListaAreasP",
      data: {
          codigo: cod,
          _token : token
      },
      dataType: "json",
      success: function(item){
        $.each(item.data, function(i, campo) {
            $('#cod_area').val(campo.id_areap);
            $('#nomb_area').val(campo.nombre);
            $('#estado_area').selectpicker('val', campo.estado);
            $('#cod_alma').selectpicker('val', campo.id_alm);
            $('#id_almacen_g').selectpicker('val', campo.id_alm);
            $('#title-area').text('Editar Área de producción');
            $('#mdl-areaprod').modal('show');
        });
      }
    });
}

/* Boton nuevo almacen */
$('.btn-alm').click( function() {
    $('#cod_alm').val('');
    $('#title-alm').text('Nuevo Almacén');
    $('#mdl-almacen').modal('show');
});

/* Boton nueva area de produccion */
$('.btn-area').click( function() {
    $('#cod_area').val('');
    $('#title-area').text('Nueva Área de producción');
    comboAlmacen();
    $('#mdl-areaprod').modal('show');
});

$('#mdl-almacen').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-almacen').formValidation('resetForm', true);
    $('#estado_alm').selectpicker('val', 'a');
    $('#id_sucursal').selectpicker('val', '');
});

$('#mdl-areaprod').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-areaprod').formValidation('resetForm', true);
    $('#estado_area').selectpicker('val', 'a');
});