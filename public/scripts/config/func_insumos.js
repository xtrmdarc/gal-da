$(function() {
    var cat = '%';
    listarCategorias();
    listarInsumos(cat);
    comboCategoria();
    mensaje();
});

/* Mostrar datos en la lista categorias */
var listarCategorias = function(){
    $('#ul-categorias').empty();
    $.ajax({
      type: "POST",
      url: "?c=Config&a=ListaCatgs",
      dataType: "json",
      success: function(item){
          $.each(item.data, function(i, campo) {
              $('#ul-categorias')
                .append(
                  $('<li/>')
                    .append(
                    $('<div/>')
                  .html('<a style="display: inline-block;" onclick="listarInsumos('+campo.id_catg+')"><i class="fa fa-caret-right"></i> '+campo.descripcion+'</a>'
                    +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\')"><i class="fa fa-pencil"></i></a>')
                  )
                )
          });
        }
    });
}

/* Mostrar datos en la tabla insumos */
var listarInsumos = function(cat){
    var table = $('#table-insumos')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "tp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "?c=Config&a=ListaIns",
            "data": function ( d ) {
              d.cod = '%';
              d.cat = cat;
          }
        },
        "columns":[
            {"data":"cod_ins"},
            {"data":"nomb_ins"},
            {"data":"desc_c"},
            {"data":"desc_m"},
            {"data":null,"render": function ( data, type, row) {
                if(data.estado == 'a'){
                  return '<span class="text-navy"><i class="fa fa-check"></i> Si </span>';
                } else if (data.estado == 'i'){
                  return '<span class="text-danger"><i class="fa fa-close"></i> No </span>'
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<div class="text-right"><a class="btn btn-xs btn-success" onclick="editarInsumo('+data.id_ins+')"><i class="fa fa-edit"></i> Editar</a></div>';
            }},
        ]
    });
}

/* Editar categoria */
var editarCategoria = function(cod,desc){
    $("#id_catg").val(cod);
    $("#nombre_catg").val(desc);
    $('#boton-catg').css("display","none");
    $('#nueva-catg').css("display","block");
}

/* Editar insumo */
var editarInsumo = function(cod){
    $('#cod_catg').selectpicker('destroy');
    comboCategoria();
    var cat = '%';
    $('#mdl-insumo').modal('show');
    $("#cod_ins").val(cod);
    $.ajax({
      type: "POST",
      url: "?c=Config&a=ListaIns",
      data: {
          cod: cod,
          cat: cat
      },
      dataType: "json",
      success: function(item){
        $.each(item.data, function(i, campo) {
            $('#nombre_ins').val(campo.nomb_ins);
            $('#codigo_ins').val(campo.cod_ins);
            $('#cod_med').selectpicker('val', campo.id_med);
            $('#cod_catg').selectpicker('val', campo.id_catg);
            $('#stock_min').val(campo.stock_min);
            $('#estado').selectpicker('val', campo.estado);
        });
      }
    });
}

/* Combo categoria */
var comboCategoria = function(){
    $.ajax({
        type: "POST",
        url: "?c=Config&a=ComboCatg",
        success: function (response) {
            $('#combo_catg').html(response);
            $('#cod_catg').selectpicker();
        },
        error: function () {
            $('#combo_catg').html('There was an error!');
        }
    });
}

$("#frm-categoria").submit(function(){

    var form = $(this);

        var categoria = {
            cod_catg: 0,
            nombre_catg: 0
        }

        if($('#nombre_catg').val() == '')
        {
            toastr.warning('Debes agregar un nombre a la categor&iacute;a.');
            return false;
        } else {

        categoria.cod_catg = $('#id_catg').val();
        categoria.nombre_catg = $('#nombre_catg').val();

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: form.attr('action'),
            data: categoria,
            success: function (cod) {
                if(cod == 0){
                    toastr.warning('Advertencia, Datos duplicados.');
                    return false;
                } else if(cod == 1){
                    listarCategorias();
                    $('#nombre_catg').val('');
                    $("#id_catg").val('');
                    $('#boton-catg').css("display","block");
                    $('#nueva-catg').css("display","none");
                    toastr.success('Datos registrados, correctamente.');
                    return false;
                } else if(cod == 2) {
                    listarCategorias();
                    $('#nombre_catg').val('');
                    $("#id_catg").val('');
                    $('#boton-catg').css("display","block");
                    $('#nueva-catg').css("display","none");
                    toastr.success('Datos modificados, correctamente.');
                    return false;
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown + ' ' + textStatus);
            }   
        });

      }

    return false;
});

$(function() {
    $('#frm-insumo')
      .formValidation({
          framework: 'bootstrap',
          excluded: ':disabled',
          fields: {
          }
      })
      .on('success.form.fv', function(e) {

          if ($('#cod_catg').val().trim() === '') {
            toastr.warning('Seleccione una categoria.');
            $('.btn-guardar').removeAttr('disabled');
            $('.btn-guardar').removeClass('disabled');
            return false;

          } else {

            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            
            var form = $(this);

            var insumo = {
              cod_ins: 0,
              cod_catg: 0,
              cod_med: 0,
              codigo_ins: 0,
              nombre_ins: 0,
              stock_min: 0,
              estado: 0
            }

            insumo.cod_ins = $('#cod_ins').val();
            insumo.cod_catg = $('#cod_catg').val();
            insumo.cod_med = $('#cod_med').val();
            insumo.codigo_ins = $('#codigo_ins').val();
            insumo.nombre_ins = $('#nombre_ins').val();
            insumo.stock_min = $('#stock_min').val();
            insumo.estado = $('#estado').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: insumo,
                success: function (cod) {
                    if(cod == 0){
                        toastr.warning('Advertencia, Datos duplicados.');
                        return false;
                    } else if(cod == 1){
                        var cat = '%';
                        $('#mdl-insumo').modal('hide');
                        listarInsumos(cat);
                        toastr.success('Datos registrados, correctamente.');
                    } else if(cod == 2) {
                        var cat = '%';
                        $('#mdl-insumo').modal('hide');
                        listarInsumos(cat);
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

/* Boton nueva categoria */
$('.btn-catg').click( function() {
    $('#boton-catg').css("display","none");
    $('#nueva-catg').css("display","block");
});

/* Boton cancelar nueva categoria */
$('.btn-c-catg').click( function() {
    $('#boton-catg').css("display","block");
    $('#nueva-catg').css("display","none");
    $('#nombre_catg').val('');
    $('#id_catg').val('');
});

/* Boton nuevo insumo */
$('.btn-ins').click( function() {
    $('#cod_ins').val('');
    $('#cod_catg').selectpicker('destroy');
    comboCategoria();
    $('#mdl-insumo').modal('show');
});

$('#mdl-insumo').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-insumo').formValidation('resetForm', true);
    $('#estado').selectpicker('val', 'a');
    $("#cod_med").val('').selectpicker('refresh');
});

var mensaje = function(){
    if($("#m").val() == 'np'){
        toastr.success('Se ha registrado correctamente el producto!');
    }else if ($("#m").val() == 'up'){
        toastr.info('Se ha modificado correctamente el producto!');
    }else if ($("#m").val() == 'dp'){
        toastr.error('El nombre del producto ya se encuentra registrado!');
    }else if ($("#m").val() == 'pp'){
        toastr.warning('El nombre del producto ya se encuentra registrado!');
    }
}