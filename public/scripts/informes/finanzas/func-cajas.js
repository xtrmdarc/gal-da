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

var listar = function(){

    var moneda = $("#moneda").val();
	ifecha = $("#start").val();
    ffecha = $("#end").val();

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
            {"data": "desc_caja"},
            {"data": "desc_per"},
			{"data":"fecha_a","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"fecha_c","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {
                "data": "monto_s",
                "render": function ( data, type, row) {
                    return '<p class="bold-d"> '+moneda+' '+data+'</p>';
                }
            },
            {
                "data": "monto_c",
                "render": function ( data, type, row) {
                    return '<p class="bold-d"> '+moneda+' '+data+'</p>';
                }
            },
            {
                "data": null,
                "render": function ( data, type, row) {
                    var dif = data.monto_c - data.monto_s
                    return '<p class="bold-d"> '+moneda+' '+(dif).toFixed(2)+'</p>';
                }
            },
            {"data":null,"render": function ( data, type, row ) {
                return '<p class="text-center"><a class="btn btn-sm btn-primary" onclick="detalle('+data.id_apc+',\''+data.fecha_a+'\')">Ver</a></p>';
            }}
		]
	});
};

var detalle = function(cod_apc,fecha_ape){
    var moneda = $("#moneda").val();
    moment.locale('es');
    $("#detalle").modal('show');
    $.ajax({
        data: { cod_apc : cod_apc,
                fecha_ape : fecha_ape},
        url:   '?c=Informe&a=MontoSis',
        type:  'POST',
        dataType: 'json',
   
        success: function(data) {
            var fechaApertura = moment(data.Datos.fecha_a).format('Do MMMM YYYY, h:mm A');
            var fechaCierre = moment(data.Datos.fecha_c).format('Do MMMM YYYY, h:mm A');
            var totalIng = (parseFloat(data.total_i) + parseFloat(data.Ingresos.total_i)).toFixed(2);
            $("#apc").html(moneda+' '+data.Datos.monto_a);
            $("#t_ing").html(moneda+' '+totalIng);
            $("#t_egr").html(moneda+' '+data.Gastos.total_g);
            $("#d_cajero").html(data.Datos.desc_per);
            $("#d_caja").html(data.Datos.desc_caja);
            $("#d_turno").html(data.Datos.desc_turno);
            $("#d_fecha_a").html(fechaApertura);
            $("#d_fecha_c").html(fechaCierre);
            var monto_e = ((parseFloat(data.Datos.monto_a) + parseFloat(data.total_i)) + parseFloat(data.Ingresos.total_i) - parseFloat(data.Gastos.total_g)).toFixed(2);
            $("#t_est").html(moneda+' '+monto_e);
            $("#t_real").html(moneda+' '+data.Datos.monto_c);
            var monto_d = (parseFloat(monto_e) - parseFloat(data.Datos.monto_c)).toFixed(2);
            $("#t_dif").html(moneda+' '+monto_d);
        }
    }); 
}
