$(function() {
    moment.locale('es');
    listar();

    $('#tipo_p_i').change( function() {
        listar();
    });
});

var listar = function(){

    var moneda = $("#moneda").val();

    tipo_p_i = $("#tipo_p_i").selectpicker('val');

    var	table =	$('#table')
        .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "tp",
            "bSort": false,
            "ajax":{
                "method": "POST",
                "url": "/stockDatos",
                "data": {
                    tipo_p_i: tipo_p_i
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            "columns":[
                {"data": null,"render": function ( data, type, row ) {
                    return '<p style="text-align: center">'+data.nomb_ins+'</p>';
                }},
                {"data": null,"render": function ( data, type, row ) {
                    if(data.id_ti == '1') {
                        return '<p class="text-center"><span class="label label-warning">INSUMO</span></p>';
                    } else {
                        return '<p class="text-center"><span class="label label-success">PRODUCTO</span></p>';
                    }
                }},
                {"data": null,"render": function ( data, type, row ) {
                    return '<p style="text-align: center">'+data.desc_c+'</p>';
                }},
                {"data": null,"render": function ( data, type, row ) {
                    return '<p style="text-align: center">'+data.entradas+'</p>';
                }},
                {"data": null,"render": function ( data, type, row ) {
                    if(isNaN(data.salidas) || data.salidas == null) {
                        var salidas = 0;
                        return '<p style="text-align: center">'+salidas+'</p>';
                    } else {
                        return '<p style="text-align: center">'+data.salidas+'</p>';
                    }
                }},
                {"data": null,"render": function ( data, type, row ) {
                    return '<p style="text-align: center">'+data.stock_min+'</p>';
                }},
                {"data": null,"render": function ( data, type, row ) {
                    if(data.stock_total < data.stock_min) {
                        return '<p style="text-align: center" class="text-danger">'+data.stock_total+'</p>';
                    } else {
                        return '<p style="text-align: center" class="text-primary">'+data.stock_total+'</p>';
                    }
                }}
            ]
        });
}