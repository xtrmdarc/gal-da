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

$('#mozo').change( function() {
	listar();
});

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    cmozo = $("#mozo").selectpicker('val');

    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            cmozo: cmozo
        },
        dataType: "json",
        success: function(item){
            $('#cant_v').text(item['dato'].cantidad);
            $('#total_v').text(moneda+' '+item['dato'].total);
        }
    });

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
		"dom": "tp",
		"bSort": false,
		"ajax":{
			"method": "POST",
			"url": "?c=Informe&a=Datos",
			"data": {
                ifecha: ifecha,
                ffecha: ffecha,
                cmozo: cmozo
            }
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