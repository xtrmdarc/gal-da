<?php
Route::prefix('caja')->group(function(){

    Route::prefix('aper')->group(function(){
        
        Route::get('/','Application\Caja\Aper_CajaController@index')->name('apercaja');
        Route::post('datos','Application\Caja\Aper_CajaController@datos');
        Route::post('montoSis','Application\Caja\Aper_CajaController@montoSis');
        Route::post('MontoSisDet','Application\Caja\Aper_CajaController@montoSisDet');
        Route::get('Guardar','Application\Caja\Aper_CajaController@Guardar');

    });
    Route::prefix('egr')->group(function(){

        Route::get('/','Application\Caja\Egr_CajaController@index')->name('egrcaja');
        Route::get('Guardar','Application\Caja\Egr_CajaController@Guardar');
        Route::post('Estado','Application\Caja\Egr_CajaController@Estado');
        
    });
    Route::prefix('ing')->group(function(){

        Route::get('/','Application\Caja\Ing_CajaController@index')->name('ingcaja');
        Route::get('Guardar','Application\Caja\Ing_CajaController@Guardar');      
        Route::post('Estado','Application\Caja\Ing_CajaController@Estado');
        
    });

});

?>