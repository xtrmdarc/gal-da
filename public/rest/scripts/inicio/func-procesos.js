$(function() {
    DatosGrles();
    listarPedidos();
    listarCategorias();
    if (screen.height<=768){
        if($('#rol_usr').val() != 4){
            yizq=425;
        } else {
            yizq='100%';
        }
        yder=493;
    };
    /*$('.scroll_izq').slimscroll({
        height: yizq
    });
    $('.scroll_der').slimscroll({
        height: yder
    });
    */
});

function numberFormat(numero){
    var resultado = "";
    if(numero[0]=="-"){
        nuevoNumero=numero.replace(/\./g,'').substring(1);
    }else{
        nuevoNumero=numero.replace(/\./g,'');
    }
 
    if(numero.indexOf(",")>=0)
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf(","));
 
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ",": "") + resultado;

    if(numero.indexOf(",")>=0)
        resultado+=numero.substring(numero.indexOf(","));
 
    if(numero[0]=="-"){
        return "-"+resultado;
    }else{
        return resultado;
    }
}

var DatosGrles = function(){
    var moneda = $("#moneda").val();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '/inicio/DatosGrles',
        data: {
            cod: $('#cod_p').val(),
            tp: $('#cod_tipe').val()
        },
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var sbtot = 0;
            var total = 0;
            $.each(data.Detalle, function(i, item) {
                var importe = (item.cantidad * item.precio).toFixed(2);
                if(item.estado != 'i' && item.cantidad > 0){
                    sbtot = parseFloat(importe) + parseFloat(sbtot);   
                }
            });
            total = parseFloat(sbtot) + parseFloat(total);
            $('#totalPagar').text(moneda+' '+(total).toFixed(2));
            $('#totalPed').val(total.toFixed(2));
            if(total != '0.00'){
                $('.opc1').css('display','block');
                $('.opc2').css('display','none');
            }else{
                $('.opc1').css('display','none');
                $('.opc2').css('display','block');
            };
            if(data.id_tipo_p == 1){
                $('.mes_dg').text(data.nro_mesa);
                $("#ico-ped").addClass("fa fa-cutlery");
            }else if(data.id_tipo_p == 2 || data.id_tipo_p == 3){
                $('.mes_dg').text(data.nro_pedido);
                $("#ico-ped").addClass("fa fa-slack");
            }
            $('#cod_tipe').val(data.id_tipo_p);
            $('.cli_dg').text(data.nomb_c);
            $('.fec_dg').text(moment(data.fecha_p).format('DD-MM-Y'));
            $('.hor_dg').text(moment(data.fecha_p).format('h:mm A'));
            $('.btn-imp').html('<a onclick="impPreCuenta('+data.id_pedido+','+data.id_mesa+',\''+data.est_m+'\')" class="btn btn-botija btn-lg"><i class="fa fa-print"></i></a>');
            console.log('funciona');
        }
    });
};    

var listarPedidos = function(){
    var moneda = $("#moneda").val();
    var table = $('#table-pedidos')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "/inicio/ListarPedidos", 
               
            "headers":{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "data": {
                cod: $('#cod_p').val()
            }
        },
        "columns":[
            {
                "data": null,
                "className": 'check-mail tdi',
                "render": function ( data, type, row) {
                    return data.cantidad;
                }
            },
            {
                "data": null,
                "className": 'mail-contact',
                "render": function ( data, type, row) {
                    if($('#rol_usr').val() != 4){
                        return '<a onclick="subPedido('+$('#cod_p').val()+','+data.id_prod+');">'+data.Producto.nombre_prod+' ['+data.Producto.pres_prod+']</a>';
                    } else {
                        return data.Producto.nombre_prod+' ['+data.Producto.pres_prod+']';
                    }
                }
            },
            {
                "data": null,
                "className": 'text-right mail-date',
                "render": function ( data, type, row) {
                    return moneda+data.precio;
                }
            },
            {
                "data": null,
                "className": 'text-right mail-date',
                "render": function ( data, type, row) {
                    var total = (data.cantidad * data.precio).toFixed(2);
                    return moneda+total;
                }
            }
        ]
    });
};

