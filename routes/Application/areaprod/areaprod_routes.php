<?php

Route::prefix('cocina')->group(function(){
    Route::get('/','Application\AreaProd\AreaProdController@index');
    Route::post('/ListarM','Application\AreaProd\AreaProdController@ListarM');
    Route::post('/ListarMO','Application\AreaProd\AreaProdController@ListarMO');
    Route::post('/ListarDE','Application\AreaProd\AreaProdController@ListarDE');
    Route::post('/Preparacion','Application\AreaProd\AreaProdController@Preparacion');
    
});


?>