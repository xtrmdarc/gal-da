<?php

    Route::get('/tableroF', 'Application\TableroF\TableroFController@index')->name('tableroF');
    Route::post('/graficoVentasyMonto', 'Application\TableroF\TableroFController@graficoVentasyMonto')->name('tableroF.gradicoVyM');
    
?>