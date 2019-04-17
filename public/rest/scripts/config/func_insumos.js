$(function() {
    var cat = '%';
    //listarCategorias();
    listarInsumos(cat);
    listarSucursales();
    comboCategoria();
    mensaje();
    ActualizarCategoriaAreap(null,null);
});

/* Mostrar datos en la lista categorias */
var listarCategorias = function(){
    $('#ul-categorias').empty();
    $.ajax({
      type: "POST",
      url: "/ajustesListarCatgI",
      dataType: "json",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      success: function(item){
          $.each(item.data, function(i, campo) {
              $('#ul-categorias')
                .append(
                  $('<li/>')
                    .append(
                    $('<div/>')
                  .html('<a style="display: inline-block;" onclick="listarInsumos('+campo.id_catg+')"><i class="fa fa-caret-right"></i> '+campo.descripcion+'</a>'
                    +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                  )
                )
          });
        }
    });
}

var listarSucursales = function(){
    $('#ul-cont-sucursalesInsum').empty();
    $.ajax({
        type: "POST",
        url: "/ajustesListarSucursalesInsum",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(item){
            $.each(item.data, function(i, campo) {
                $('#ul-cont-sucursalesInsum')
                    .append(
                    $('<ul id="ul-cont-sucurInsum"/>')
                        .append(
                        $('<li/>')
                            .html('<a style="display: inline-block;" onclick="listarInsumos('+campo.id+')"><i class="fa fa-caret-right"></i> '+campo.nombre_sucursal+'</a>'
                            +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                            .append(
                            $('<ul/>')
                                .append(
                                $('<li style="margin-left: 10px;"/>')
                                    .html('<a style="display: inline-block;" onclick="listarInsumos('+campo.id_catg+')"><i class="fa fa-caret-right"></i> '+campo.descripcion+'</a>'
                                    +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                            )
                        )
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
            "url": "/ajustesListarInsumos",
            "data": function ( d ) {
              d.cod = '%';
              d.cat = cat;
          },"dataSrc" : "",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
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
var editarCategoria = function(cod,desc,id_suc){
    $("#id_catg").val(cod);
    $("#nombre_catg").val(desc);
    $('#id_sucursal').val(id_suc);
    $('#id_sucursal').selectpicker('refresh');
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
      url: "/ajustesListarInsumos",
      data: {
          cod: cod,
          cat: cat
      },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      dataType: "json",
      success: function(item){
          //console.log(item);
        $.each(item, function(i, campo) {

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
    /*$.ajax({
        type: "POST",
        url: "/",
        dataSrc : "",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function (response) {
            $('#combo_catg').html(response);
            $('#cod_catg').selectpicker();
        },
        error: function () {
            $('#combo_catg').html('There was an error!');
        }
    });*/
}

$("#frm-categoria").submit(function(e){
    e.preventDefault();
    var form = $(this);

        var categoria = {
            cod_catg: 0,
            nombre_catg: 0,
            id_sucursal:0 
        }

        if($('#nombre_catg').val() == '')
        {
            toastr.warning('Debes agregar un nombre a la categor&iacute;a.');
            return false;
        } else {

        categoria.cod_catg = $('#id_catg').val();
        categoria.nombre_catg = $('#nombre_catg').val();
        categoria.id_sucursal = $('#id_sucursal').val();
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: form.attr('action'),
            data: categoria
            ,dataSrc : "",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (cod) {
                if(cod == 0){
                    toastr.warning('Advertencia, Datos duplicados.');
                    return false;
                } else if(cod == 1){
                    listarSucursales();
                    $('#nombre_catg').val('');
                    $("#id_catg").val('');
                    $('#boton-catg').css("display","block");
                    $('#nueva-catg').css("display","none");
                    toastr.success('Datos registrados, correctamente.');
                    return false;
                } else if(cod == 2) {
                    listarSucursales();
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
$('#id_sucursal_d').on('change',function(){

    ActualizarCategoriaAreap(null,null);
});
var ActualizarCategoriaAreap = function(cod_area,cod_catg){
    //console.log(cod_area,cod_catg,'entro');
    var id_sucursal = $('#id_sucursal_d').val();
    /* 
    $.ajax({
        type: "POST",
        url: "/AreasProdXSucursal",
        data: {
            id_sucursal: id_sucursal,
            
        },
        dataType: "json",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        ,success:function(response){
            console.log(response);
            $('#cod_area').empty();
            for(var i = 0 ; i< response.length; i++){
                $('#cod_area').append(
                    `<option value="${response[i].id_areap}"> ${response[i].nombre} </option>`
                );
            }
            $('#cod_area').selectpicker('refresh');
            if(cod_area!=null) $('#cod_area').selectpicker('val',cod_area);
        }
    });
    */
    $.ajax({
        type: "POST",
        url: "/CategoriasIXSucursal",
        data: {
            id_sucursal: id_sucursal,
        },
        dataType: "json",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        ,success:function(response){
            //console.log(response);
            $('#cod_catg').empty();
            for(var i = 0 ; i< response.length; i++){
                $('#cod_catg').append(
                    `<option value="${response[i].id_catg}"> ${response[i].descripcion} </option>`
                );
            }
            $('#cod_catg').selectpicker('refresh');
            if(cod_catg!=null) $('#cod_catg').selectpicker('val',cod_catg);
        }
    });
    
    
  
}
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
            insumo.id_sucursal = $('#id_sucursal_d').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: insumo,
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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