var listarCategorias = function(){
    $('#list-catgrs').empty();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/inicio/ListarCategorias',

        success: function (data) {
            $.each(data, function(i, item) {
                $('#list-catgrs')
                    .append(
                    $('<li class="col-sm-3" />')
                        .append(
                            $('<a data-toggle="tab" href="#tab-1" onclick="listarProductos('+item.id_catg+');"/>')
                            .html(item.descripcion)
                        )
                    );
            });
        }
    });
}

var listarProductos = function(cod){
    var moneda = $("#moneda").val();
    $('#list-prods').empty();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/inicio/ListarProductos',
        data: {cod: cod},
        success: function (data) {
            $.each(data, function(i, item) {
                $('#list-prods')
                    .append(
                    $('<div class="col-xs-2" style="width: 155px !important; padding-right: 0 !important; padding-left: 20px !important;"/>')
                    .append(
                        $('<div class="ibox" style="margin-bottom: 10px !important;"/>')
                        .append(
                            $('<div class="ibox-content product-box" onclick="add('+item.id_pres+',\''+item.nombre_prod+' ['+item.pres_prod+']\','+item.precio+');"  style="height: 130px !important; cursor: pointer;"/>')
                            .append(
                                $('<div class="product-desc"/>')
                                .html('<span class="product-price">'+moneda+' '+item.precio+'</span><div class="small m-t-xs"><br></div>')
                            )
                            .append(
                                $('<div class="product-imitation"/>')
                                .html(item.nombre_prod+'<br><b>['+item.pres_prod+']</b>')
                            )
                        )
                    )
                );
            });
        }
    });
};

var add = function(id,nomb,pre){
    $("#pedido-detalle").css('display','block');
    $(".bc").css('display','block');
    pedido.registrar({
        producto_id: parseInt(id),
        producto: nomb,
        cantidad: parseInt(1),
        precio: parseFloat(pre),
        comentario: "",
    });
};

$("#btn-confirmar").on("click", function(){
    if(pedido.detalle.items.length == 0)
    {
        toastr.warning('Advertencia, Agregar producto(s) a la lista.');
        return false;
    }else{
        pedido.detalle.cod_p = $("#cod_p").val();
        $.ajax({
            type: 'POST',
            url: '/inicio/RegistrarPedido',
            data: pedido.detalle,
            dataSrc:'',   
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if(data == 1){
                    DatosGrles();
                    listarPedidos();
                    pedido.detalle.items.length = 0;
                    $('#pedido-detalle').empty();
                    $("#pedido-detalle").css('display','none');
                    $(".bc").css('display','none');
                    return false;
                } else if (data == 2){
                    window.open('inicio.php?Cod=f','_self');
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown + ' ' + textStatus);
            }   
        });
    }
});

