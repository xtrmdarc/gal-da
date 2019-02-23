
<?php
//Finanzas

//Aperturas y Cierres de Caja

Route::get('/informesCajas', 'Application\Informes\Finanzas\AperCajaController@index')->name('inf_apercaja');
Route::post('informesDatosCajas', 'Application\Informes\Finanzas\AperCajaController@Datos');
Route::post('informesMontoCajas', 'Application\Informes\Finanzas\AperCajaController@MontoSis');
Route::post('informesDatosApertyCierrExcel', 'Application\Informes\Finanzas\AperCajaController@ExportExcel')->name('config.Finanzas.ExportExcel');

//Ingresos de Caja

Route::get('/informesIngresos', 'Application\Informes\Finanzas\IngresosCajaController@index')->name('inf_ingcaja');
Route::post('/informesDatosIngresos', 'Application\Informes\Finanzas\IngresosCajaController@Datos');
Route::post('informesDatosIngExcel', 'Application\Informes\Finanzas\IngresosCajaController@ExportExcel')->name('config.Finanzas.ingresos.ExportExcel');

//Egresos de Caja

Route::get('/informesEgresos', 'Application\Informes\Finanzas\EgresosCajaController@index')->name('inf_egrcaja');
Route::post('/informesDatosEgresos', 'Application\Informes\Finanzas\EgresosCajaController@Datos');
Route::post('informesDatosEgreExcel', 'Application\Informes\Finanzas\EgresosCajaController@ExportExcel')->name('config.Finanzas.egresos.ExportExcel');

//Egresos por Remuneracion

Route::get('/informesRemuneracion', 'Application\Informes\Finanzas\RemuneracionesController@index')->name('inf_remu');
Route::post('/informesDatosRemuneraciones', 'Application\Informes\Finanzas\RemuneracionesController@Datos');
Route::post('informesDatosRemunExcel', 'Application\Informes\Finanzas\RemuneracionesController@ExportExcel')->name('config.Finanzas.remuneraciones.ExportExcel');

?>