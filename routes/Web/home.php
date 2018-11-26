<?php

Route::get('/home', 'Web\HomeController@welcome_main')->name('home');
Route::get('pricing', 'Web\HomeController@prices')->name('prices');
Route::get('/testmail','Web\HomeController@testmail');
Route::get('/testpagar', 'Web\HomeController@test_pagar');
/*HelpCenter*/

Route::prefix('helpCenter')->group(function(){

    Route::get('/', 'Web\HomeController@helpCenter')->name('helpCenter');

    Route::prefix('primerosPasos')->group(function(){
        Route::get('/', 'Web\HelpCenterController@primeros_pasos')->name('primerosPasos');
    });
    Route::prefix('manualGal-da')->group(function(){
        Route::get('/', 'Web\HelpCenterController@manual_galda')->name('manual_galda');
    });

});
