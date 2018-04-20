<?php

    Route::prefix('tablero')->group (function(){

        Route::get('/','Application\Tablero\TableroController@index')->name('tablero');
        Route::post('DatosGrls','Application\Tablero\TableroController@datosGrls');
        Route::post('DatosGraf','Application\Tablero\TableroController@datosGraf');
    });

?>