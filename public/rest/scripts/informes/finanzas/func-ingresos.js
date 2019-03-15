$(function() {
    $('#informes').addClass("active");
    moment.locale('es');
	listar();

    $('#start').datetimepicker({
        format: 'DD-MM-YYYY',
        locale: 'es-do'
    });

    $('#end').datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY',
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

    $('#sucu_filter').change( function() {
        listar();
    });
});

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    sucu_filter = $("#sucu_filter").selectpicker('val');

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
        "responsive": true,
		"dom": "tp",
		"bSort": false,
		"ajax":{
			"method": "POST",
			"url": "/informesDatosIngresos",
			"data": {
                ifecha: ifecha,
                ffecha: ffecha,
                sucu_filter: sucu_filter
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		},
		"columns":[
            {"data": "nombre_sucursal"},
			{"data":"fecha_reg","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data": "Caja.desc_caja"},
            {"data": "Cajero.desc_usu"},
            {"data": "motivo"},
            {
                "data": null,
                "render": function ( data, type, row ) {
                    if(data.estado == 'a'){
                        return '<p class="text-center"><span class="label label-primary">APROBADO</span></p>';
                    } else if(data.estado == 'i'){
                        return '<p class="text-center"><span class="label label-danger">ANULADO</span></p>';
                    }
                }
            },
            {
                "data": "importe",
                "render": function ( data, type, row) {
                    return '<p class="text-right bold-d"> '+moneda+' '+data+'</p>';
                }
            }
		]
	});
}