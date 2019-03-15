$(function() {
    $('#informes').addClass("active");
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

    function filterGlobal () {
    $('#table').DataTable().search( 
        $('#global_filter').val()
    ).draw();
    }

	var	table =	$('#table')
	.DataTable({
		"destroy": true,
		"dom": "tp",
		"bSort": false,
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\"S/",]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            $( api.column( 4 ).footer() ).html(
                'Total: '+moneda+' '+pageTotal.toFixed(2)
            );
        },
		"ajax":{
			"method": "POST",
			"url": "/informesDatosProductos",
			"data": {
                ifecha: ifecha,
                ffecha: ffecha
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		},
		"columns":[
			{"data":"Producto.nombres"},
			{"data":"Producto.desc_c"},
			{"data":"cantidad"},
			{
                "data": "precio",
                "render": function ( data, type, row) {
                    return '<p class="text-right"> '+moneda+' '+data+'</p>';
                }
            },
			{
                "data": "total",
                "render": function ( data, type, row) {
                    return '<p class="text-right"> '+moneda+' '+data+'</p>';
                }
            }
		],
		"columnDefs": [
            {"className": "text-right bold", "targets": [4]}
        ],
        buttons: [
            {
                extend: 'excel', title: 'rep_ventas', text:'Excel', className: 'btn btn-excel', text: '<i class="glyphicon glyphicon-th-large"></i> Excel', titleAttr: 'Descargar Excel',
                container: '#btn-excel-1'
            }
        ]
	});
	$('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
}