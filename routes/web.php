<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/************************************  WEB  **********************************/
/*Autn*/
include 'Web/auth.php';
/*Home*/
include 'Web/home.php';

Route::get('/','Web\HomeController@welcome_main')->name('welcome');

/**********************************  APPLICATION  **********************************/

Route::get('/dashboard','Application\AHomeController@index')->name('Aindex');