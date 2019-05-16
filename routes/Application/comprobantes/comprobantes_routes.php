<?php

use Illuminate\Support\Facades\Route;


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
            Route::post('/BuscarBoletas','Application\Comprobantes\BoletasController@buscarBoletas');
            
            // Las boletas se envian en resumen diario
            // Route::post('/EnviarFactura','Application\Comprobantes\FacturasController@enviarFacturaSunat');
            // Route::post('/ObtenerFacturaXID','Application\Comprobantes\FacturasController@getFacturaInvoiceXID');
        });
        // Rutas para notas 
        Route::prefix('nota')->group(function(){
            //Funciones que pueden compartir
            Route::post('ObtenerComprobanteYDetalles','Application\Comprobantes\NotasController@obtenerComprobanteYDetalles');
            Route::post('ListarFolios','Application\Comprobantes\NotasController@listarFolios');
            
            // Nota de credito 
            Route::prefix('credito')->group(function(){
                Route::get('/','Application\Comprobantes\NotasController@indexCredito')->name('comprobantes.nota_cred');
                Route::post('RegistrarNotaCredito','Application\Comprobantes\NotasController@registrarNotaCredito');
                Route::post('BuscarNotasCred','Application\Comprobantes\NotasController@buscarNotasCred');
                Route::post('ListarFoliosNotaCredito','Application\Comprobantes\NotasController@listarFoliosNotaCredito');
                
            });
            // Nota de debito
            
            Route::prefix('debito')->group(function(){
                Route::get('/','Application\Comprobantes\NotasController@indexDebito')->name('comprobantes.nota_deb');
            });
        });
        // Rutas para resumen
        Route::prefix('resumen')->group(function(){

            Route::get('/','Application\Comprobantes\ResumenesController@index')->name('comprobantes.resumen');
            Route::post('/ExisteComprobantesEnviar','Application\Comprobantes\ResumenesController@existenComprobantesParaResumen');
            Route::post('/BuscarDocsResumenPorFecha','Application\Comprobantes\ResumenesController@buscarDocsResumenPorFecha');
            Route::post('/EnviarResumen','Application\Comprobantes\ResumenesController@enviarResumenSunat');
            Route::post('/BuscarResumenes','Application\Comprobantes\ResumenesController@buscarResumenes');
            Route::post('/ConsultarEstado','Application\Comprobantes\ResumenesController@consultarEstadoResumen');
            Route::post('/EliminarResumen','Application\Comprobantes\ResumenesController@eliminarResumen');
            Route::post('/ReenviarResumen','Application\Comprobantes\ResumenesController@reenviarResumen');
            Route::post('/BuscarDocsResumenPorIdResumen','Application\Comprobantes\ResumenesController@buscarDocsResumenPorIdResumen');

        });

    });




?>