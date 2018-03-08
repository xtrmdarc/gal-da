var compra = {
    detalle: {
        cod_prov: 0,
        compra_fecha: 0,
        compra_hora: 0,
        tipo_doc: 0,
        serie_doc: '',
        num_doc: '',
        tipo_compra: 0,
        monto_total: 0,
        desc_comp: 0,
        nro_cuotas: 0,
        monto_int: 0,
        mmcuota: [],
        imcuota: [],
        fmcuota: [],
        observaciones: 0,
        igv:      0,
        total:    0,
        subtotal: 0,
        items: []
    },

    /* Encargado de agregar un producto a nuestra colección */
    registrar: function(item)
    {
        
        item.total = (item.cant_ins * item.precio_ins);
        
        var existe = false;
        this.detalle.items.forEach(function(x){
            if(x.cod_ins === item.cod_ins && x.tipo_p === item.tipo_p) {
                x.cant_ins += item.cant_ins;
                //x.precio_ins += item.precio_ins;
                x.total += item.total;
                existe = true;
            }
        });

        if(!existe) this.detalle.items.push(item);

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
                compra.detalle.items[indice] = {
                    tipo_p: row.find("input[name='tipo_p']").val(),
                    cod_ins: row.find("input[name='cod_ins']").val(),
                    nomb_ins: row.find("label[name='nomb_ins']").text(),
                    desc_ins: row.find("label[name='desc_ins']").text(),
                    cant_ins: row.find("input[name='cant_ins']").val(),
                    precio_ins: row.find("input[name='precio_ins']").val(),
                };

                compra.detalle.items[indice].total = compra.detalle.items[indice].precio_ins * compra.detalle.items[indice].cant_ins;
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
                compra.detalle.items.splice(id, 1);
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
            compra.detalle.items[indice].id = indice;
            compra.detalle.total += fila.total;
        })

        /* Calculamos el subtotal e IGV */
        this.detalle.igv      = (this.detalle.total * 0.18).toFixed(2); // 18 % El IGV y damos formato a 2 deciamles
        this.detalle.subtotal = (this.detalle.total - this.detalle.igv).toFixed(2); // Total - IGV y formato a 2 decimales
        this.detalle.total    = (this.detalle.total).toFixed(2);

        var template   = $.templates("#compra-detalle-template");
        var htmlOutput = template.render(this.detalle);
        var da = this.detalle.total;

        $("#compra-detalle").html(htmlOutput);
        $("#monto_con").val(da);
        $("#monto_cre").val(da);
        montoTotal();
    }
}

$('#btn-agregar').click(function() {
    if($('#insumo_id').val() == '' || $('#insumo_id').val() == '0'){
        toastr.warning('Advertencia, Buscar y seleccionar un producto o insumo.');
        return false;
    }
    else if($('#cant_bins').val() == ''){
        toastr.warning('Advertencia, Agregar una cantidad.');
        return false;
    } else if($('#precio_bins').val() == ''){
        toastr.warning('Advertencia, Agregar un precio.');
        return false;
    } else {
        compra.registrar({
            tipo_p: parseInt($("#tipo_prod").val()),
            cod_ins: parseInt($("#insumo_id").val()),
            nomb_ins: $("#b_insumo").val(),
            desc_ins: $("#desc_um").text(),
            cant_ins: parseFloat($("#cant_bins").val()),
            precio_ins: parseFloat($("#precio_bins").val()),
        });
        $("#insumo_id").val('');
        $("#b_insumo").val('');
        $("#cant_bins").val('');
        $("#precio_bins").val('');
        $("#b_insumo").focus();
        montoTotal();
    }
})

