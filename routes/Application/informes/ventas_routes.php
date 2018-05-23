
<?php
//Ventas

Route::get('/informesVentas', 'Application\Informes\Ventas\VentasController@index')->name('inf_ventas');
Route::post('informesDatosVentas', 'Application\Informes\Ventas\VentasController@Datos')->name('config.Ventas.Datos');
Route::post('informesDatosVentasDetalle', 'Application\Informes\Ventas\VentasController@Detalle')->name('config.Ventas.Detalle');
Route::post('informesDatosVentasExcel', 'Application\Informes\Ventas\VentasController@ExportExcel')->name('config.Ventas.ExportExcel');

//Ventas por Producto

Route::get('/informesVentasProducto', 'Application\Informes\Ventas\ProductosController@index')->name('inf_productos');
Route::post('informesDatosProductos', 'Application\Informes\Ventas\ProductosController@Datos')->name('config.Productos.Datos');

//Ventas Mozos

Route::get('/informesVentasMozos', 'Application\Informes\Ventas\MozosController@index')->name('inf_mozos');
Route::post('informesDatosMozos', 'Application\Informes\Ventas\MozosController@Datos');

//Venta por forma de Pago

Route::get('/informesVentasFpago', 'Application\Informes\Ventas\FPagoController@index')->name('inf_fpago');
Route::post('informesDatosFpago', 'Application\Informes\Ventas\FPagoController@Datos');

//Informe de Venta FREE

Route::get('/informesVentasF', 'Application\Informes\Ventas\VentasController@informeVentasF')->name('inf_ventasF');
?>