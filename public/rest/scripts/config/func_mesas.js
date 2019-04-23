var limite_mesas;
$(function() {
    listarSalones();
});

/* Mostrar datos en la tabla salones */
var listarSalones = function(){
    var table = $('#table-s')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/ajustesListaSalones",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        "columns":[
            {"data":"descripcion"},
            {"data":"Mesas.total"},
            {"data":"nombre_sucursal"},
            {"data":null,"render": function ( data, type, row) {
                if(data.estado == 'a'){
                  return '<span class="label label-primary">ACTIVO</span>';
                } else if (data.estado == 'i'){
                  return '<span class="label label-danger">INACTIVO</span>';
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<div class="text-right"><button class="btn btn-info btn-xs" onclick="listarMesas('+data.id_catg+',\''+data.descripcion+'\');"> Ver </button>'
                +'&nbsp;<button class="btn btn-success btn-xs" onclick="editarSalon('+data.id_catg+',\''+data.estado+'\',\''+data.id_sucursal+'\',\''+data.descripcion+'\');"> <i class="fa fa-edit"></i> Editar </button>'
                +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarSalon('+data.id_catg+',\''+data.id_sucursal+'\',\''+data.descripcion+'\');"> <i class="fa fa-trash"></i></button></div>';
            }}
        ]
    });
}

/* Mostrar datos en la tabla mesas */
var listarMesas = function(cod_sal,desc_sal){
    var mesaNueva = '';
    /* Ocultar panel mensaje 'seleccione un salon' */
    $('#lizq-s').css("display","none");
    /* Mostrar tabla mesas por salon */
    $('#lizq-i').css("display","block");
    $('#btn-nuevo').html('<button type="button" class="btn btn-primary" onclick="agregarMesa();"><i class="fa fa-plus-circle"></i> Nueva Mesa</button>');
    $('#id_catg').val(cod_sal);
    $('#title-mesa').text(desc_sal);
    $('#id_sucursal_m').val(cod_sal);

    var table = $('#table-m')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/ajustesListaMesas",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                  return '<a onclick="estadoMesa('+data.id_mesa+',\''+data.estado+'\');"><span class="label label-primary">ACTIVA</span></a>';
                } else if (data.estado == 'i' || data.estado == 'p'){
                  return '<span class="label label-warning">OCUPADA</span>'
                }
                else if (data.estado == 'm'){
                  return '<a onclick="estadoMesa('+data.id_mesa+',\''+data.estado+'\');"><span class="label label-danger">INACTIVA</span></a>'
                } 
            }},
            {"data":null,"render": function ( data, type, row) {
                if(data.plan_id == 1){
                    if(data.plan_estado == '1') {
                        return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarMesa('+data.id_mesa+',\''+data.nro_mesa+'\','+data.id_catg+');"> <i class="fa fa-edit"></i> Editar </button>'
                            +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarMesa('+data.id_mesa+',\''+data.nro_mesa+'\');"> <i class="fa fa-trash"></i> Eliminar </button></div>';
                    }else {
                        return '<div class="text-right"></div>';
                    }
                }
                if(data.plan_id == 2){
                    return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarMesa('+data.id_mesa+',\''+data.nro_mesa+'\','+data.id_catg+');"> <i class="fa fa-edit"></i> Editar </button>'
                        +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarMesa('+data.id_mesa+',\''+data.nro_mesa+'\');"> <i class="fa fa-trash"></i> Eliminar </button></div>';
                }
            }}
        ]
    });
}

/* Editar datos del salon */
var editarSalon = function(cod,est,id_sucursal,nomb){

    if(cod)
    { 
        $('#id_sucursal').selectpicker('hide');
    }
    
    $('#cod_sala').val(cod);
    $('#desc_sala').val(nomb);
    
    $('#est_salon').selectpicker('val', est);
    $("#mdl-salon").modal('show');

  
 
}

var agregarMesa = function(){

    $("#mdl-mesa").modal('show');
    $('#cod_mesa').val('');
}

/* Eliminar salon */
var eliminarSalon = function(cod,id_sucursal,nomb){
  $('#cod_salae').val(cod);
  $('#id_sucursal_s').val(id_sucursal);
  $("#mensaje-es").html("<center><h4>¿Desea eliminar el Salon : "+ nomb +"?</h4></center>");
  $("#mdl-eliminar-salon").modal('show');
}

