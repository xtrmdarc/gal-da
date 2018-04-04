$(function() {
    validarApertura();
    listDelivery();
    listMostrador();
    horaPedido();
    setInterval(horaPedido, 1000);
    mensaje();
    $('#frm-mesa').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
        fields: {
            nomb_cliente: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
        }
    })

    $('#frm-mostrador').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
        fields: {
            nomb_cliente: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
        }
    })

    $('#frm-delivery').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
        fields: {
        }
    })

    $('#frm-cambiar-mesa').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
        fields: {
        }
    })

    .on('success.form.fv', function(e) {
        // Prevent form submission
        e.preventDefault();
        var $form = $(e.target);
        var fv = $form.data('formValidation');
        fv.defaultSubmit();
    });

});

/* Validar apertura de caja */
var validarApertura = function(){
    if($('#cod_ape').val() == 0){
        $('#mdl-validar-apertura').modal('show');
    }
}

/* Hora de pedido */
function horaPedido(){
    moment.locale('es');
    $('input[name^="hora_pe"]').each(function(i) {
        var fechaConvertida = moment($(this).val()).fromNow();
        $("#hora_p"+i).text(fechaConvertida);
    });
}

/* Listar Mostrador */
var listMostrador = function(){
    $('#list-mostrador').empty();
    var moneda = $("#moneda").val();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'inicio/ListarMostrador',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $.each(data, function(i, item) {
                if(item.estado == 'a'){
                    $('#list-mostrador')
                    .append(
                        $('<a href="inicio/pedidoMostrador/'+item.id_pedido+'"/>')
                        .append(
                           $('<li class="warning-element limost"/>')
                            .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html('<strong><i class="fa fa-slack"></i>&nbsp;'+item.nro_pedido+'</strong>')
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<i class="fa fa-clock-o"></i>&nbsp;'+moment(item.fecha_pedido).format('h:mm A'))
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<div class="progress progress-striped active" style="margin-bottom: -20px;">'
                                    +'<div style="width: 100%" aria-valuemax="50" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-warning">'
                                    +'<span>Pedido abierto...</span></div></div>')
                                )
                            .append(
                                $('<div class="col-xs-6 col-sm-6 col-md-6"/>')
                                .html('<i class="fa fa-user"></i>&nbsp;'+item.nomb_cliente)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html(moneda+' '+item.Total.total)
                                )
                            )
                        )
                    );
                } else {
                    $('#list-mostrador')
                    .append(
                        $('<a onclick="liberarPedido('+item.id_pedido+',\''+item.nro_pedido+'\');"/>')
                        .append(
                           $('<li class="success-element limost"/>')
                            .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html('<strong><i class="fa fa-slack"></i>&nbsp;'+item.nro_pedido+'</strong>')
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<i class="fa fa-clock-o"></i>&nbsp;'+moment(item.fecha_pedido).format('h:mm A'))
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<div class="progress progress-striped active" style="margin-bottom: -20px;">'
                                    +'<div style="width: 100%" aria-valuemax="50" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-primary">'
                                    +'<span>Pagado y en espera...</span></div></div>')
                                )
                            .append(
                                $('<div class="col-xs-6 col-sm-6 col-md-6"/>')
                                .html('<i class="fa fa-user"></i>&nbsp;'+item.nomb_cliente)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html(moneda+' '+item.Total.total)
                                )
                            )
                        )
                    );
                }
            });
        }
    });
}

/* Listar Delivery (EN PREPARACION) */
var listDelivery = function(){
    $('#list-preparacion').empty();
    $('#list-enviados').empty();
    var moneda = $("#moneda").val();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'inicio/ListarDelivery',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $.each(data, function(i, item) {
                if(item.estado == 'a'){
                    
                    $('#list-preparacion')
                    .append(
                        $('<a href="inicio/pedidoDelivery/'+item.id_pedido+'"/>')
                        .append(
                           $('<li class="warning-element limost"/>')
                            .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html('<strong><i class="fa fa-slack"></i>&nbsp;'+item.nro_pedido+'</strong>')
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<i class="fa fa-clock-o"></i>&nbsp;'+moment(item.fecha_pedido).format('h:mm A'))
                                )
                            .append(
                                $('<div class="col-xs-4 col-sm-4 col-md-4"/>')
                                .html('<i class="fa fa-building"></i>&nbsp;'+item.direccion)
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2"/>')
                                .html('<i class="fa fa-phone"></i>&nbsp;'+item.telefono)
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2"/>')
                                .html('<i class="fa fa-user"></i>&nbsp;'+item.nomb_cliente)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html(moneda+' '+item.Total.total)
                                )
                            )
                        )
                    );
                } else if(item.estado == 'x') {
                    $('#list-enviados')
                    .append(
                        $('<a onclick="liberarDelivery('+item.id_pedido+',\''+item.nro_pedido+'\');"/>')
                        .append(
                           $('<li class="success-element limost"/>')
                            .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html('<strong><i class="fa fa-slack"></i>&nbsp;'+item.nro_pedido+'</strong>')
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2 text-center"/>')
                                .html('<i class="fa fa-clock-o"></i>&nbsp;'+moment(item.fecha_pedido).format('h:mm A'))
                                )
                            .append(
                                $('<div class="col-xs-4 col-sm-4 col-md-4"/>')
                                .html('<i class="fa fa-building"></i>&nbsp;'+item.direccion)
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2"/>')
                                .html('<i class="fa fa-phone"></i>&nbsp;'+item.telefono)
                                )
                            .append(
                                $('<div class="col-xs-2 col-sm-2 col-md-2"/>')
                                .html('<i class="fa fa-user"></i>&nbsp;'+item.nomb_cliente)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                                .html(moneda+' '+item.Total.total)
                                )
                            )
                        )
                    );
                }
            });
        }
    });
}

