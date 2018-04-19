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
//Includes de rutas por módulo
    include 'areaprod/areaprod_routes.php';
    include 'caja/cajas_routes.php';
    include 'cliente/cliente_routes.php';
    include 'compras/compras_routes.php';
    include 'config/config_routes.php';
    include 'creditos/creditos_routes.php';
    include 'informes/compras_routes.php';
    include 'informes/finanzas_routes.php';
    include 'informes/inventario_routes.php';
    include 'informes/ventas_routes.php';
    include 'informes/informes_routes.php';
    include 'inicio/inicio_routes.php';
    include 'proveedor/proveedor_routes.php';
    include 'tablero/tablero_routes.php';

//

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/','HomeController@welcome_main')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');


/*Application Gal - Da*/

Route::get('/dashboard','Application\AHomeController@index')->name('Aindex');