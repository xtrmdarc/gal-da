
<?php
//Ventas

Route::get('/informesVentas', 'Application\Informes\Ventas\VentasController@index')->name('inf_ventas');
Route::post('informesDatosVentas', 'Application\Informes\Ventas\VentasController@Datos')->name('config.Ventas.Datos');
Route::post('informesDatosVentasDetalle', 'Application\Informes\Ventas\VentasController@Detalle')->name('config.Ventas.Detalle');
Route::post('informesDatosVentasLcajas', 'Application\Informes\Ventas\VentasController@lista_caja_x_sucursal')->name('config.Ventas.lista_cajas');
Route::post('informesDatosVentasExcel', 'Application\Informes\Ventas\VentasController@ExportExcel')->name('config.Ventas.ExportExcel');

//Ventas por Producto

Route::get('/informesVentasProducto', 'Application\Informes\Ventas\ProductosController@index')->name('inf_productos');
Route::post('informesDatosProductos', 'Application\Informes\Ventas\ProductosController@Datos')->name('config.Productos.Datos');
Route::post('informesDatosProductosExcel', 'Application\Informes\Ventas\ProductosController@ExportExcel')->name('config.Productos.ExportExcel');

//Ventas Mozos

Route::get('/informesVentasMozos', 'Application\Informes\Ventas\MozosController@index')->name('inf_mozos');
Route::post('informesDatosMozos', 'Application\Informes\Ventas\MozosController@Datos');
Route::post('informesDatosMozosExcel', 'Application\Informes\Ventas\MozosController@ExportExcel')->name('config.Mozos.ExportExcel');

//Venta por forma de Pago

Route::get('/informesVentasFpago', 'Application\Informes\Ventas\FPagoController@index')->name('inf_fpago');
Route::post('informesDatosFpago', 'Application\Informes\Ventas\FPagoController@Datos');
Route::post('informesDatosFpagoExcel', 'Application\Informes\Ventas\FPagoController@ExportExcel')->name('config.fpago.ExportExcel');

//Informe de Venta FREE

Route::get('/informesVentasF', 'Application\Informes\Ventas\VentasController@informeVentasF')->name('inf_ventasF');
Route::post('informesVentasF', 'Application\Informes\Ventas\VentasController@DatosFree')->name('config.Ventas.DatosFree');

Route::get('/informesVentasTF', 'Application\Informes\Ventas\VentasController@index')->name('inf_ventasF');
Route::post('informesVentasTF', 'Application\Informes\Ventas\VentasController@Datos')->name('config.Ventas.DatosFree');
?>