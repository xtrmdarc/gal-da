$(function() {
    moment.locale('es');
	listarComprasCredito();
    $('#frm-compra-credito').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            pago_cuo: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            monto_ec: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
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

$('#cod_prov').change( function() {
	listarComprasCredito();
});

/* Mostrar datos en la tabla compras al credito */
var listarComprasCredito = function(){

    var moneda = $("#moneda").val();

    cprov = $("#cod_prov").selectpicker('val');

    var t_deuda = 0,
        t_inte = 0,
        t_amor = 0;

    $.ajax({
        type: "POST",
        url: "/creditosDatos",
        data: {
            cprov: cprov
        },
        dataType: "json",
        dataSrc : "",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(item){

            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                    t_deuda += parseFloat(campo.total);
                    t_inte += parseFloat(campo.interes);
                    t_amor += parseFloat(campo.Amortizado.total);
                });
            }

            var t_total = t_deuda - t_amor;

            $('#t_deuda').text(moneda+' '+(t_deuda).toFixed(2));
            $('#t_inte').text(moneda+' '+(t_inte).toFixed(2));
            $('#t_amor').text(moneda+' '+(t_amor).toFixed(2));
            $('#t_total').text(moneda+' '+(t_total).toFixed(2));
        }
    });

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
        "responsive": true,
		"dom": "<'row'<'col-sm-6'><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
		"bSort": true,
		"ajax":{
			"method": "POST",
			"url": "/creditosDatos",
			"data": {
                cprov: cprov
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		},
		"columns":[
			{"data": null,"render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data.fecha).format('DD-MM-Y');
            }},
            {"data":"desc_prov"},
            {"data":"desc_td"},
            {
                "data": null,
                "render": function ( data, type, row) {
                    return data.numero;
                }
            },
            {"data":"total","render": function ( data, type, row) {
                return '<span class="label label-danger"> '+moneda+' '+data+'</span>';
            }},
            {"data":"interes","render": function ( data, type, row) {
                return moneda+' '+data;
            }},
            {"data":"Amortizado.total","render": function ( data, type, row) {
                return moneda+' '+data;
            }},
            {"data":null,"render": function ( data, type, row) {
                var cal = (data.total - data.Amortizado.total).toFixed(2);
                return '<span class="label label-warning"> '+moneda+' ' +cal+'</span>';
            }},
            {"data":null,"render": function ( data, type, row ) {
                var call = (data.total - data.Amortizado.total).toFixed(2);
                return '<p class="text-center">'
                +'<a class="btn btn-sm btn-info" onclick="detalleCuota('+data.id_credito+')"><i class="fa fa-eye"></i></a> '
                +'<a class="btn btn-sm btn-primary" onclick="pagoCuota('+data.id_credito+',\''+data.desc_td+'\',\''+data.numero+'\',\''+call+'\',\''+data.total+'\',\''+data.Amortizado.total+'\')">Pago</a></p>';
            }}
		]
	});

};

/* Pago o amortizacion de cuota */
var pagoCuota = function(cod,doc,num,pen,total,amort){
    var moneda = $("#moneda").val();
    $('#mdl-compra-credito').modal('show');
    $('.title-d').text(doc+' - '+num);
    $('#monto_pend').text(moneda+' '+pen);
    $('#cod_cuota').val(cod);
    $('#total_cuota').val(total);
    $('#amort_cuota').val(amort);
    $.ajax({
        type: "POST",
        url: "/creditosDatosP",
        data: {
            cod: cod
        },
        dataType: "json",
        dataSrc : "",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function(item){
            $('#fecha_comp').text(moment(item['data'].fecha).format('DD-MM-Y'));  
            $('#datos_prov').text(item['data'].desc_prov);   
        }
    });
};

/* Detalle de la cuota(s) al credito */
var detalleCuota = function(cod){
    var moneda = $("#moneda").val();
    $('#lista_cuotas').empty();
    $('#mdl-detalle').modal('show');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/creditosDetalle",
        data: {
            cod: cod
        },
        dataSrc : "",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        success: function(data){
            $.each(data, function(i, item) {
                $('#lista_cuotas')
                .append(
                  $('<tr/>')
                    .append($('<td/>').html(item.Usuario.nombre))
                    .append($('<td/>').html(moment(item.fecha).format('DD-MM-Y h:mm A')))
                    .append($('<td class="text-right"/>').html(moneda+' '+item.importe))
                    );
            });
        }
    });
}

/* Opcion egreso de caja */
$('.egre_caja').on('ifChanged', function(event){
    var moneda = $("#moneda").val();
    if( $(this).is(':checked') ) {
        $('#egre_caja').val('1');
        $('#cont-egre').empty();
        $('#cont-egre')
            .append(
                $('<div class="col-sm-12" />')
                    .append(
                        $('<div class="form-group" />')
                            .append(
                                $('<div class="input-group" />')
                                .html('<span class="input-group-addon">'+moneda+'</span>'
                                    +'<input type="text" name="monto_ec" id="monto_ec" class="form-control" placeholder="Ingrese el monto" required="required" autocomplete="off" />'
                                    +'<span class="input-group-addon"><span class="fa fa-money"></span></span>')
                            )
                    )
                );
        
    } else {
        $('#egre_caja').val('2');
        $('#cont-egre').empty();
    }
    $('#frm-compra-credito').formValidation('revalidateField', 'monto_ec');
});

$('#mdl-compra-credito').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-compra-credito').formValidation('resetForm', true);
    $('.egre_caja').iCheck('uncheck');
    $('.icheckbox_flat-red').removeClass('checked');
    $('#cont-egre').empty();
});