/* Editar datos de la mesa*/
var editarMesa = function(cod,nomb,cod_s){
    $('#cod_mesa').val(cod);
    $('#nro_mesa').val(nomb);
    $('#id_catg').val(cod_s);
    $("#mdl-mesa").modal('show');
}

/* Eliminar mesa */
var eliminarMesa = function(cod,nomb){
  $('#cod_mesae').val(cod);
  $("#mensaje-em").html("<center><h4>¿Desea eliminar la Mesa "+ nomb +"?</h4></center>");          
  $("#mdl-eliminar-mesa").modal('show');
}

/*  Modificar estado de la mesa para mostrar o no mostrar en el modulo restaurante */
var estadoMesa = function(cod,estado){
  $('#codi_mesa').val(cod);
  $('#est_mesa').selectpicker('val',estado);
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
          var form = $(this);

          var salones = {
            cod_sala: 0,
            desc_sala: 0,
            sucursal_sala: 0,
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
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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
                      //location.replace("/ajustesSalonyMesas");
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
                      //location.replace("/ajustesSalonyMesas");
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
        nro_mesa: 0,
            id_sucursal_m: 0
        }

        mesas.cod_mesa = $('#cod_mesa').val();
        mesas.id_catg = $('#id_catg').val();
        mesas.nro_mesa = $('#nro_mesa').val();
        mesas.id_sucursal_m = $('#id_sucursal_m').val();

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: form.attr('action'),
            data: mesas,
            dataSrc : "",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            success: function (data) {
            //console.log(data);
                if(data.cant_mesas >= limite_mesas)
                {
                    $('#btn-nuevo').css('display','none');
                    $('#limite_mesas_txt').css('display','block');
                }
                else{
                    $('#btn-nuevo').css('display','block');
                    $('#limite_mesas_txt').css('display','none');
                }
                if(data.cod == 0){
                    toastr.warning('Advertencia, Datos duplicados.');
                    return false;
                } else if(data.cod == 1){
                    $('#mdl-mesa').modal('hide');
                    listarSalones();
                    listarMesas(mesas.id_catg);
                    toastr.success('Datos registrados, correctamente.');
                    $('#mesas_count').text(data.cant_mesas);   
                } else if(data.cod == 2) {
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
              dataType: 'html',
              type: 'POST',
              url: form.attr('action'),
              data: emesa,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function (datos) {
                  //console.log(datos);
                  if(datos == 1)
                  {
                    toastr.success('Datos modificados, correctamente.');
                    $('#mdl-estado-mesa').modal('hide');
                    listarSalones();
                    listarMesas($('#id_catg').val());
                  }
                  else if(datos==-1){
                    toastr.warning('No se puede desactivar una mesa en uso.');     
                  }
                  
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
        cod_salae: 0,
        id_sucursal: 0
    }

    salon.cod_salae = $('#cod_salae').val();
    salon.id_sucursal = $('#id_sucursal_s').val();

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: form.attr('action'),
        data: salon,
        dataSrc : "",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (cod) {
            if(cod == 1){
                listarSalones();
                $('#mdl-eliminar-salon').modal('hide');
                $('#table-m tbody').remove();
                $('#lizq-s').css("display","block");
                $('#lizq-i').css("display","none");
                toastr.success('Datos eliminados, correctamente.');
                listarSalones();
            } else if(cod == 0){
                $('#mdl-eliminar-salon').modal('hide');
                toastr.warning('Advertencia, El salon no puede ser eliminado.');
                listarSalones();
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
        dataSrc : "",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function (data) {
            if(data.cant_mesas < limite_mesas)
            {
                $('#btn-nuevo').css('display','block');
                $('#limite_mesas_txt').css('display','none');
            }
            if(data.cod == 1){
                var codigoSalon = $('#id_catg').val();
                listarSalones();
                listarMesas(codigoSalon);
                $('#mdl-eliminar-mesa').modal('hide');
                toastr.success('Datos elimianados correctamente');
                $('#mesas_count').text(data.cant_mesas);   
            } else if(data.cod == 0){
                $('#mdl-eliminar-mesa').modal('hide');
                toastr.warning('Advertencia, La mesa no puede ser eliminada.');
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
    $('#est_mesa').selectpicker('val', 'a');
});