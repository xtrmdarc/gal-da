$(function() {

});

$(".ventas").click(function() {
	$('#list_a').empty();
	$('#list_a').append(
		$('<div class="panel panel-default panel-shadow animated flipInX"/>')
			.append(
			$('<div class="panel-body no-padding"/>')
			.append(
				$('<div class="list-group"/>')
				.append('<a class="list-group-item" href="lista_inf_ventas.php">Todas las ventas</a>')
				.append('<a class="list-group-item" href="lista_inf_productos.php">Ventas por producto</a>')
				.append('<a class="list-group-item" href="lista_inf_mozos.php">Ventas por mesero</a>')
				.append('<a class="list-group-item" href="lista_inf_fpago.php">Ventas por forma de pago</a>')
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
				.append('<a class="list-group-item" href="lista_inf_compras.php">Todas las compras</a>')
				.append('<a class="list-group-item" href="lista_inf_proveedores.php">Compras por proveedor</a>')
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
				.append('<a class="list-group-item" href="lista_inf_cajas.php">Aperturas y cierres de caja</a>')
				.append('<a class="list-group-item" href="lista_inf_ingresos.php">Todos los ingresos</a>')
				.append('<a class="list-group-item" href="lista_inf_egresos.php">Todos los egresos</a>')
				.append('<a class="list-group-item" href="lista_inf_remuneraciones.php">Egresos por remuneraci&oacute;n</a>')
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
				.append('<a class="list-group-item" href="lista_inf_kardex.php">Kardex</a>')
				)
			)
		)
});


