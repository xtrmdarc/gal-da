
<?php
//Finanzas

//Aperturas y Cierres de Caja

Route::get('/informesCajas', 'Application\Informes\Finanzas\AperCajaController@index')->name('inf_apercaja');
Route::post('informesDatosCajas', 'Application\Informes\Finanzas\AperCajaController@Datos');
Route::post('informesMontoCajas', 'Application\Informes\Finanzas\AperCajaController@MontoSis');

//Ingresos de Caja

Route::get('/informesIngresos', 'Application\Informes\Finanzas\IngresosCajaController@index')->name('inf_ingcaja');
Route::post('/informesDatosIngresos', 'Application\Informes\Finanzas\IngresosCajaController@Datos');

//Egresos de Caja

Route::get('/informesEgresos', 'Application\Informes\Finanzas\EgresosCajaController@index')->name('inf_egrcaja');
Route::post('/informesDatosEgresos', 'Application\Informes\Finanzas\EgresosCajaController@Datos');

//Egresos por Remuneracion

Route::get('/informesRemuneracion', 'Application\Informes\Finanzas\RemuneracionesController@index')->name('inf_remu');
Route::post('/informesDatosRemuneraciones', 'Application\Informes\Finanzas\EgresosCajaController@Datos');

?>