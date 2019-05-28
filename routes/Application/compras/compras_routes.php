<?php  

Route::prefix('compras')->group(function(){

    Route::get('/','Application\Compras\ComprasController@index')->name('compras');

    Route::get('crear','Application\Compras\ComprasController@crear');
    Route::post('ObtenerDatos','Application\Compras\ComprasController@obtenerDatos');
    Route::post('Detalle','Application\Compras\ComprasController@detalle');

    Route::post('BuscarIns','Application\Compras\ComprasController@buscarIns');
    Route::post('BuscarProv','Application\Compras\ComprasController@buscarProv');

    Route::post('NuevoProv','Application\Compras\ComprasController@nuevoProv');
    Route::post('GuardarCompra','Application\Compras\ComprasController@GuardarCompra');
    Route::post('nuevoProv','Application\Compras\ComprasController@nuevoProv');
    Route::post('AnularCompra','Application\Compras\ComprasController@AnularCompra');
    

});

Route::prefix('proveedores')->group(function(){

    Route::get('/','Application\Compras\ProveedorController@index')->name('proveedores');

    Route::get('crear','Application\Compras\ProveedorController@crear')->name('NuevoProveedor');
    
    Route::get('editar/{id_por_cuenta}','Application\Compras\ProveedorController@editar')->name('EditarProveedor');
    Route::post('RUProveedor','Application\Compras\ProveedorController@RUProveedor');
    Route::post('Estado','Application\Compras\ProveedorController@Estado');

});

?>