$(function() {
    /* Busqueda de insumo/producto */
    $("#b_insumo").autocomplete({
        autoFocus: true,
        dataType: 'JSON',
        delay: 1,
        source: function (request, response) {
            jQuery.ajax({
                url: '?c=Compra&a=BuscarIns',
                type: "post",
                dataType: "json",
                data: {
                    criterio: request.term
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            id: item.id_ins,
                            tipop: item.tipo_p,
                            value: item.cod_ins + ' ['+item.nomb_ins+']',
                            nombre: item.cod_ins + ' ['+item.nomb_ins+']',
                            desc_m: item.descripcion
                        }
                    }))
                }
            })
        },
        select: function (e, ui) {
            $("#b_insumo").val(ui.item.nombre);
            $("#tipo_prod").val(ui.item.tipop)
            $("#insumo_id").val(ui.item.id);
            $("#desc_um").html(ui.item.desc_m);
            $("#cantidad").focus();
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $('<li>')
        .append(item.nombre)
        .appendTo( ul );
    };

    $('.DatePicker').on('changeDate', function(e) {
        $('#form-compra').formValidation('revalidateField', 'compra_fecha');
    });

    $('.clockpicker').on('change', function(e) {
        $('#form-compra').formValidation('revalidateField', 'compra_hora');
    });

    $('#form-compra').formValidation({
        framework: 'bootstrap',
        fields: {
        }
    })

    .on('success.form.fv', function(e) {

        var form = $(this);

        if(compra.detalle.items.length == 0)
        {
            toastr.warning('Advertencia, Agregar producto(s) a la lista.');
            return false;
        }
        else if($('#cod_prov').val() == 0)
        {
            toastr.warning('Advertencia, Agregar un proveedor a la compra.');
            return false;
        }
        else{

            if($('input:radio[name=tipo_compra]:checked').val() == 2){
                if($('#monto_cre').val() == '0.00' || $('#monto_cre').val() == ''){
                $('#mensaje-cre').empty();
                $('#mensaje-cre').html('<div class="alert alert-warning">'
                    +'<i class="fa fa-warning"></i> Ingresar el monto total de la compra. <a class="alert-link" data-toggle="modal" data-target="#mdl-compra-credito">AQUI</a>.'
                    +'</div>');
                return false;
            }else{

                compra.detalle.cod_prov = $('#cod_prov').val();
                compra.detalle.compra_fecha = $('#compra_fecha').val();
                compra.detalle.compra_hora = $('#compra_hora').val();
                compra.detalle.tipo_doc = $('.selectpicker').selectpicker('val');
                compra.detalle.serie_doc = $('#serie_doc').val();
                compra.detalle.num_doc = $('#num_doc').val();
                compra.detalle.tipo_compra = $('input:radio[name=tipo_compra]:checked').val();
                compra.detalle.monto_total = $('#monto_cre').val();
                compra.detalle.mmcuota = $("input[name='mmcuota[]']").map(function(){return $(this).val();}).get();
                compra.detalle.imcuota = $("input[name='imcuota[]']").map(function(){return $(this).val();}).get();
                compra.detalle.fmcuota = $("input[name='fmcuota[]']").map(function(){return $(this).val();}).get();
                compra.detalle.observaciones = $('#observaciones').val();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: compra.detalle,
                    success: function (r) {
                        if(r) window.location.href = '?c=Compra';
                        console.log(compra.detalle);
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(errorThrown + ' ' + textStatus);
                    }   
                });
            }

            return false;

        } else {

            compra.detalle.cod_prov = $('#cod_prov').val();
            compra.detalle.compra_fecha = $('#compra_fecha').val();
            compra.detalle.compra_hora = $('#compra_hora').val();
            compra.detalle.tipo_doc = $('.selectpicker').selectpicker('val');
            compra.detalle.serie_doc = $('#serie_doc').val();
            compra.detalle.num_doc = $('#num_doc').val();
            compra.detalle.tipo_compra = $('input:radio[name=tipo_compra]:checked').val();
            compra.detalle.monto_total = $('#monto_con').val();
            compra.detalle.desc_comp = $('#desc_comp').val();
            compra.detalle.observaciones = $('#observaciones').val();

            $.ajax({
                //dataType: 'JSON',
                type: 'POST',
                url: form.attr('action'),
                data: compra.detalle,
                success: function (r) {
                    if(r) window.location.href = '?c=Compra';
                    console.log(compra.detalle);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }   
            });

        }
            return false;
        }
        return false;
    });
});

/* Limpiar datos del proveedor */
$('#btnProvLimpiar').click(function() {
    $("#cod_prov").val('0');
    $("#busc_prov").val('');
    $("#dato_prov").val('');
});

/* Abrir modal compra al credito - enlace desde el label*/
$('#lbl-credito').on('click', function(e){
    $("#mdl-compra-credito").modal('show'); 
});

/* Boton modal cuotas - validar datos del formulario de las cuotas, fechas, intereses */
$('.btn-ac').on('click', function(e){
    if($('#nro_cuotas').val() == ''){
        toastr.warning('Advertencia, Agregar numero de cuotas.');
        return false;
    } else if($('.fechac').val() == ''){
        toastr.warning('Advertencia, Agregar fecha de pago a la cuota.');
        return false;
    } 
});

/* Opciones de compra Credito - Contado */
$('#credito').on('ifChecked', function(event){
    $('input[name="contado"]').iCheck('uncheck');
    $("#mdl-compra-credito").modal('show');
    $('#r-contado').css('display','none');
    $('#r-credito').css('display','block');
    $('#form-compra').formValidation('revalidateField', 'monto_cre');
});

