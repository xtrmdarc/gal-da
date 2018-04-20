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

$('#tipo_doc').change( function() {
	listar();
});

var listar = function(){

	ifecha = $("#start").val();
    ffecha = $("#end").val();
    tdoc = $("#tipo_doc").selectpicker('val');

    var vtotal = 0,
        vigv = 0,
        v_igv = 0;

    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            tdoc: tdoc
        },
        dataType: "json",
        success: function(item){

            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {  
                    vigv += parseFloat(((campo.total / 1.18) - campo.descuento) * 0.18);
                });
            }

            $('#total_i').text('S/ '+(vigv).toFixed(2));
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
                tdoc: tdoc
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
            {
                "data": null,
                "render": function ( data, type, row) {
                    return data.desc_td+'<br>'+data.numero;
                }
            },
            {
                "data": null,
                "className": 'cell-right-border',
                "render": function ( data, type, row) {
                    var sbt = (data.total / (1 + parseFloat(data.igv)));
                    return (sbt).toFixed(2);
                }
            },
            {
                "data": null,
                "className": 'text-center cell-right-border cell-bottom-border',
                "render": function ( data, type, row) {
                    var sbt = (data.total / (1 + parseFloat(data.igv)));
                    var igv = ((sbt - data.descuento) * data.igv);
                    return (igv).toFixed(2);
                }
            },
            {"data":"total","render": function ( data, type, row) {
                return '<p class="text-right bold">S/ '+data+'</p>';
            }},
            {"data":null,"render": function ( data, type, row) {
                return 'Contado';
            }},
            {"data":"creator","render": function ( data, type, row ) {
                return '<p class="text-center"><span class="label label-primary">ACTIVO</span></p>';
            }},
            {"data":null,"render": function ( data, type, row ) {
                return '<p class="text-center"><a class="btn btn-sm btn-primary" onclick="detalle('+data.id_pedido+',\''+data.desc_td+'\',\''+data.numero+'\')">Ver</a></p>';
            }}
		]
	});
};

var detalle = function(cod,doc,num){
    $('#lista_p').empty();
    $('#detalle').modal('show');
    $('.title-d').text(doc+' - '+num);
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