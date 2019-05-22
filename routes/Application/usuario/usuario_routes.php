<?php
//Application\Usuario - Perfil - Pago - Suscripcion

Route::get('/perfil', 'Application\Usuario\UsuarioController@i_perfil')->name('ajustes.i_perfil');
Route::post('/perfil', 'Application\Usuario\UsuarioController@i_perfilEditar')->name('ajustes.i_perfilEditar');

Route::get('/pago', 'Application\Usuario\UsuarioController@i_pago')->name('ajustes.i_pago');
Route::get('/suscripcion', 'Application\Usuario\UsuarioController@i_suscripcion')->name('ajustes.i_suscripcion');

Route::post('/password', 'Application\Usuario\UsuarioController@changePassword')->name('ajustes.usuario.changepassword');

Route::post('/actualizarTarjeta', 'Application\Usuario\UsuarioController@actualizarTarjeta')->name('app.subscription.actualizar_tarjeta');
Route::post('/ajustesListaRecibos', 'Application\Usuario\UsuarioController@listarRecibos')->name('config.ListarRecibos');
Route::get('recibo_descargar_pdf/{id_g}', 'Application\Usuario\UsuarioController@downloadPdf')->name('recibo_descargarPdf');
?>