$(function() {
    $('#informes').addClass("active");
    moment.locale('es');
	listar();

    $('#start').datetimepicker({
        format: 'DD-MM-YYYY LT',
        locale: 'es-do'
    });

    $('#end').datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY LT',
        locale: 'es-do'
    });

    $("#start").on("dp.change", function (e) {
        $('#end').data("DateTimePicker").minDate(e.date);
        listar();
    });

    $("#end").on("dp.change", function (e) {
        $('#start').data("DateTimePicker").maxDate(e.date);
        listar();
    });
});

$('#tipo_p').change( function() {
	listar();
});

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    tpag = $("#tipo_p").selectpicker('val');

    var vtotal = 0;

    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            tpag: tpag
        },
        dataType: "json",
        success: function(item){
            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                    vtotal += parseFloat(campo.total);
                });
            }

            $('#total_v').text(moneda+' '+(vtotal).toFixed(2));
        }
    });

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
        "responsive": true,
		"dom": "tp",
		"bSort": false,
		"ajax":{
			"method": "POST",
			"url": "?c=Informe&a=Datos",
			"data": {
                ifecha: ifecha,
                ffecha: ffecha,
                tpag: tpag
            }
		},
		"columns":[
			{"data":"fec_ven","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"Cliente.nombre","render": function ( data, type, row ) {
                return '<p class="mayus">'+data+'</p>';
            }},
            {"data": "desc_td"},
            {"data": "numero"},
            {
                "data": null,
                "render": function ( data, type, row) {
                    var opc = data.id_tpag;
                    switch(opc){
                        case '1':
                            return '<p class="text-right"><strong>Efectivo('+moneda+'):</strong> '+data.pago_efe+'</p>';
                        break;
                        case '2':
                            return '<p class="text-right"><strong>Tarjeta('+moneda+'):</strong> '+data.pago_tar+'</p>';
                        break;
                        case '3':
                            return '<p class="text-right"><strong>Efectivo('+moneda+'):</strong> '+data.pago_efe+'<br>'
                            +'<strong>Tarjeta(₡):</strong> '+data.pago_tar+'</p>';
                        break;
                    }
                }
            },
			{"data":"total","render": function ( data, type, row) {
                return '<p class="text-right bold"> '+moneda+' '+data+'</p>';
            }},
            {"data":null,"render": function ( data, type, row) {
                return '<p class="text-right">Contado</p>';
            }}
		]
	});
}