/* Registrar mesa */
var registrarMesa = function(cod_mesa,nro_mesa,desc_c){
    $('#cod_mesa').val(cod_mesa);
    $("#mdl-mesa").modal('show');
    $("#mtm").html('Mesa '+ nro_mesa);
    $("#mtp").html(desc_c);
}

/* Combo mesa origen */
var comboMesaOrigen = function(cod){
    $('#c_mesa').selectpicker('destroy');
    $.ajax({
        type: "POST",
        url: "/inicio/ComboMesaOri",
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {cod: cod},
        success: function (response) {
            $('#c_mesa').html(response);
            $('#c_mesa').selectpicker();
        },
        error: function () {
            $('#c_mesa').html('There was an error!');
        }
    });
}

/* Combo mesa destino */
var comboMesaDestino = function(cod){
    //var cod = $('#co_salon').val();
    $('#co_mesa').selectpicker('destroy');
    $.ajax({
        type: "POST",
        url: "/inicio/ComboMesaDes",
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {cod: cod},
        success: function (response) {
            $('#co_mesa').html(response);
            $('#co_mesa').selectpicker();
        },
        error: function () {
            $('#co_mesa').html('There was an error!');
        }
    });
}

/* Combo salon origen */
$('#cbo-salon-o').change( function() {
    var cod = $('#cbo-salon-o').val();
    comboMesaOrigen(cod);
    $('#frm-cambiar-mesa').formValidation('revalidateField', 'c_mesa');
});

/* Combo salon destino */
$('#cbo-salon-d').change( function() {
    var cod = $('#cbo-salon-d').val();
    comboMesaDestino(cod);
});

/* Liberar Pedido Mostrador*/
var liberarPedido = function(cod,nro){
    var moneda = $("#moneda").val();
    $("#codPed").val(cod);
    $('#lista_p').empty();
    $(".title-d").html('Detalle del Pedido <i class="fa fa-slack"></i>&nbsp;'+nro);
    $("#mdl-detped").modal('show');
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      dataSrc:'',   
      headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/inicio/DetalleMostrador',
      success: function (data){
        $.each(data, function(i, item) {
            var calc = item.precio * item.cantidad;
            var opc = item.estado;
            switch(opc){
                case 'a':
                    estado = '<span class="label label-primary">S</span>'
                break;
                case 'p':
                    estado = '<span class="label label-warning">P</span>'
                break;
                case 'c':
                    estado = '<span class="label label-success">D</span>'
                break;
            }
            $('#lista_p')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.cantidad))
                .append($('<td/>').html(estado+' '+item.Producto.nombre_prod+' <span class="label label-primary">'+item.Producto.pres_prod+'</span>'))
                .append($('<td/>').html(moneda+' '+item.precio))
                .append($('<td class="text-right"/>').html(moneda+' '+(calc).toFixed(2)))
                );
            });
        }
    });
}

/* Liberar Pedido Delivery */
var liberarDelivery = function(cod,nro){
    var moneda = $("#moneda").val();
    $("#codPed").val(cod);
    $('#lista_p').empty();
    $(".title-d").html('Detalle del Pedido <i class="fa fa-slack"></i>&nbsp;'+nro);
    $("#mdl-detped").modal('show');
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      url: '/inicio/DetalleDelivery',
      success: function (data){
        $.each(data, function(i, item) {
            var calc = item.precio * item.cantidad;
            var opc = item.estado;
            switch(opc){
                case 'a':
                    estado = '<span class="label label-primary">S</span>'
                break;
                case 'p':
                    estado = '<span class="label label-warning">P</span>'
                break;
                case 'c':
                    estado = '<span class="label label-success">D</span>'
                break;
            }
            $('#lista_p')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.cantidad))
                .append($('<td/>').html(estado+' '+item.Producto.nombre_prod+' <span class="label label-primary">'+item.Producto.pres_prod+'</span>'))
                .append($('<td/>').html(moneda+' '+item.precio))
                .append($('<td class="text-right"/>').html(moneda+' '+(calc).toFixed(2)))
                );
            });
        }
    });
}

/* Boton cambiar mesa */
$('.btn-cm').click( function() {
    var cod = $('#cbo-salon-o').val();
    var cdm = $('#cbo-salon-d').val();
    comboMesaOrigen(cod);
    comboMesaDestino(cdm);
});

$('#mdl-mesa').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-mesa').formValidation('resetForm', true);
    $("#cod_mozo").val('').selectpicker('refresh');
});

$('#mdl-mostrador').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-mostrador').formValidation('resetForm', true);
});

$('#mdl-cambiar-mesa').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-cambiar-mesa').formValidation('resetForm', true);
    $("#c_mesa").val('').selectpicker('refresh');
    $("#co_mesa").val('').selectpicker('refresh');
});

$('#mdl-delivery').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-delivery').formValidation('resetForm', true);
});

var mensaje = function(){
    if($("#cod_m").val() == 'd'){
        toastr.warning('Advertencia, Mesa ocupada.');
    }else if ($("#cod_m").val() == 'f'){
        toastr.warning('Advertencia, La mesa ya ha sido facturada.');
    }
}

var refresh = function(){
    location.reload();
};