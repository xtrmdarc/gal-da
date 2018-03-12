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

$('#tipo_doc, #cod_prov').change( function() {
	listar();
});

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    tdoc = $("#tipo_doc").selectpicker('val');
    cprov = $("#cod_prov").selectpicker('val');

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
            tdoc: tdoc,
            cprov: cprov
        },
        dataType: "json",
        success: function(item){
            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                    vtotal += parseFloat(campo.total);
                    v_igv = campo.igv;
                });
            }

            var vigv = parseFloat(vtotal) * parseFloat(v_igv),
                vsbt = parseFloat(vtotal) - parseFloat(vigv);

            $('#total_c').text(moneda+' '+(vtotal).toFixed(2));
            $('#subt_c').text(moneda+' '+(vsbt).toFixed(2));
            $('#igv_c').text(moneda+' '+(vigv).toFixed(2));
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
                tdoc: tdoc,
                cprov: cprov
            }
		},
		"columns":[
			{"data": null,"render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data.fecha_c).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +data.hora_c;
            }},
            {"data":"desc_td"},
            {
                "data": null,
                "render": function ( data, type, row) {
                    return data.serie_doc+' - '+data.num_doc;
                }
            },
            {"data":"desc_prov"},
            {"data":"total","render": function ( data, type, row) {
                return '<p class="text-right bold"> '+moneda+' '+data+'</p>';
            }},
            {
                "data": null,
                "render": function ( data, type, row) {
                    if(data.id_tipo_compra == 1){
                        return '<span class="label label-success">'+data.desc_tc+'</span>';
                    } else if(data.id_tipo_compra == 2){
                        return '<span class="label label-warning">'+data.desc_tc+'</span>';
                    }
                }
            },
            {
                "data": null,
                "render": function ( data, type, row ) {
                    if(data.estado == 'a'){
                        return '<p class="text-center"><span class="label label-primary">ACTIVA</span></p>';
                    } else if(data.estado == 'i'){
                        return '<p class="text-center"><span class="label label-danger">ANULADA</span></p>';
                    }
                }
            },
            {
                "data": null,
                "render": function ( data, type, row ) {
                    return '<p class="text-center">'
                    +'<a class="btn btn-sm btn-success" onclick="detalle('+data.id_compra+')"><i class="fa fa-files-o"></i></a>'
                    +'&nbsp<a class="btn btn-sm btn-info" onclick="detalle_c('+data.id_compra+')"><i class="fa fa-eye"></i></a>'
                    +'</p>';
                }
            }
		]
	});
};

var detalle_c = function(cod){
    var moneda = $("#moneda").val();
    $('#lista_p').empty();
    $('#detalle').modal('show');
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      url: '?c=Informe&a=Detalle_C',
      success: function (data){
        $.each(data, function(i, item) {
            var calc = item.precio * item.cant;
            $('#lista_p')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.Pres.cod_ins))
                .append($('<td/>').html(item.Pres.nomb_ins))
                .append($('<td/>').html(item.cant+' <span class="label label-primary">'+item.Pres.descripcion+'</span>'))
                .append($('<td/>').html(moneda+' '+item.precio))
                .append($('<td class="text-right"/>').html(moneda+' '+(calc).toFixed(2)))
                );
            });
        }
    });
};

var detalle = function(cod){
    var moneda = $("#moneda").val();
    $('#list_cd').empty();
    $('#m_detalle').modal('show');
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "?c=Informe&a=Detalle",
        data: {
            cod: cod
        },
        success: function(data){
            $.each(data, function(i, item) {
                if (item.estado == 'p'){
                    label = 'warning';
                    nombre = 'En pago';
                } else if(item.estado == 'a'){
                    label = 'primary';
                    nombre = 'Cancelado';
                }
                $('#list_cd')
                .append(
                  $('<tr/>')
                    .append($('<td/>').html(moment(item.fecha).format('DD-MM-Y')))
                    .append($('<td/>').html(moneda+' '+item.interes))
                    .append($('<td class="text-right"/>').html(moneda+' '+item.total))
                    .append($('<td class="text-center"/>')
                        .html('<span class="label label-'+label+'">'+nombre+'</span>'))
                    .append($('<td class="text-right"/>')
                        .html('<p class="text-right"><a class="btn btn-sm btn-info" onclick="detallec('+item.id_credito+')"><i class="fa fa-eye"></i></a></p>'))
                    );
            });
        }
    });
}

var detallec = function(cod){
    var moneda = $("#moneda").val();
    $('#list_cdc').empty();
    $('#m_detallec').modal('show');
        $.ajax({
        type: "POST",
        dataType: "json",
        url: "?c=Informe&a=DetalleC",
        data: {
            cod: cod
        },
        success: function(data){
            $.each(data, function(i, item) {
                $('#list_cdc')
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