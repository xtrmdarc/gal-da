$(function() {
    listarSalones();
});

/* Mostrar datos en la tabla salones */
var listarSalones = function(){
    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table-s')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/ajustesListaSalones",
            "dataSrc" : "",
            headers: {
                'X-CSRF-TOKEN': token
            }
        },
        "columns":[
            {"data":"descripcion"},
            {"data":"Mesas.total"},
            {"data":null,"render": function ( data, type, row) {
                if(data.estado == 'a'){
                  return '<span class="label label-primary">ACTIVO</span>';
                } else if (data.estado == 'i'){
                  return '<span class="label label-danger">INACTIVO</span>';
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<div class="text-right"><button class="btn btn-info btn-xs" onclick="listarMesas('+data.id_catg+',\''+data.descripcion+'\');"> Ver </button>'
                +'&nbsp;<button class="btn btn-success btn-xs" onclick="editarSalon('+data.id_catg+',\''+data.estado+'\',\''+data.descripcion+'\');"> <i class="fa fa-edit"></i> Editar </button>'
                +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarSalon('+data.id_catg+',\''+data.descripcion+'\');"> <i class="fa fa-trash"></i></button></div>';
            }}
        ]
    });
}

/* Mostrar datos en la tabla mesas */
var listarMesas = function(cod_sal,desc_sal){
    var token = $('meta[name="csrf-token"]').attr('content');
    var mesaNueva = '';
    /* Ocultar panel mensaje 'seleccione un salon' */
    $('#lizq-s').css("display","none");
    /* Mostrar tabla mesas por salon */
    $('#lizq-i').css("display","block");
    $('#btn-nuevo').html('<button type="button" class="btn btn-primary" onclick="editarMesa('+mesaNueva+');"><i class="fa fa-plus-circle"></i> Nueva Mesa</button>');
    $('#id_catg').val(cod_sal);
    $('#title-mesa').text(desc_sal);
    var table = $('#table-m')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/ajustesListaMesas",
            "dataSrc" : "",
            headers: {
                'X-CSRF-TOKEN': token
            },
            "data": function ( d ) {
              d.cod = cod_sal;
          }
        },
        "columns":[
            {"data":null,"render": function ( data, type, row) {
                return '<i class="fa fa-square"></i> '+data.nro_mesa;
            }},
            {"data":"Salon.descripcion"},
            {"data":null,"render": function ( data, type, row) {
                if(data.estado == 'a'){
                  return '<a onclick="estadoMesa('+data.id_mesa+');"><span class="label label-primary">ACTIVA</span></a>';
                } else if (data.estado == 'i' || data.estado == 'p'){
                  return '<span class="label label-warning">OCUPADA</span>'
                }
                else if (data.estado == 'm'){
                  return '<a onclick="estadoMesa('+data.id_mesa+');"><span class="label label-danger">INACTIVA</span></a>'
                } 
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarMesa('+data.id_mesa+',\''+data.nro_mesa+'\');"> <i class="fa fa-edit"></i> Editar </button>'
                +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarMesa('+data.id_mesa+',\''+data.nro_mesa+'\');"> <i class="fa fa-trash"></i> Eliminar </button></div>';
            }}
        ]
    });
}

/* Editar datos del salon */
var editarSalon = function(cod,est,nomb){
  $('#cod_sala').val(cod);
  $('#desc_sala').val(nomb);
  $('#est_salon').selectpicker('val', est);    
  $("#mdl-salon").modal('show');
}

/* Eliminar salon */
var eliminarSalon = function(cod,nomb){
  $('#cod_salae').val(cod);
  $("#mensaje-es").html("<center><h4>¿Desea eliminar "+ nomb +"?</h4></center>");          
  $("#mdl-eliminar-salon").modal('show');
}

/* Editar datos de la mesa*/
var editarMesa = function(cod,nomb){
  $('#cod_mesa').val(cod);
  $('#nro_mesa').val(nomb);     
  $("#mdl-mesa").modal('show');
}

/* Eliminar mesa */
var eliminarMesa = function(cod,nomb){
  $('#cod_mesae').val(cod);
  $("#mensaje-em").html("<center><h4>¿Desea eliminar la Mesa "+ nomb +"?</h4></center>");          
  $("#mdl-eliminar-mesa").modal('show');
}

/*  Modificar estado de la mesa para mostrar o no mostrar en el modulo restaurante */
var estadoMesa = function(cod){
  $('#codi_mesa').val(cod);  
  $("#mdl-estado-mesa").modal('show');
}

