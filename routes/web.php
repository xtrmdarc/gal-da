<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Login\login@index');

//Creditos

Route::get('/creditos', 'Creditos\Compras\ComprasController@index');
Route::post('creditosPago', 'Creditos\Compras\ComprasController@pagarCuota')->name('creditos.compras.pagarCuota');
Route::post('creditosDatos', 'Creditos\Compras\ComprasController@Datos')->name('creditos.compras.Datos');
Route::post('creditosDatosP', 'Creditos\Compras\ComprasController@DatosP')->name('creditos.compras.DatosP');
Route::post('creditosDetalle', 'Creditos\Compras\ComprasController@Detalle')->name('creditos.compras.Detalle');