<?php

Route::prefix('cliente')->group(function(){

    Route::get('/','Application\Cliente\ClienteController@index')->name('clientes');
    Route::post('Estado','Application\Cliente\ClienteController@Estado');
    Route::post('Eliminar','Application\Cliente\ClienteController@Eliminar');
});
Route::prefix('cliente_e')->group(function(){
    
    //Route::get('/','Cliente\ClienteController@index_e');
    Route::get('/{id?}','Application\Cliente\ClienteController@index_e')->name('cucliente');
    Route::post('RUCliente','Application\Cliente\ClienteController@RUCliente');
    
});

?>