<?php

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

//Route::post('register', 'Web\AuthController@store')->name('web.auth.register.store');
Route::post('register', 'Web\AuthController@store_account')->name('web.auth.register.store_account');
Route::post('registerI', 'Web\AuthController@store_account_info')->name('web.auth.register.store_account_info');
Route::post('registerB', 'Web\AuthController@store_account_business')->name('web.auth.register.store_account_business');

Route::get('register', 'Web\AuthController@show_account_v')->name('register');
Route::get('registerI', 'Web\AuthController@show_account_info_v')->name('registerInfo');
Route::get('registerB', 'Web\AuthController@show_account_business_v')->name('registerBusiness');
Route::get('verifyEmailFirst', 'Web\AuthController@verifyEmailFirst')->name('verifyEmailFirst');
Route::get('verify/{email}/{verifyToken}', 'Web\AuthController@sendEmailDone')->name('sendEmailDone');
Route::get('verifySubUser/{email}/{verifyToken}', 'Web\AuthController@verificarTokenSubUsuario')->name('verificarTokenSubUsuario');
Route::post('activarSubUsuario','Web\AuthController@activarSubUsuario')->name('activarSubUsuario');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');