$(function() {
    var cat = '%';
    areaP_x_sucursales();
    //listarCategorias();
    listarSucursales();
    listarProductos(cat);
    comboCategoria();
    mensaje();
});
/* Mostrar datos en la lista de Sucursales por id_usu */

var areaP_x_sucursales = function (){
    $('select[name="id_sucursal_d"]').on('change', function() {
        var sucursalId = $(this).val();

        //console.log(sucursalId);

        $.ajax({
            type: "POST",
            url: "/ajustesCrudProd",
            data: {id_sucursal_d : sucursalId },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                //console.log(data);
                //remove disabled from province and change the options
                $('select[name="cod_area"]').prop("disabled", false);
                $('select[name="cod_area"]').html(data.response);
            }
        });
    });
}
var listarSucursales = function(){
    $('#ul-cont-sucursalesProd').empty();
    $.ajax({
        type: "POST",
        url: "/ajustesListarSucursalesProd",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(item){
            $.each(item.data, function(i, campo) {
                $('#ul-cont-sucursalesProd')
                    .append(
                    $('<ul id="ul-cont-sucurProd"/>')
                        .append(
                        $('<li/>')
                            .html('<a style="display: inline-block;" onclick="listarProductos('+campo.id+')"><i class="fa fa-caret-right"></i> '+campo.nombre_sucursal+'</a>'
                            +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                            .append(
                            $('<ul/>')
                                .append(
                                $('<li style="margin-left: 10px;"/>')
                                    .html('<a style="display: inline-block;" onclick="listarProductos('+campo.id_catg+')"><i class="fa fa-caret-right"></i> '+campo.descripcion+'</a>'
                                    +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                            )
                        )
                    )
                )
            });
        }
    });
}

$('#id_sucursal_d').on('change',function(){

    ActualizarCategoriaAreap(null,null);
});

/* Mostrar datos en la lista categorias */
var listarCategorias = function(){
    $('#ul-cont').empty();
    $.ajax({
        type: "POST",
        url: "/ajustesListarCatg",
        dataType: "json",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function(item){
            $.each(item.data, function(i, campo) {
                $('#ul-cont-sucursalesProd')
                .append(
                    $('<li/>')
                    .append(
                        $('<div/>')
                        .html('<a style="display: inline-block;" onclick="listarProductos('+campo.id_catg+')"><i class="fa fa-caret-right"></i> '+campo.descripcion+'</a>'
                        +'<a style="display: inline-block;" class="pull-right" onclick="editarCategoria('+campo.id_catg+',\''+campo.descripcion+'\',\''+campo.id_sucursal+'\')"><i class="fa fa-pencil"></i></a>')
                    )
                )
            });
        }
    });
}

/* Mostrar datos en la tabla productos */
var listarProductos = function(cat){
    $('#head-p').empty();
    $('#body-c').empty();
    $('#body-p').empty();
    var table = $('#table-productos')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "tp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/ajustesListarProductos",
            "dataSrc" : "",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "data": function ( d ) {
                d.cod = '%';
                d.cat = cat;
            }
        },
        "columns":[
            {"data":null,"render": function ( data, type, row) {
                return '<a style="text-decoration-line: underline!important;color: #4680ff;" onclick="listarPresentaciones('+data.id_prod+',\''+data.nombre+'\')">'+data.nombre+'</a>';
            }},
            {"data":null,"render": function ( data, type, row) {
                if(data.id_tipo == 1){
                    return '<div class="text-center"><span class="text-navy"><i class="fa fa-check"></i> Si </span></div>';
                } else if (data.id_tipo == 2){
                    return '<div class="text-center"><span class="text-danger"><i class="fa fa-close"></i> No </span></div>'
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                if(data.estado == 'a'){
                    return '<div class="text-center"><span class="text-navy"><i class="fa fa-check"></i> Si </span></div>';
                } else if (data.estado == 'i'){
                    return '<div class="text-center"><span class="text-danger"><i class="fa fa-close"></i> No </span></div>'
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<a class="btn btn-xs btn-success" onclick="editarProducto('+data.id_prod+')"><i class="fa fa-edit"></i></a>';
            }},
        ]
    });
}

/* Listar presentaciones de cada producto seleccionado */
var listarPresentaciones = function(cod_prod,nomb){
    var moneda = $("#moneda").val();
    var cat = '%';
    $.ajax({
        type: "POST",
        url: "/ajustesListarPres",
        data: {
            cod_prod: cod_prod,
            cod_pres: cat
        },
        dataSrc : "",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(item){
        $('#head-p').html('<a class="btn btn-primary btn-block" onclick="nuevaPresentacion('+cod_prod+',\''+nomb+'\')"><i class="fa fa-plus-circle"></i> Agregar presentaci&oacute;n </a>');
        $('#body-c').html('<br><strong class="ich">Presentaciones de '+nomb+'</strong><br><br>');
            if (item.data.length != 0) {
                $('#body-p').empty();
                $.each(item.data, function(i, campo) {
                    $('#body-p')
                    .append(
                      $('<div class="ibox ibox-cr"/>')
                        .html('<a onclick="editarPresentacion('+campo.id_pres+',\''+nomb+'\')"><div class="ibox-title ibox-title-cr"><h5>'+campo.presentacion+'</h5><div class="amount-big"> <span class="the-number"> '+moneda+' '+campo.precio+'</span></div></div></a>')
                    )
                });
            } else {
                $('#body-p').html('<div class="panel panel-transparent panel-dashed tip-sales text-center">'
                +'<div class="row"><div class="col-sm-8 col-sm-push-2"><h2 class="ich m-t-none">Agrega una presentación</h2><p>Debes agregar una presentación para poder guardar y usar el producto.</p></div></div></div>');
            }
        }
    });
}


var ActualizarCategoriaAreap = function(cod_area,cod_catg){
    //console.log(cod_area,cod_catg,'entro');
    var id_sucursal = $('#id_sucursal_d').val();
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
            //console.log(response);
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

    $.ajax({
        type: "POST",
        url: "/CategoriasXSucursal",
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

/* Editar datos de un producto */
var editarProducto = function(cod){
    $('#cod_catg').selectpicker('destroy');
    comboCategoria();
    var cat = '%';
    $('#mdl-producto').modal('show');
    $("#cod_prod").val(cod);
    $.ajax({
        type: "POST",
        url: "/ajustesListarProductos",
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
                //console.log(campo);
                $('#nombre_prod').val(campo.nombre);
                if(campo.id_tipo == 1){
                    $('#transf').iCheck('check');
                } else if (campo.id_tipo == 2){
                    $('#ntransf').iCheck('check');
                }
                $('#id_sucursal_d').selectpicker('val',campo.id_sucursal);
                ActualizarCategoriaAreap(campo.id_areap,campo.id_catg);
                //$('#cod_area').selectpicker('val', campo.id_areap);
                //$('#cod_catg').selectpicker('val', campo.id_catg);
                $('#estado_catg').selectpicker('val', campo.estado);
                $('#descripcion').val(campo.descripcion);
            });
        }
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

/* Nueva presentacion de un producto */
var nuevaPresentacion = function(cod_prod,nomb_prod){
    $('#frm-presentacion').formValidation('resetForm', true);
    $("#estado_pres").val('').selectpicker('refresh');
    $("#cod_producto").val(cod_prod);
    $("#nomb_prod").val(nomb_prod);
    var cat = '%';
    $.ajax({
        type: "POST",
        url: "/ajustesListarProductos",
        data: {
            cod: cod_prod,
            cat: cat
        },"dataSrc" : "",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(item){
            $.each(item.data, function(i, campo) {
            //id_tipo = 1 (Producto Transformado)
                if(campo.id_tipo == 1){
                    // Ocultar check receta (tp-1), stock/stock_minimo (tp-2)
                    $('#tp-1').css('display','none');
                    $('#tp-2').css('display','none');
                    // Quita el check a receta
                    $('#id_rec').iCheck('uncheck');
                    $('#mensaje-ins').css('display','block');
                    $('#mensaje-ins').html('<div class="alert alert-warning">'
                        +'<i class="fa fa-warning"></i> Guarde los datos de la presentaci&oacute;n, para que pueda ingresar una receta.'
                        +'</div>');
                }
                //id_tipo = 2 (Producto NO Transformado)
                else{
                  // Quita el check a stock y su clase icheckbox_flat-green
                    $('#id_stock').iCheck('uncheck');
                    $('.icheckbox_flat-green').removeClass('checked');
                    $('#mensaje-ins').css('display','none');
                    // Ocultar check receta (tp-1)
                    $('#tp-1').css('display','none');
                    // Mostrar check stock / stock-minimo (tp-2)
                    $('#tp-2').css('display','block');
                }
            });
        }
    });
    $('#cod_pres').val('');
    $('#stock_min').val('');
    $('#mdl-presentacion').modal('show');
}

/* Editar datos de una presentacion de un producto */
var editarPresentacion = function(cod_pres,nomb_prod){
    var cat = '%';
    $('#frm-presentacion').formValidation('resetForm', true);
    $("#nomb_prod").val(nomb_prod);
    $('#cod_pre').val(cod_pres);
    $('#mdl-presentacion').modal('show');
    $.ajax({
        type: "POST",
        url: "/ajustesListarPres",
        data: {
            cod_prod: cat,
            cod_pres: cod_pres
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(item){
            $.each(item.data, function(i, campo) {
                $('#cod_pres').val(campo.id_pres);
                $("#cod_producto").val(campo.id_prod);
                $('#cod_produ').val(campo.cod_prod);
                $('#nombre_pres').val(campo.presentacion);
                $('#precio_prod').val(campo.precio);
                $('#stock_min').val(campo.stock_min);
                $('#estado_pres').selectpicker('val', campo.estado);
                //id_tipo = 1 (Producto Transformado)
                if(campo.TipoProd.id_tipo == 1){
                    if(campo.receta == 1){
                        $('#id_rec').iCheck('check');
                        $('#mensaje-ins').css('display','block');
                        $('#mensaje-ins').html('<div class="alert alert-info">'
                            +'<i class="fa fa-info"></i> Modificar los ingredientes <a class="alert-link" onclick="receta()">AQUI</a>.'
                            +'</div>');
                    } else {
                        $('#id_rec').iCheck('uncheck');
                        $('#mensaje-ins').css('display','none');
                        $('#mensaje-ins').html('<div class="alert alert-warning">'
                            +'<i class="fa fa-warning"></i> Ingresar los ingredientes <a class="alert-link" onclick="receta()">AQUI</a> y luego click en Guardar.'
                            +'</div>');
                    }
                    // Mostrar check receta (tp-1)
                    $('#tp-1').css('display','block');
                    // Ocultar check stock / stock_minimo (tp-2)
                    // $('#tp-2').css('display','none');
                }
                //id_tipo = 2 (Producto NO Transformado)
                else{
                    $('#mensaje-ins').css('display','none');
                    if(campo.receta == 1){
                        $('#id_stock').iCheck('check');
                    } else {
                        $('#id_stock').iCheck('uncheck');
                    }
                    // Ocultar check receta (tp-1)
                    $('#tp-1').css('display','none');
                    // Mostrar check stock / stock_minimo (tp-2)
                    //$('#tp-2').css('display','block');
                }
            });
        }
    });
}

/* Combo categoria producto */
var comboCategoria = function(){
    $.ajax({
        type: "POST",
        url: "/ajustesComboCatg",
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
    });
}

/* Producto */
$(function() {
    $('#frm-producto')
        .formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
        }
    })
    .on('success.form.fv', function(e) {

        if ($('#cod_catg').val().trim() === '') {
            toastr.warning('Seleccione una categoria!');
            $('.btn-guardar').removeAttr('disabled');
            $('.btn-guardar').removeClass('disabled');
            return false;

        } else {

            e.preventDefault();
            var $form = $(e.target),
            fv = $form.data('formValidation');
            
            var form = $(this);

            var producto = {
                cod_prod: 0,
                tipo_prod: 0,
                cod_catg: 0,
                cod_area: 0,
                nombre_prod: 0,
                descripcion: 0,
                estado_catg: 0,
                id_sucursal_d: 0
            }

            producto.cod_prod = $('#cod_prod').val();
            producto.tipo_prod = $('input:radio[name=tipo_prod]:checked').val();
            producto.cod_catg = $('#cod_catg').val();
            producto.cod_area = $('#cod_area').val();
            producto.nombre_prod = $('#nombre_prod').val();
            producto.descripcion = $('#descripcion').val();
            producto.estado_catg = $('#estado_catg').val();
            producto.id_sucursal_d = $('#id_sucursal_d').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: producto,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (cod) {
                    if(cod == 0){
                        toastr.warning('Advertencia, Datos duplicados.');
                        return false;
                    } else if(cod == 1){
                        var cat = '%';
                        $('#mdl-producto').modal('hide');
                        listarProductos(producto.cod_catg);
                        toastr.success('Datos registrados, correctamente.');
                    } else if(cod == 2) {
                        var cat = '%';
                        $('#mdl-producto').modal('hide');
                        listarProductos(producto.cod_catg);
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

$(function() {
    $('#frm-presentacion')
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

        var presentacion = {
            cod_pres: 0,
            cod_producto: 0,
            cod_produ: 0,
            nombre_pres: 0,
            precio_prod: 0,
            estado_pres: 0,
            id_rec: 0,
            stock_min: 0
        }

        presentacion.cod_pres = $('#cod_pres').val();
        presentacion.cod_producto = $('#cod_producto').val();
        presentacion.cod_produ = $('#cod_produ').val();
        presentacion.nombre_pres = $('#nombre_pres').val();
        presentacion.precio_prod = $('#precio_prod').val();
        presentacion.estado_pres = $('#estado_pres').val();
        presentacion.id_rec = $('#id_rec').val();
        presentacion.stock_min = $('#stock_min').val();

        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: form.attr('action'),
            data: presentacion,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (cod) {
                if(cod == 0){
                    toastr.warning('Advertencia, Datos duplicados.');
                    return false;
                } else if(cod == 1){
                    $('#mdl-presentacion').modal('hide');
                    listarPresentaciones($('#cod_producto').val(),$('#nomb_prod').val());
                    toastr.success('Datos registrados, correctamente.');
                } else if(cod == 2) {
                    $('#mdl-presentacion').modal('hide');
                    listarPresentaciones($('#cod_producto').val(),$('#nomb_prod').val());
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

$("#frm-categoria").submit(function(e){
    e.preventDefault();
    var form = $(this);

        var categoria = {
            cod_catg: 0,
            nombre_catg: 0,
            id_sucursal: 0
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
            data: categoria,
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

/* Mostrar los ingredientes/insumos de una receta */
var listarReceta = function(){
    $.ajax({
        type: "POST",
        url: "?c=Config&a=ListaIngs",
        data: {
            cod: $("#cod_pre").val()
        },
        dataType: "json",
        success: function(item){

            if (item.data.length != 0) {

                $('#insumo-list').empty();
                $('#titulo-list').empty();

                $.each(item.data, function(i, campo) {

                    var opc_m=campo.id_med;if(1==opc_m)var valor_cant=(1*campo.cant).toFixed(2);else if(2==opc_m)var valor_cant=(1*campo.cant).toFixed(2);else if(3==opc_m)var valor_cant=(1e3*campo.cant).toFixed(2);else if(4==opc_m)var valor_cant=(1e6*campo.cant).toFixed(2);else if(5==opc_m)var valor_cant=(1*campo.cant).toFixed(2);else if(6==opc_m)var valor_cant=(1e3*campo.cant).toFixed(2);else if(7==opc_m)var valor_cant=(2.20462*campo.cant).toFixed(2);else if(8==opc_m)var valor_cant=(35.274*campo.cant).toFixed(2);

                    $('#titulo-list').html('<div class="text-center"><h2 class="ich m-t-none">Lista de ingredientes</h2></div>');
                    $('#insumo-list')
                    .append(
                        $('<li class="list-group-item animated bounce"/>')
                        .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-md-5" />')
                                .html('<input disabled class="form-control txtlbl" type="hidden" id="cant'+campo.id_pi+'" style="text-align: center;" value="'+valor_cant+'" autocomplete="off"/><label>'+valor_cant+'</label>&nbsp;<span class="label label-warning">'+campo.Medida.descripcion+'</span>')
                            )
                        .append(
                            $('<div class="col-md-5" />')
                            .html('<label name="insumo">'+campo.Insumo.nomb_ins+'</label>&nbsp;<span class="label label-info">INSUMO</span>&nbsp;<span class="label label-success">'+campo.Insumo.desc_m+'</span>')
                            )
                        .append(
                            $('<div class="col-md-2" />')
                            .html('<div class="text-right">'
                                /*+'<button type="button" class="btn btn-primary" onclick="editarInsumo('+campo.id_pi+');"><i class="fa fa-refresh"></i></button>'*/
                                +'&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="eliminarInsumo('+campo.id_pi+');"><i class="fa fa-times"></i></button></div>')
                            )
                        )
                    );
                });

            } else {
                $('#titulo-list').empty();
                $('#insumo-list').html('<div class="panel panel-transparent panel-dashed tip-sales text-center">'
                    +'<div class="row"><div class="col-sm-8 col-sm-push-2"><h2 class="ich m-t-none">Agrega un ingrediente</h2><p>Debes agregar un ingrediente para crear una receta del producto.</p></div></div></div>');
            }
        }
    });
}

/* Abrir modal para ingresar insumos/ingredientes a la receta */
var receta = function(){
    $('#mdl-presentacion').modal('hide');
    $('#mdl-receta').modal('show');
    listarReceta();
}

/* Editar datos de insumo/ingrediente en receta */
var editarInsumo = function(cod){
    $.ajax({
        type: "POST",
        url: "?c=Config&a=UIng",
        data: {
            cod: cod,
            cant: $('#cant'+cod).val()
        },
        dataType: "json",
        success: function(datos){
            toastr.success('Datos modificados, correctamente.');
        }
    });
}

/* Eliminar insumo/ingrediente de receta */
var eliminarInsumo = function(cod){
    $.ajax({
        type: "POST",
        url: "?c=Config&a=EIng",
        data: {
            cod: cod
        },
        dataType: "json",
        success: function(datos){
            toastr.success('Datos eliminados, correctamente.');
            listarReceta();
        }
    });
}

/* Boton cerrar modal ingredientes */
$('.btn-cerrar').click( function() {
    $('#mdl-receta').modal('hide');
    $('#mdl-presentacion').modal('show');
});

/* Check activo receta */
$('#id_rec').on('ifChecked', function(event){
    $('#mensaje-ins').css('display','block');
    $('#id_rec').val('1');
});

/* Check inactivo receta */
$('#id_rec').on('ifUnchecked', function(event){
    $('#mensaje-ins').css('display','none');
    $('#id_rec').val('0');
});

/* Check activo stock */
$('#id_stock').on('ifChecked', function(event){
    $('#id_rec').val('1');
});

/* Check inactivo stock */
$('#id_stock').on('ifUnchecked', function(event){
    $('#id_rec').val('0');
});

/* Boton nuevo producto */
$('.btn-prodnuevo').click( function() {
    $('#cod_prod').val('');
    $('#cod_catg').selectpicker('destroy');
    comboCategoria();
    $('#mdl-producto').modal('show');
});

/* Boton nueva categoria */
$('.btn-catg').click( function() {
    $('#boton-catg').css("display","none");
    $('#nueva-catg').css("display","block");
});

/* Boton cancelar categoria */
$('.btn-ccatg').click( function() {
    $('#boton-catg').css("display","block");
    $('#nueva-catg').css("display","none");
    $('#nombre_catg').val('');
    $('#id_catg').val('');
});

$('#mdl-producto').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-producto').formValidation('resetForm', true);
    $('#transf').iCheck('update');
    $('#ntransf').iCheck('update');
    $('#estado_catg').selectpicker('val', 'a');
    $("#descripcion").val('');
    $("#cod_area").val('').selectpicker('refresh');
});

var mensaje = function(){
    if($("#m").val() == 'np'){
        toastr.success('Se ha registrado correctamente el producto');
    }else if ($("#m").val() == 'up'){
        toastr.info('Se ha modificado correctamente el producto');
    }else if ($("#m").val() == 'dp'){
        toastr.error('El nombre del producto ya se encuentra registrado');
    }else if ($("#m").val() == 'pp'){
        toastr.warning('El nombre del producto ya se encuentra registrado');
    }
}