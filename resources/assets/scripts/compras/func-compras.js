$(function() {
    $('#compras').addClass("active");
    $('#c-compras').addClass("active");
    moment.locale('es');
	listarCompras();
    mensaje();

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
        listarCompras();
    });

    $("#end").on("dp.change", function (e) {
        $('#start').data("DateTimePicker").maxDate(e.date);
        listarCompras();
    });
    
});

/* Filtros */
$('#tipo_doc, #cod_prov').change( function() {
	listarCompras();
});

/* Mostrar datos en la tabla */
var listarCompras = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    tdoc = $("#tipo_doc").selectpicker('val');
    cprov = $("#cod_prov").selectpicker('val');

    var vsbt = 0,
        vigv = 0,
        vtotal = 0,
        igvGlobal = 0;

    $.ajax({
        type: "POST",
        url: "?c=Compra&a=ObtenerDatos",
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
                    vsbt += parseFloat(campo.total /  (1+parseFloat(campo.igv)));
                    vigv += parseFloat((campo.total / (1+parseFloat(campo.igv))) * campo.igv);
                });
            }

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
			"url": "?c=Compra&a=ObtenerDatos",
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
            {"data":null,"render": function ( data, type, row ) {
                if(data.estado == 'a'){
                    return '<p class="text-center"><span class="label label-primary">ACTIVA</span></p>';
                }else if(data.estado == 'i'){
                    return '<p class="text-center"><span class="label label-danger">ANULADA</span></p>';
                }
            }},
            {"data":null,"render": function ( data, type, row ) {
                return '<div class="text-right">'
                +'<button type="button" class="btn btn-info btn-sm" onclick="detalleCompra('+data.id_compra+');"><i class="fa fa-eye"></i></button>'
                +'&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="anularCompra('+data.id_compra+');"><i class="fa fa-ban"></i></button>' 
                +'</div>';
            }}
		]
	});
};

/* Detalle de la compra */
var detalleCompra = function(cod){
    var moneda = $("#moneda").val();
    $('#lista_productos').empty();
    $('#mdl-detalle-compra').modal('show');
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      url: '?c=Compra&a=Detalle',
      success: function (data){
        $.each(data, function(i, item) {
            var importe = item.precio * item.cant;
            $('#lista_productos')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.Pres.cod_ins))
                .append($('<td/>').html(item.Pres.nomb_ins))
                .append($('<td/>').html(item.cant+' <span class="label label-primary">'+item.Pres.descripcion+'</span>'))
                .append($('<td/>').html(moneda+' '+item.precio))
                .append($('<td class="text-right"/>').html(moneda+' '+(importe).toFixed(2)))
                );
            });
        }
    });
};

/* Anular Compra */
var anularCompra = function(cod){
    $('#mdl-eliminar-compra').modal('show');
    $('#cod_compra').val(cod);
};

var mensaje = function(){
    if($("#m").val() == 'c'){
        toastr.success('Datos anulados, correctamente');
    }else if ($("#m").val() == 'e'){
        toastr.warning('Advertencia, La compra ya ha sido anulada.');
    }
}