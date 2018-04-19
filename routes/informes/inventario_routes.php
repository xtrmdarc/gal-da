<?php
//Kardex

Route::get('/informesKardex', 'Application\Informes\Inventario\KardexController@index')->name('inf_kardex');
Route::post('informesDatosKardex', 'Application\Informes\Inventario\KardexController@Datos');
Route::post('informesComboIPKardex', 'Application\Informes\Inventario\KardexController@ComboIP');
?>