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
});

$('#mozo').change( function() {
	listar();
});

$('#sucu_filter').change( function() {
    listar();
});

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    cmozo = $("#mozo").selectpicker('val');
    sucu_filter = $("#sucu_filter").selectpicker('val');

    var cantidad_mozo = 0,
        total_mozo = 0;

    $.ajax({
        type: "POST",
        url: "/informesDatosMozos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            cmozo: cmozo,
            sucu_filter: sucu_filter
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(item){

            if (item.dato.length != 0) {
                $.each(item.dato, function (i, campo) {
                    cantidad_mozo = campo.cantidad;
                    total_mozo = campo.total;


                });
            }

            $('#cant_v').text(cantidad_mozo);
            $('#total_v').text(total_mozo);
        }
    });

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
		"dom": "tp",
		"bSort": false,
		"ajax":{
			"method": "POST",
			"url": "/informesDatosMozos",
			"data": {
                ifecha: ifecha,
                ffecha: ffecha,
                cmozo: cmozo,
                sucu_filter: sucu_filter
            },
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		},
		"columns":[
			{"data":"fec_ven","render": function ( data, type, full, meta ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"Mozo.nombre","render": function ( data, type, full, meta ) {
                return '<p class="mayus">'+data+'</p>';
            }},
            {"data":"Cliente.nombre"},
			{"data":"desc_td"},
			{"data":"numero"},
			{"data":"total","render": function ( data, type, full, meta ) {
                return '<p class="text-right bold"> '+moneda+' '+data+'</p>';
            }}
		]
	});
}