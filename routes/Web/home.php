<?php

Route::get('/home', 'Web\HomeController@welcome_main')->name('home');
Route::get('prices', 'Web\HomeController@prices')->name('prices');