$(function() {
    $('#frm-salon')
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
          var form = $(this);

          var salones = {
            cod_sala: 0,
            desc_sala: 0,
            est_salon: 0
          }

          salones.cod_sala = $('#cod_sala').val();
          salones.desc_sala = $('#desc_sala').val();
          salones.est_salon = $('#est_salon').val();

          $.ajax({
              dataType: 'JSON',
              type: 'POST',
              url: form.attr('action'),
              data: salones,
              _token : token,
              success: function (cod) {
                  if(cod == 0){
                      toastr.warning('Advertencia, Datos duplicados.');
                      return false;
                  } else if(cod == 1){
                      listarSalones();
                      $('#mdl-salon').modal('hide');
                      $('#title-mesa').text(salones.desc_sala);
                      $('#table-m tbody').remove();
                      /* Mostrar panel mensaje 'seleccione un salon' */
                      $('#lizq-s').css("display","block");
                      /* Ocultar tabla mesas */
                      $('#lizq-i').css("display","none");
                      toastr.success('Datos registrados, correctamente.');
                  } else if(cod == 2) {
                      listarSalones();
                      $('#mdl-salon').modal('hide');
                      $('#title-mesa').text(salones.desc_sala);
                      $('#table-m tbody').remove();
                      /* Mostrar panel mensaje 'seleccione un salon' */
                      $('#lizq-s').css("display","block");
                      /* Ocultar tabla mesas */
                      $('#lizq-i').css("display","none");
                      toastr.success('Datos modificados, correctamente.');
                  }
              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(errorThrown + ' ' + textStatus);
              }   
          });

        return false;

      });

    $('#frm-mesa')
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
          
          var form = $(this);

          var mesas = {
            cod_mesa: 0,
            id_catg: 0,
            nro_mesa: 0
          }

          mesas.cod_mesa = $('#cod_mesa').val();
          mesas.id_catg = $('#id_catg').val();
          mesas.nro_mesa = $('#nro_mesa').val();

          $.ajax({
              dataType: 'JSON',
              type: 'POST',
              url: form.attr('action'),
              data: mesas,
              success: function (cod) {
                  if(cod == 0){
                      toastr.warning('Advertencia, Datos duplicados.');
                      return false;
                  } else if(cod == 1){
                      $('#mdl-mesa').modal('hide');
                      listarSalones();
                      listarMesas(mesas.id_catg);
                      toastr.success('Datos registrados, correctamente.');
                  } else if(cod == 2) {
                      $('#mdl-mesa').modal('hide');
                      listarSalones();
                      listarMesas(mesas.id_catg);
                      toastr.success('Datos modificados, correctamente.');
                  }
              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(errorThrown + ' ' + textStatus);
              }   
          });

        return false;

      });

    $('#frm-estado-mesa')
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
          
          var form = $(this);

          var emesa = {
            codi_mesa: 0,
            est_mesa: 0,
          }

          emesa.codi_mesa = $('#codi_mesa').val();
          emesa.est_mesa = $('#est_mesa').val();

          $.ajax({
              dataType: 'JSON',
              type: 'POST',
              url: form.attr('action'),
              data: emesa,
              success: function (datos) {
                  toastr.success('Datos modificados, correctamente.');
                  $('#mdl-estado-mesa').modal('hide');
                  listarSalones();
                  listarMesas($('#id_catg').val());
              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(errorThrown + ' ' + textStatus);
              }   
          });

        return false;

      });
});

$("#frm-eliminar-salon").submit(function(){

  var form = $(this);

    var salon = {
        cod_salae: 0
    }

    salon.cod_salae = $('#cod_salae').val();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: form.attr('action'),
        data: salon,
        success: function (cod) {
            if(cod == 1){
                listarSalones();
                $('#mdl-eliminar-salon').modal('hide');
                $('#table-m tbody').remove();
                $('#lizq-s').css("display","block");
                $('#lizq-i').css("display","none");
                toastr.success('Datos eliminados, correctamente.');
            } else if(cod == 0){
                $('#mdl-eliminar-salon').modal('hide');
                toastr.warning('Advertencia, El salon no puede ser eliminado.');
                return false;
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });

  return false;
});

$("#frm-eliminar-mesa").submit(function(){

  var form = $(this);

    var mesa = {
        cod_mesae: 0
    }

    mesa.cod_mesae = $('#cod_mesae').val();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: form.attr('action'),
        data: mesa,
        success: function (cod) {
            if(cod == 1){
                var codigoSalon = $('#id_catg').val();
                listarSalones();
                listarMesas(codigoSalon);
                $('#mdl-eliminar-mesa').modal('hide');
                toastr.warning('Advertencia, Datos duplicados.');
            } else if(cod == 0){
                $('#mdl-eliminar-mesa').modal('hide');
                toastr.warning('Advertencia, La mesa no puede ser eliminado.');
                return false;
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });

  return false;
});

$('#mdl-salon').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-salon').formValidation('resetForm', true);
    $("#est_salon").selectpicker('val', 'a');
});

$('#mdl-mesa').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-mesa').formValidation('resetForm', true);
});

$('#mdl-estado-mesa').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-estado-mesa').formValidation('resetForm', true);
    $('#est_mesa').selectpicker('val', '');
});