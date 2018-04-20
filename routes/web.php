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

//Includes de rutas por módulo
include 'Web/areaprod/areaprod_routes.php';
include 'Web/caja/cajas_routes.php';
include 'Web/cliente/cliente_routes.php';
include 'Web/compras/compras_routes.php';
include 'Web/config/config_routes.php';
include 'Web/creditos/creditos_routes.php';
include 'Web/informes/compras_routes.php';
include 'Web/informes/finanzas_routes.php';
include 'Web/informes/inventario_routes.php';
include 'Web/informes/ventas_routes.php';
include 'Web/informes/informes_routes.php';
include 'Web/inicio/inicio_routes.php';
include 'Web/proveedor/proveedor_routes.php';
include 'Web/tablero/tablero_routes.php';
//

Route::get('/','Web\HomeController@welcome_main')->name('welcome');

/**********************************  APPLICATION  **********************************/

Route::get('/dashboard','Application\AHomeController@index')->name('Aindex');