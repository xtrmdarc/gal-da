<?php
//Application\Usuario - Perfil - Pago - Suscripcion

Route::get('/perfil', 'Application\Usuario\UsuarioController@i_perfil')->name('ajustes.i_perfil');
Route::post('/perfilEditar', 'Application\Usuario\UsuarioController@i_perfilEditar')->name('ajustes.i_perfilEditar');


Route::get('/pago', 'Application\Usuario\UsuarioController@i_pago')->name('ajustes.i_pago');
Route::get('/suscripcion', 'Application\Usuario\UsuarioController@i_suscripcion')->name('ajustes.i_suscripcion');


?>