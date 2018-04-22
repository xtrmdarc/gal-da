<?php
//Compras

Route::get('/informesCompras', 'Application\Informes\Compras\ComprasController@index')->name('inf_compras');
Route::post('informesDatosCompras', 'Application\Informes\Compras\ComprasController@Datos');
Route::post('informesDetalleCompras', 'Application\Informes\Compras\ComprasController@Detalle');
Route::post('informesDetalleCCompras', 'Application\Informes\Compras\ComprasController@DetalleC');
Route::post('informesDetalleSCCompras', 'Application\Informes\Compras\ComprasController@DetalleSC');

//Compras por Proveedores

Route::get('/informesComprasProveedores', 'Application\Informes\Compras\ProveedorController@index')->name('inf_proveedores');
Route::post('informesDatosProveedores', 'Application\Informes\Compras\ProveedorController@Datos');
Route::post('informesDetalleProveedores', 'Application\Informes\Compras\ProveedorController@Detalle');
Route::post('informesDetalleCProveedores', 'Application\Informes\Compras\ProveedorController@DetalleC');
Route::post('informesDetalle_CProveedores', 'Application\Informes\Compras\ProveedorController@Detalle_C');

?>