var pedido = {
    detalle: {
        cod_p:    0,
        total: 0,
        igv: 0,
        subtotal: 0,
        items: []
    },

    /* Encargado de agregar un producto a nuestra colección */
    registrar: function(item)
    {
        var existe = false;
        
        item.total = (item.cantidad * item.precio);
        
        this.detalle.items.forEach(function(x){
            if(x.producto_id === item.producto_id) {
                x.cantidad += item.cantidad;
                x.total += item.total;
                existe = true;
            }
        });

        if(!existe) {
            this.detalle.items.push(item);
        }

        this.refrescar();
    },

    /* Encargado de actualizar el precio/cantidad de un producto */
    actualizar: function(id, row)
    {
        /* Capturamos la fila actual para buscar los controles por sus nombres */
        row = $(row).closest('.warning-element');

        /* Buscamos la columna que queremos actualizar */
        $(this.detalle.items).each(function(indice, fila){
            if(indice == id)
            {
                /* Agregamos un nuevo objeto para reemplazar al anterior */
                pedido.detalle.items[indice] = {
                    producto_id: row.find("input[name='producto_id']").val(),
                    producto: row.find("span[name='producto']").text(),
                    comentario: row.find("input[name='comentario']").val(),
                    cantidad: row.find("input[name='cantidad']").val(),
                    precio:   row.find("input[name='precio']").val(),
                };

                pedido.detalle.items[indice].total = pedido.detalle.items[indice].precio * pedido.detalle.items[indice].cantidad;

                return false;
            }
        })

        this.refrescar();

    },

    /* Encargado de retirar el producto seleccionado */
    retirar: function(id)
    {
        /* Declaramos un ID para cada fila */
        $(this.detalle.items).each(function(indice, fila){
            if(indice == id)
            {
                pedido.detalle.items.splice(id, 1);
                return false;
            }
        })

        this.refrescar();
    },

    /* Refresca todo los productos elegidos */
    refrescar: function()
    {
        this.detalle.total = 0;

        /* Declaramos un id y calculamos el total */
        $(this.detalle.items).each(function(indice, fila){
            pedido.detalle.items[indice].id = indice;
            pedido.detalle.total += fila.total;
        })

        /* Calculamos el subtotal e IGV */
        this.detalle.igv      = (this.detalle.total * 0.18).toFixed(2); // 18 % El IGV y damos formato a 2 deciamles
        this.detalle.subtotal = (this.detalle.total - this.detalle.igv).toFixed(2); // Total - IGV y formato a 2 decimales
        this.detalle.total    = this.detalle.total.toFixed(2);
        
        $.views.settings.delimiters("[%", "%]");
        var template   = $.templates("#pedido-detalle-template");
        var htmlOutput = template.render(this.detalle);

        $("#pedido-detalle").html(htmlOutput);

        if(this.detalle.total == 0){
            $("#pedido-detalle").css('display','none');
            $(".bc").css('display','none');
        }

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-warning',
            buttonup_class: 'btn btn-warning',
            min: 1,
            max: 99,
            step: 1,
            booster: false,
            stepintervaldelay: 600000
        });
    },

    comentar: function(id)
    {
        $("#com"+id).each(function(i) {
            if ( this.style.display !== "block" ) {
                this.style.display = "block";

            } else {
                this.style.display = "none";
            }
            return false;
        });
        
    },
};

$(function() {
/* Buscar producto */
$("#busq_prod").autocomplete({
    delay: 1,
    autoFocus: true,
    source: function (request, response) {
        $.ajax({
            url: '/inicio/BuscarProducto',
            type: "post",
            dataType: "json",
            dataSrc:'',   
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                criterio: request.term
            },
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        id: item.id_pres,
                        cod_pro: item.cod_prod,
                        nombre: item.nombre_prod+' ['+item.pres_prod+']',
                        precio: item.precio
                    }
                }))
            }
        })
    },
    select: function (e, ui) {

        $("#busq_prod").val(ui.item.nombre);

        var producto = $("#busq_prod");
        //var comentarios = "blue";

        pedido.registrar({
            producto_id: parseInt(ui.item.id),
            producto: producto.val(),
            cantidad: parseInt(1),
            precio: parseFloat(ui.item.precio),
            comentario: "",
        });
  
        $("#busq_prod").val('');
        $("#busq_prod").focus();
        $("#pedido-detalle").css('display','block');
        $(".bc").css('display','block');

        return false;   
    },
    change: function() {
        $("#busq_prod").val('');
        $("#busq_prod").focus();
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $('<li>')
    .append(item.cod_pro+' - '+item.nombre)
    .appendTo( ul );
};

