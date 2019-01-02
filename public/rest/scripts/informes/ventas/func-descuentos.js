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

var listar = function(){

	ifecha = $("#start").val();
    ffecha = $("#end").val();

    var vtotal = 0;
    
    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha
        },
        dataType: "json",
        success: function(item){

            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                    vtotal += parseFloat(campo.descuento);
                });
            }

            $('#total_d').text('S/ '+(vtotal).toFixed(2));
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
                ffecha: ffecha
            }
		},
		"columns":[
			{"data":"fecha_venta","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"desc_td"},
            {"data":"numero"},
            {"data":"descuento","render": function ( data, type, row) {
                return '<p class="text-right bold">S/ '+data+'</p>';
            }},
            {
                "data": null,
                "render": function ( data, type, row) {
                    var sub = data.total - data.descuento;
                    return '<p class="text-right bold">S/ '+(sub).toFixed(2)+'</p>';
                }
            },
            {
                "data": "total",
                "render": function ( data, type, row) {
                    return '<p class="text-right bold">S/ '+data+'</p>';
                }
            }
		]
	});
}