$('#contado').on('ifChecked', function(event){
    var moneda = $("#moneda").val();
    $('input[name="credito"]').iCheck('uncheck');
    $('#r-contado').css('display','block');
    $('#r-credito').css('display','none');
    $('#mensaje-cre').empty();
    $('#monto_con').val('');
    $('#desc_comp').val('0.00');
    $('#form-compra').formValidation('revalidateField', 'monto_con');
    $(".igv_tc").text(moneda+' 0.00');
    $(".sb_tc").text(moneda+' 0.00');
    compra.refrescar();
});

$('#nro_cuotas, #monto_cre, #monto_int').on('keyup', function(event){
    $('#lis').empty();
    var numCuotas = $('#nro_cuotas').val();
    //var mon_i = $('#monto_int').val();
    
    if(numCuotas > 0){
    for (var i=0; i < numCuotas; i++) {
        var montoCuota = ($('#monto_cre').val() / numCuotas).toFixed(2);
        var montoInteres = (($('#monto_cre').val() * ($('#monto_int').val() / 100)) / numCuotas).toFixed(2);
        var montoCuotaInteres = (parseFloat(montoCuota) + parseFloat(montoInteres)).toFixed(2);
        $('#lis')
        .append(
            $('<tr/>')
                .append($('<td/>').html('<input type="text" class="form-control" name="mmcuota[]" value="'+montoCuotaInteres+'" autocomplete="off"/>'))
                .append($('<td/>').html('<input type="text" class="form-control" name="imcuota[]" value="'+montoInteres+'" autocomplete="off"/>'))
                .append($('<td/>').html('<input type="text" class="form-control DatePicker fechac" name="fmcuota[]" readonly="off" autocomplete="off"/>'))
            );
        $('.DatePicker')
            .datepicker({
            format: 'dd-mm-yyyy'
        });
    }}else{
        var montoInteres = ($('#monto_cre').val() * ($('#monto_int').val() / 100)).toFixed(2);
        var montoCuotaInteres = (parseFloat($('#monto_cre').val()) + parseFloat(montoInteres)).toFixed(2);
        $('#lis')
        .append(
            $('<tr/>')
                .append($('<td/>').html('<input type="text" class="form-control" name="mmcuota[]" value="'+montoCuotaInteres+'" autocomplete="off"/>'))
                .append($('<td/>').html('<input type="text" class="form-control" name="imcuota[]" value="'+montoInteres+'" autocomplete="off"/>'))
                .append($('<td/>').html('<input type="text" class="form-control DatePicker fechac" name="fmcuota[]" readonly="off" autocomplete="off"/>'))
            );
        $('.DatePicker')
            .datepicker({
            format: 'dd-mm-yyyy'
        });
    }
});

/* Busqueda de proveedores */
$("#busc_prov").autocomplete({
    delay: 1,
    autoFocus: true,
    dataType: 'JSON',
    source: function (request, response) {
        $.ajax({     
            type: "post",
            dataType: "json",
            url: '?c=Compra&a=BuscarProv',
            data: {
                criterio: request.term
            },
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        id: item.id_prov,
                        nombre: item.razon_social,
                        ruc: item.ruc
                    }
                }))
            }
        })
    },
    select: function (e, ui) {
        $("#cod_prov").val(ui.item.id);
        $("#dato_prov").val(ui.item.nombre);   
    },
    change: function() {
        $("#busc_prov").val('');
        $("#busc_prov").focus();
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $('<li>')
    .append(item.ruc+' - '+item.nombre)
    .appendTo( ul );
};

$('#mdl-compra-credito').on('hidden.bs.modal', function() {
    $('#mensaje-cre').empty();
    if($('#monto_cre').val() == '0.00' || $('#monto_cre').val() == ''){
        $('#mensaje-cre').html('<div class="alert alert-warning">'
            +'<i class="fa fa-warning"></i> Ingresar el monto total de la compra. <a class="alert-link" data-toggle="modal" data-target="#mdl-compra-credito">AQUI</a>.'
            +'</div>');
    }else{
        $('#mensaje-cre').html('<div class="alert alert-info">'
            +'<i class="fa fa-info"></i> Puedes modificar las cuotas de la compra. <a class="alert-link" data-toggle="modal" data-target="#mdl-compra-credito">AQUI</a>.'
            +'</div>');
    }
});

/* Total de la compra */
var montoTotal = function(){
    var moneda = $("#moneda").val();
    var s_total = $("#monto_con").val(),
        desc = $("#desc_comp").val(),
        total = (s_total - desc).toFixed(2),
        sbt = parseFloat(total /  (1+parseFloat($("#igv").val()))),
        igv = parseFloat((total / (1+parseFloat($("#igv").val()))) * $("#igv").val());

    $(".igv_tc").text(moneda+' '+igv.toFixed(2));
    $(".sb_tc").text(moneda+' '+sbt.toFixed(2));   
}

$('#monto_con, #desc_comp').on('keyup', function(){
    montoTotal();     
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

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}