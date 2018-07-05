<?php

Route::prefix('cocina')->group(function(){
    Route::get('/','Application\AreaProd\AreaProdController@index');
    Route::post('/ListarM','Application\AreaProd\AreaProdController@ListarM');
    Route::post('/ListarMO','Application\AreaProd\AreaProdController@ListarMO');
    Route::post('/ListarDE','Application\AreaProd\AreaProdController@ListarDE');
    Route::post('/Preparacion','Application\AreaProd\AreaProdController@Preparacion');
    Route::post('/Atendido','Application\AreaProd\AreaProdController@Atendido');
    Route::post('/FiltroListaPedido','Application\AreaProd\AreaProdController@PedidosLista');
    Route::post('/CocinaData','Application\AreaProd\AreaProdController@CocinaData');
    
});


?>