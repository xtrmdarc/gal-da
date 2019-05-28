<?php
Route::get('/informesCreditos', 'Application\Creditos\Compras\ComprasController@index')->name('creditosCompra');
Route::post('creditosPago', 'Application\Creditos\Compras\ComprasController@pagarCuota')->name('creditos.compras.pagarCuota');
Route::post('creditosDatos', 'Application\Creditos\Compras\ComprasController@Datos')->name('creditos.compras.Datos');
Route::post('creditosDatosP', 'Application\Creditos\Compras\ComprasController@DatosP')->name('creditos.compras.DatosP');
Route::post('creditosDetalle', 'Application\Creditos\Compras\ComprasController@Detalle')->name('creditos.compras.Detalle');

?>