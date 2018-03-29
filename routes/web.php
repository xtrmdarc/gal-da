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

Route::get('/', 'Login\login@index');

//Creditos

Route::get('/creditos', 'Creditos\Compras\ComprasController@index');
Route::post('creditosPago', 'Creditos\Compras\ComprasController@pagarCuota')->name('creditos.compras.pagarCuota');
Route::post('creditosDatos', 'Creditos\Compras\ComprasController@Datos')->name('creditos.compras.Datos');
Route::post('creditosDatosP', 'Creditos\Compras\ComprasController@DatosP')->name('creditos.compras.DatosP');
Route::post('creditosDetalle', 'Creditos\Compras\ComprasController@Detalle')->name('creditos.compras.Detalle');

//Configuracion - Restaurante

Route::get('/ajustes', 'Config\tm_otrosController@index');

//Caja

Route::get('/ajustesCaja', 'Config\tm_cajaController@index');
Route::post('ajustesListaCaja', 'Config\tm_cajaController@ListaCajas')->name('config.ListaCajas');
Route::post('ajustesCrudCaja', 'Config\tm_cajaController@CrudCaja')->name('config.CrudCaja');

//Almacen

Route::get('/ajustesAlmacen', 'Config\tm_almacenController@index');
Route::post('ajustesListaAlmacen', 'Config\tm_almacenController@ListaAlmacenes')->name('config.ListaAlmacenes');
Route::post('ajustesListaAreasP', 'Config\tm_almacenController@ListaAreasP')->name('config.ListaAreasP');
Route::post('ajustesCrudAlmacen', 'Config\tm_almacenController@CrudAlmacen')->name('config.CrudAlmacen');
Route::post('ajustesCrudAreaP', 'Config\tm_almacenController@CrudAreaP')->name('config.CrudAreaP');
Route::post('ajustesComboAlm', 'Config\tm_almacenController@ComboAlm')->name('config.ComboAlm');

//Salon y Mesas

Route::get('/ajustesSalonyMesas', 'Config\tm_mesaController@index');
Route::post('ajustesListaSalones', 'Config\tm_mesaController@ListaSalones')->name('config.ListaSalones');
Route::post('ajustesListaMesas', 'Config\tm_mesaController@ListaMesas')->name('config.ListaMesas');
Route::post('ajustesCrudSalones', 'Config\tm_mesaController@CrudSalones')->name('config.CrudSalones');
Route::post('ajustesEliminarS', 'Config\tm_mesaController@EliminarS')->name('config.EliminarS');
Route::post('ajustesEliminarM', 'Config\tm_mesaController@EliminarM');

//Productos

Route::get('/ajustesProductos', 'Config\tm_productoController@index');
Route::post('ajustesCrudCatg', 'Config\tm_productoController@CrudCatg')->name('config.CrudCatg');
Route::post('ajustesListaCatgs', 'Config\tm_productoController@ListaCatgs')->name('config.ListaCatgs');
Route::post('ajustesListaProd', 'Config\tm_productoController@ListaProd')->name('config.ListaProd');

//Configuracion - Sistema

//Datos en la Empresa

Route::get('/ajustesDatosEmpresa', 'Config\tm_otrosController@datosEmpresa')->name('config.DatosEmpresa');
Route::get('/ajustesTipoDocumento', 'Config\tm_otrosController@tiposdeDocumentos')->name('config.tiposdeDocumentos');
Route::post('/ajustesListaTipoDocumento', 'Config\tm_otrosController@ListarTD')->name('config.tiposdeDocumentosListar');
Route::post('/ajustesGuardarTipoDocumento', 'Config\tm_otrosController@GuardarTD')->name('config.tiposdeDocumentosGuardar');
Route::post('/ajustesDatosEmpresa', 'Config\tm_otrosController@GuardarDE');

//Tipo de Documentos

Route::get('/ajustesDocumentos', 'Config\tm_almacenController@index');

//Usuarios

Route::get('/ajustesUsuarios', 'Config\tm_usuarioController@index')->name('config.Usuarios');
Route::get('/ajustesRUsuario/{id_usu}', 'Config\tm_usuarioController@CrudUsuario');
Route::get('/ajustesRegistrarUsuario', 'Config\tm_usuarioController@RegistrarUsuario');
Route::post('/ajustesRUsuario', 'Config\tm_usuarioController@RUUsuario');
Route::post('/ajustesEliminar', 'Config\tm_usuarioController@Eliminar');
