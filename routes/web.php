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

Route::get('/cocina','AreaProd\AreaProdController@index');
Route::prefix('caja')->group(function(){
    
    Route::prefix('aper')->group(function(){
        
        Route::get('/','Caja\Aper_CajaController@index');
        Route::post('datos','Caja\Aper_CajaController@datos');
        Route::post('montoSis','Caja\Aper_CajaController@montoSis');
        Route::post('montoSisDet','Caja\Aper_CajaController@montoSisDet');

    });
    Route::prefix('egr')->group(function(){

        Route::get('/','Caja\Egr_CajaController@index');
        
        
    });
    Route::prefix('ing')->group(function(){

        Route::get('/','Caja\Ing_CajaController@index');        

    });
    
});


Route::get('/clientes','Cliente\ClienteController@index');
Route::get('/clientes_e/{id}','Cliente\ClienteController@index_e');

Route::prefix('compras')->group(function(){

    Route::get('/','Compras\ComprasController@index');

    Route::get('crear','Compras\ComprasController@crear');
    Route::post('ObtenerDatos','Compras\ComprasController@obtenerDatos');
    Route::post('Detalle','Compras\ComprasController@detalle');

    Route::post('BuscarIns','Compras\ComprasController@buscarIns');
    Route::post('BuscarProv','Compras\ComprasController@buscarProv');

    Route::post('NuevoProv','Compras\ComprasController@nuevoProv');
});

Route::prefix('proveedores')->group(function(){

    Route::get('/','Compras\ProveedorController@index');

    Route::get('crear','Compras\ProveedorController@crear');
    
    Route::get('editar/{id}','Compras\ProveedorController@editar');

});

Route::get('tablero','Tablero\TableroController@index');