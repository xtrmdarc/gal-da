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

$('#cliente').change( function() {
	listar();
});

var listar = function(){

	ifecha = $("#start").val();
    ffecha = $("#end").val();
    ccliente = $("#cliente").selectpicker('val');

    var vsbt = 0,
        vigv = 0,
        vtotal = 0,
        v_igv = 0;
    
    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            ccliente: ccliente
        },
        dataType: "json",
        success: function(item){

            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {  
                    vtotal += parseFloat(campo.total);
                    vsbt += parseFloat(campo.total / 1.18);
                    vigv += parseFloat(((campo.total / 1.18) - campo.descuento) * 0.18);
                });
            }

            $('#total_v').text('S/ '+(vtotal).toFixed(2));
            $('#subt_v').text('S/ '+(vsbt).toFixed(2));
            $('#igv_v').text('S/ '+(vigv).toFixed(2));

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
                ccliente: ccliente
            }
		},
		"columns":[
			{"data":"fecha_venta","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"Cliente.nombre","render": function ( data, type, row ) {
                return '<p class="mayus">'+data+'</p>';
            }},
            {"data":"documento"},
			{
                "data": null,
                "render": function ( data, type, row) {
                    var igv = data.total * data.igv;
                    var sub = data.total - igv;
                    return '<p class="text-right">'+(sub).toFixed(2)+'</p>';
                }
            },
			{
                "data": null,
                "render": function ( data, type, row) {
                    var igv = data.total * data.igv;
                    return '<p class="text-right">'+(igv).toFixed(2)+'</p>';
                }
            },
			{"data":"total","render": function ( data, type, row) {
                return '<p class="text-right bold">S/ '+data+'</p>';
            }},
            {"data":"creator","render": function ( data, type, row ) {
                return '<p class="text-center"><span class="label label-primary">ACTIVO</span></p>';
            }},
            {"data":null,"render": function ( data, type, row ) {
                return '<p class="text-center"><a class="btn btn-sm btn-primary" onclick="detalle('+data.id_pedido+',\''+data.documento+'\')">Ver</a></p>';
            }}
		]
	});
};

var detalle = function(cod,doc){
    $('#lista_p').empty();
    $('#detalle').modal('show');
    $('.title-d').text(doc);
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      url: '?c=Informe&a=Detalle',
      success: function (data){
        $.each(data, function(i, item) {
            var calc = item.precio * item.cantidad;
            $('#lista_p')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.cantidad))
                .append($('<td/>').html(item.Producto.nombre_prod+' <span class="label label-primary">'+item.Producto.pres_prod+'</span>'))
                .append($('<td/>').html('S/ '+item.precio))
                .append($('<td class="text-right"/>').html('S/ '+(calc).toFixed(2)))
                );
            });
        }
    });
};