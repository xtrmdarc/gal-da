<?php

    Route::get('CambioSucursal/{id}','Application\AppController@CambioSucursal');
    Route::post('EnviarFeedback','Application\AppController@EnviarFeedback');
    Route::post('UserOnboarded','Application\AppController@UserOnboarded');
?>