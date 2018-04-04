$(function() {
    moment.locale('es');
    select_combo(1);
    listar();
    $('#informes').addClass("active");
});

$('#start, #end, #id_ip').change( function() {
	listar();
});

$("#tipo_ip").change(function(){
	$('#id_ip').selectpicker('destroy');
	$("#tipo_ip option:selected").each(function(){
	cod=$(this).val();
	   $.post("/informesComboIPKardex",{cod: cod},function(data){
    	   $("#id_ip").html(data);
    	   $('#id_ip').selectpicker();
	   });
	});
})

var select_combo = function(cod){
	$('#id_ip').selectpicker('destroy');
    $.ajax({
        type: "POST",
        url: "/informesComboIPKardex",
        data: {cod: cod},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#id_ip').html(response);
            $('#id_ip').selectpicker();
        },
        error: function () {
            $('#id_ip').html('There was an error!');
        }
    });
}

var listar = function(){
	ifecha = $("#start").val();
    ffecha = $("#end").val();
    tipo_ip = $("#tipo_ip").val();
    id_ip = $("#id_ip").val();
    var stock = 0,
        ent = 0,
        sal = 0,
        desc = '';

    $.ajax({
        type: "POST",
        url: "/informesDatosKardex",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            tipo_ip: tipo_ip,
            id_ip: id_ip
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(item){
            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {
                	if(campo.id_tipo_ope == 1){
                        ent += parseFloat(campo.cant);
                	}else if(campo.id_tipo_ope == 2){
                		sal += parseFloat(campo.cant);
                	}
                    desc = campo.Dato.descripcion;
                });
            }
            $('#stock_e').text((ent).toFixed(2)+' '+desc);
            $('#stock_a').text((ent-sal).toFixed(2)+' '+desc);
            $('#stock_s').text((sal).toFixed(2)+' '+desc);
        }
    });

    var opc = 0,
        cante = 0,
        cants = 0,
        table =	$('#table')
	    .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "tp",
    		"bSort": false,
    		"ajax":{
    		"method": "POST",
    		"url": "/informesDatosKardex",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    		"data": {
                ifecha: ifecha,
                ffecha: ffecha,
                tipo_ip: tipo_ip,
                id_ip: id_ip
              }
    		},
            "columns":[
                {"data": null,"render": function ( data, type, row ) {
                    return '<i class="fa fa-calendar"></i> '+moment(data.fecha_r).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                    +moment(data.fecha_r).format('h:mm A');
                }},
                {"data":"Almacen.dato"},
                {"data": null,"render": function ( data, type, row ) {
                    if(data.id_tipo_ope == 1){
          				return 'ENTRADA, POR COMPRA: <br><i class="fa fa-file-text"></i> COMPRA, '+data.Comp.desc_td+' '+data.Comp.serie_doc+' '+data.Comp.num_doc;
          			}else if(data.id_tipo_ope == 2){
          				return 'SALIDA, POR VENTA: <br><i class="fa fa-file-text"></i> VENTA, '+data.Comp.desc_td+' '+data.Comp.ser_doc+' '+data.Comp.nro_doc;
          			}
                }},
                {"data":"Dato.descripcion"},
                {"data": null,"render": function ( data, type, row ) {
                    if(data.id_tipo_ope == 1){
          				var cante = data.cant;
          				return '<div class="text-success text-center">+ '+data.cant+'</div>';
          			}else{
          				var cante = 0;
          				return '';
          			}
                }},
                {"data": null,"render": function ( data, type, row ) {
                    if(data.id_tipo_ope == 2){
          				var cants = data.cant;
          				return '<div class="text-danger text-center">- '+data.cant+'</div>';
          			}else{
          				var cants = 0;
          				return '';
          			}
                }}
            ]
	});
};