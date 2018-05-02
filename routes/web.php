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

/************************************  WEB  **********************************/
/*Autn*/
include 'Web/auth.php';
/*Home*/
include 'Web/home.php';

//Includes de rutas por m�dulo
include 'Application/areaprod/areaprod_routes.php';
include 'Application/caja/cajas_routes.php';
include 'Application/cliente/cliente_routes.php';
include 'Application/compras/compras_routes.php';
include 'Application/config/config_routes.php';
include 'Application/creditos/creditos_routes.php';
include 'Application/informes/compras_routes.php';
include 'Application/informes/finanzas_routes.php';
include 'Application/informes/inventario_routes.php';
include 'Application/informes/ventas_routes.php';
include 'Application/informes/informes_routes.php';
include 'Application/inicio/inicio_routes.php';
include 'Application/proveedor/proveedor_routes.php';
include 'Application/tablero/tablero_routes.php';
//

Route::get('/','Web\HomeController@welcome_main')->name('welcome');

/**********************************  APPLICATION  **********************************/

//Route::get('/dashboard','Application\AHomeController@index')->name('Aindex');
//Route::get('/dashboard','Application\AHomeController@index')->name('Aindex');

