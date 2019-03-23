<?php


    Route::prefix('comprobantes')->group(function(){
        // Rutas para facturas
        Route::prefix('factura')->group(function(){
            Route::get('/','Application\Comprobantes\FacturasController@index')->name('comprobantes.factura');
            Route::post('/BuscarFacturas','Application\Comprobantes\FacturasController@buscarFacturas');
            Route::post('/EnviarFactura','Application\Comprobantes\FacturasController@enviarFacturaSunat');
            Route::post('/ObtenerFacturaXID','Application\Comprobantes\FacturasController@getFacturaInvoiceXID');
            
        });
        // Rutas para boletas
        Route::prefix('boleta')->group(function(){
            Route::get('/','Application\Comprobantes\BoletasController@index')->name('comprobantes.boleta');
        });
        // Rutas para notas 
        Route::prefix('nota')->group(function(){
            Route::get('/','Application\Comprobantes\NotasController@index')->name('comprobantes.nota');
        });
        // Rutas para resumen
        Route::prefix('resumen')->group(function(){
            Route::get('/','Application\Comprobantes\ResumenesController@index')->name('comprobantes.resumen');
        });

    });




?>