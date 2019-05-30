$(function() {

});

$(".ventas_free").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
				.append(
				$('<div class="list-group"/>')
					.append('<a class="list-group-item" href="/informesVentas">Todas las ventas</a>')
			)
		)
	)
});

$(".ventas").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
			.append(
				$('<div class="list-group"/>')
				.append('<a class="list-group-item" href="/informesVentas">Todas las ventas</a>')
				.append('<a class="list-group-item" href="/informesVentasProducto">Ventas por producto</a>')
				.append('<a class="list-group-item" href="/informesVentasMozos">Ventas por mesero</a>')
				.append('<a class="list-group-item" href="/informesVentasFpago">Ventas por forma de pago</a>')
				)
			)
		)
});

$(".compras").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
			.append(
				$('<div class="list-group"/>')
				.append('<a class="list-group-item" href="/informesCompras">Todas las compras</a>')
				.append('<a class="list-group-item" href="/informesComprasProveedores">Compras por proveedor</a>')
				)
			)
		)
});

$(".finanzas").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
			.append(
				$('<div class="list-group"/>')
				.append('<a class="list-group-item" href="/informesCajas">Aperturas y cierres de caja</a>')
				.append('<a class="list-group-item" href="/informesIngresos">Todos los ingresos Administrativos</a>')
				.append('<a class="list-group-item" href="/informesEgresos">Todos los egresos Administrativos</a>')
				.append('<a class="list-group-item" href="/informesRemuneracion">Egresos por remuneraci&oacute;n</a>')
				)
			)
		)
});

$(".inventario").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
			.append(
				$('<div class="list-group"/>')
				.append('<a class="list-group-item" href="/informesKardex">Kardex</a>')
				)
			)
		)
});