/* Buscar cliente */
date = moment(new Date());
var diactual = moment(date).format('D MMMM');
$("#busq_cli").autocomplete({
    delay: 1,
    autoFocus: true,
    source: function (request, response) {
        $.ajax({
            url: '/inicio/BuscarCliente',
            type: "post",
            dataType: "json",
            dataSrc:'',   
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                criterio: request.term
            },
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        id: item.id_cliente,
                        dni: item.dni,
                        nombres: item.nombre,
                        fecha_n: item.fecha_nac
                    }
                }))
            }
        })
    },
    select: function (e, ui) {

        /* Validar si cumple años el cliente */
        var cumple = moment(ui.item.fecha_n).format('D MMMM');
        $("#cliente_id").val(ui.item.id);
        $("#nombre_c").val(ui.item.nombres);
        if(diactual == cumple){
            $("#hhb").addClass("mhb");
        }
        $(this).blur(); 

    },
    change: function() {
        $("#busq_cli").val('');
        $("#busq_cli").focus();
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append(item.nombres)
    .appendTo( ul );
};

$("#busq_cli").autocomplete("option", "appendTo", ".frm-facturar");

});

/* Sub pedido de la lista */
var subPedido = function(cod,prod){
    var moneda = $("#moneda").val();
    $('#list-subitems').empty();
    var tp = $('#cod_tipe').val();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '/inicio/ListarDetalleSubPed',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {tp: tp, cod: cod, prod: prod},
        success: function (data) {
            $.each(data.Detalle, function(i, item) {
                var calc = (item.cantidad * item.precio).toFixed(2);
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

                if (item.estado != 'i'){
                    $('#list-subitems')
                    .append(
                        $('<li class="success-element liwrithe"/>')
                        .append(
                            $('<div class="row"/>')
                            .append('<div style="display:none" >'+ item.id_det_ped +'</div>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1" />')
                                .html(item.cantidad)
                                )
                            .append(
                                $('<div class="col-xs-6 col-sm-6 col-md-6" />')
                                .html(estado+' '+item.Producto.nombre_prod+' '+item.Producto.pres_prod)
                                )
                            .append(
                                $('<div class="col-xs-4 col-sm-4 col-md-4" />')
                                .html(moneda+''+item.precio+' - '+moneda+' '+calc)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1 text-right" />')
                                .html('<button type="button" class="btn btn-xs btn-danger pull-right"'
                                +'onclick="cancelarPedido('+item.id_det_ped+','+cod+','+item.id_prod+',\''+item.cantidad+' '+item.Producto.nombre_prod+' '+item.Producto.pres_prod+'\',\''+item.fecha_pedido+'\')">'
                                +'<i class="fa fa-times"></i></button>')
                                )
                        )
                    );
                } else {
                    $('#list-subitems')
                    .append(
                        $('<li class="danger-element bg"/>')
                        .append(
                            $('<div class="row"/>')
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1 todo-completed" />')
                                .html(item.cantidad)
                                )
                            .append(
                                $('<div class="col-xs-6 col-sm-6 col-md-6 todo-completed" />')
                                .html(item.Producto.nombre_prod+' '+item.Producto.pres_prod)
                                )
                            .append(
                                $('<div class="col-xs-4 col-sm-4 col-md-4 todo-completed" />')
                                .html(moneda+''+item.precio+' - '+moneda+' '+calc)
                                )
                            .append(
                                $('<div class="col-xs-1 col-sm-1 col-md-1 todo-completed" />')
                                .html('')
                            )
                        )
                    );
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
    $("#mdl-sub-pedido").modal('show');
}

/* Cancelar pedido de la lista */
var cancelarPedido = function(cod_det_ped,cod_ped,cod_pro,des_ped,fec_ped){
    
    $('#cod_det_ped').val(cod_det_ped);
    $('#cod_ped').val(cod_ped);
    $('#cod_pro').val(cod_pro);
    $('#fec_ped').val(fec_ped);      
    $("#mdl-cancelar-pedido").modal('show');
    $("#mensaje-e").html('<center>¿Estas seguro de eliminar el pedido?<br><br><strong>'+des_ped+'</strong></center>');       
}

/* Desocupar mesa */
var desocuparMesa = function(cod_ped){    
    $('#cod_pede').val(cod_ped);
    $("#mdl-desocupar-mesa").modal('show');      
}

/* Imprimir Pre Cuenta*/
var impPreCuenta = function(ped,cod,est){
    $.ajax({
        url: '/inicio/preCuenta',
        type: "post",
        dataType: "json",
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            cod: cod,
            est: est
        },
        success: function (r) {
            return true;
        }
    }).done(function(){
        var ini = window.open('pedido_mesa.php?c=Inicio&a=ImprimirPC&Cod='+ped,'_blank');
    }); 
}

var facturar = function(cod,tip){
    $('#list-items').empty();
    $('#cod_pedido').val(cod);
    $('#tipoEmision').val(tip);
    var tp = $('#cod_tipe').val();
    var moneda = $("#moneda").val();
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '/inicio/ListarDetallePed',
        dataSrc:'',   
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {cod: cod, tp: tp},
        success: function (data) {
            $.each(data.Detalle, function(i, item) {
                var totped = $("#totalPed").val();
                var calc = (item.cantidad * item.precio).toFixed(2);
                if (1 == tip && item.cantidad > 0){
                    $(".totalP").text(totped);
                    $("#total_pedido").val(totped);
                    $('#list-items')
                    .append(
                    $('<li class="success-element liwrithe"/>')
                    .append(
                        $('<div class="row"/>')
                        .append(
                            $('<div class="col-xs-1 col-sm-1 col-md-1"/>')
                            .html('<input type="hidden" name="cantProd[]" value="'+item.cantidad+'"/>'
                                +'<input type="hidden" name="precProd[]" value="'+item.precio+'"/>'
                                +item.cantidad)
                            )
                        .append(
                            $('<div class="col-xs-8 col-sm-8 col-md-8"/>')
                            .html('<input type="hidden" name="idProd[]" value="'+item.id_prod+'"/>'
                                +item.Producto.nombre_prod+' '+item.Producto.pres_prod)
                            )
                        .append(
                            $('<div class="col-xs-3 col-sm-3 col-md-3 text-right"/>')
                            .html(moneda+' '+calc)
                            )
                        )
                    );
                } else if (2 == tip && item.cantidad > 0){
                    $(".totalP").text('0.00');
                    $("#total_pedido").val(0.00);
                    $("#t_sbt").text('0.00');
                    $('#list-items')
                    .append(
                    $('<li class="success-element priceU" data-price="'+item.precio+'"/>')
                    .append(
                        $('<div class="row"/>')
                        .append(
                            $('<div class="col-xs-2 col-sm-2 col-md-2"/>')
                            .html('<input type="hidden" class="cantidad" name="cantProd[]" value="0"/>'
                                +'<input type="hidden" name="precProd[]" value="'+item.precio+'"/>'
                                +'<input type="hidden" value="'+item.cantidad+'" class="cantOrg"/>'
                                +'<input type="hidden" value="1" class="cantTemp"/>'
                                +'<b></b> '+item.cantidad)
                            )
                        .append(
                            $('<div class="col-xs-7 col-sm-7 col-md-7"/>')
                            .html('<input type="hidden" name="idProd[]" value="'+item.id_prod+'"/>'
                                +item.Producto.nombre_prod+' '+item.Producto.pres_prod)
                            )
                        .append(
                            $('<div class="col-xs-3 col-sm-3 col-md-3 text-right"/>')
                            .html(moneda+' <span>0.00</span>')
                            )
                        )
                    );
                }

            });

            $(".priceU").on("click",function(){
                var totalTemp = $(this).find(".cantTemp").val();
                $(this).css('cssText','background: #6ec89b !important; color: #ffffff !important;');
                $(this).find(".cantTemp").val(parseInt(totalTemp)+1);
                var totalCant = $(this).find(".cantOrg").val();
                var cantB = parseInt(totalCant) - 1;
                $(this).find("b").text(totalTemp+' /');
                var valorItem = $(this).find("span").text();
                var valorPrice = $(this).attr("data-price");
                var totalItem = (parseFloat(valorItem)+parseFloat(valorPrice)).toFixed(2);
                $(this).find("span").text(totalItem);
                var totalGneral=0;
                $(this).find(".cantidad").val(totalTemp);
                if(parseInt(totalCant) < parseInt(totalTemp)){
                    $(this).find(".cantTemp").val(1);
                    $(this).css('cssText','background: none !important');
                    $(this).find("span").text('0.00');
                    $(this).find("b").text('');
                    $(this).find(".cantidad").val(0);
                }
                $(".priceU").each(function() {
                  totalGneral += parseFloat($( this ).find("span").text());
                });
                $(".totalP").text((totalGneral).toFixed(2));
                $("#total_pedido").val(totalGneral);
                $("#t_sbt").text((totalGneral).toFixed(2));
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });
    $("#mdl-facturar").modal('show');
}

$("#frm-facturar").submit(function(){
    
    if($("#total").text() == '0.00'){
        toastr.warning('Advertencia, Seleccionar item de la lista.');
        return false;
    }else if($("#tipo_pago").find("option:selected").val() == ''){
        toastr.warning('Advertencia, Seleccionar tipo de pago.');
        return false;
    }else if($("#tipo_doc").val() == ""){
        toastr.warning('Advertencia, Seleccionar tipo de documento.');
        return false;
    }else if($("#cliente_id").val() == ""){
        toastr.warning('Advertencia, Agregar un cliente al comprobante.');
        return false;
    }else{
        var form = $(this);
        var venta = {
            tipo_pedido: 0,
            tipoEmision: 0,
            cod_pedido: 0,
            cliente_id: 0,
            tipo_doc: 0,
            tipo_pago: 0,
            pago_t: 0,
            m_desc: 0,
            total_pedido: 0,
            idProd: [],
            cantProd: [],
            precProd: []
        }

        venta.tipo_pedido = $('#cod_tipe').val();
        venta.tipoEmision = $('#tipoEmision').val();
        venta.cod_pedido = $('#cod_pedido').val();
        venta.cliente_id = $('#cliente_id').val();
        venta.tipo_doc = $('#tipo_doc').val();
        venta.tipo_pago = $('#tipo_pago').val();
        venta.pago_t = $('#pago_t').val();
        venta.m_desc = $('#m_desc').val();
        venta.total_pedido = $('#total_pedido').val();
        venta.idProd = $("input[name='idProd[]']").map(function(){return $(this).val();}).get();
        venta.cantProd = $("input[name='cantProd[]']").map(function(){return $(this).val();}).get();
        venta.precProd = $("input[name='precProd[]']").map(function(){return $(this).val();}).get();

        var cod = $('#cod_pedido').val();
       
        $.ajax({
            //dataType: 'JSON',
            type: 'POST',
            url: '/inicio/RegistrarVenta',
            dataSrc:'',   
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: venta,
            success: function (r) {
                if(1 == $('#tipoEmision').val()){
                    if(r) var ini = window.open('/inicio');
                } else if (2 == $('#tipoEmision').val()){
                    if(1 == $('#cod_tipe').val()){
                        //if(r) var ini = window.open('pedido_mesa.php?Cod='+cod,'_self');
                        if(r) var ini = window.open('/inicio/PedidoMesa/'+cod,'_self');
                    } else if(2 == $('#cod_tipe').val()){
                        //if(r) var ini = window.open('pedido_mostrador.php?Cod='+cod,'_self');
                        if(r) var ini = window.open('/inicio/PedidoMostrador/'+cod,'_self');
                    } else if(3 == $('#cod_tipe').val()){
                        //if(r) var ini = window.open('pedido_delivery.php?Cod='+cod,'_self');
                        if(r) var ini = window.open('/inicio/PedidoDelivery/'+cod,'_self');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown + ' ' + textStatus);
            }   
        }).done(function(){
            var ini = window.open('?c=Inicio&a=Imprimir&Cod='+cod,'_blank');
        });
        return false;
    }
});


/* DISEÑO Porcentaje del total de la cuenta */
var porcentajeTotal = function(){
    $("#desc").each(function(i) {
        if ( this.style.display !== "block" ) {
            this.style.display = "block";
            $("#sbt").css("display","block");
            var total = $("#total").text();
            $("#t_sbt").text(total);
            $("#pago_e").val('0.00');
            $("#pago_t").val('0.00');
            $("#vuelto").text('0.00');
        } else {
            this.style.display = "none";
            var s_total = $("#t_sbt").text();
            $("#total").text(s_total);
            $("#sbt").css("display","none");
            $("#pago_e").val('0.00');
            $("#pago_t").val('0.00');
            $("#vuelto").text('0.00');
            $("#porcentaje").val('');
            $("#m_desc").val('');
        }
        return false;
    });
}

/* Tipo de pagos */
$('#tipo_pago').on('change', function(){
    var selected = $(this).find("option:selected").val();
    if (selected == 1) {
        $("#pago_e").val('');
        $("#pago_t").val('');
        $("#pt").css("display","none");
        $("#pe").css("display","block");
        $("#vuelto").text('0.00');
        $("#pago_t").val('0.00');
    }else if(selected == 2){
        $("#pago_e").val('');
        $("#pago_t").val('');
        $("#pe").css("display","none");
        $("#pt").css("display","block");
        $("#vuelto").text('0.00');
        $("#pago_e").val('0.00');
    }else if(selected == 3){
        $("#pago_e").val('');
        $("#pago_t").val('');
        $("#pe").css("display","block");
        $("#pt").css("display","block");
        $("#vuelto").text('0.00');
    }
});

/* Pago efectivo */
$('#pago_e').on('keyup', function(){

    var total = $("#total").text();
    var pago_e = $("#pago_e").val();
    var pago_t =  $("#pago_t").val();

    var cal = (parseFloat(pago_e) + parseFloat(pago_t));
    var calculo = (parseFloat(cal) - parseFloat(total)).toFixed(2);

    if(isNaN(calculo)){
        calculo = 0;
    }

    $("#vuelto").text(calculo);
});

/* Pago tarjeta */
$('#pago_t').on('keyup', function(){
    var total = $("#total").text();
    var pago_e = $("#pago_e").val();
    var pago_t =  $("#pago_t").val();

    var cal = (parseFloat(pago_e) + parseFloat(pago_t));
    var calculo = (parseFloat(cal) - parseFloat(total)).toFixed(2);

    if(isNaN(calculo)){
        calculo = 0;
    }

    $("#vuelto").text(calculo);
});

/* Calculo del porcentaje desde porcentaje */
$('#porcentaje').on('keyup', function(){
    var s_total = $("#t_sbt").text();
    var por = ($("#porcentaje").val() / 100).toFixed(2);
    var cal = (s_total * por).toFixed(2);
    $("#m_desc").val(cal);
    var total = (s_total - cal).toFixed(2);
    $("#total").text(total);        
});

/* Calculo del porcentaje desde entero o decimal (dinero)*/
$('#m_desc').on('keyup', function(){
    var s_total = $("#t_sbt").text();
    var desc = $("#m_desc").val();
    var total = (s_total - desc).toFixed(2);
    $("#total").text(total);
    $("#porcentaje").val('');       
});

/* Boton limpiar datos del cliente (modal) */
$("#btnClienteLimpiar").click(function() {
    $("#cliente_id").val('');
    $("#cliente").val('');
    $("#nombre_c").val('');
    $("#cliente").focus();
    $("#hhb").removeClass("mhb");
});

$(".ent input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9]')!=0 && keycode!=8){
        return false;
    }
});

$(".dec input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9.]')!=0 && keycode!=8){
        return false;
    }
});