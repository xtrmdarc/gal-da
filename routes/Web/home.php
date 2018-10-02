<?php

Route::get('/home', 'Web\HomeController@welcome_main')->name('home');
Route::get('pricing', 'Web\HomeController@prices')->name('prices');
Route::get('/testmail','Web\AuthController@senEmail');
