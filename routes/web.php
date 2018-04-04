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
Route::post('ajustesCrudMesas', 'Config\tm_mesaController@CrudMesas')->name('config.CrudMesas');
Route::post('ajustesEliminarS', 'Config\tm_mesaController@EliminarS')->name('config.EliminarS');
Route::post('ajustesEliminarM', 'Config\tm_mesaController@EliminarM');

//Productos

Route::get('/ajustesProductos', 'Config\tm_productoController@index');
Route::post('ajustesListarCatg', 'Config\tm_productoController@ListaCatgs');
Route::post('ajustesCrudCatg', 'Config\tm_productoController@CrudCatg');
Route::post('ajustesCrudProd', 'Config\tm_productoController@CrudProd');
Route::post('ajustesCrudPres', 'Config\tm_productoController@CrudPres');
Route::post('ajustesComboCatg', 'Config\tm_productoController@ComboCatg');
Route::post('ajustesListarProductos', 'Config\tm_productoController@ListaProd');
Route::post('ajustesListarPres', 'Config\tm_productoController@ListaPres');

//Insumos

Route::get('/ajustesProductosInsumos', 'Config\tm_insumoController@index');
Route::post('ajustesListarCatgI', 'Config\tm_insumoController@ListaCatgs');
Route::post('ajustesCrudCatgI', 'Config\tm_insumoController@CrudCatg');
Route::post('ajustesCrudIns', 'Config\tm_insumoController@CrudIns');
Route::post('ajustesActualizarIns', 'Config\tm_insumoController@ActualizarIns');
Route::post('ajustesListarInsumos', 'Config\tm_insumoController@ListaIns');

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


//INFORMES

Route::get('/informes', 'Informes\tm_informesController@index')->name('config.Informes');

//Ventas

Route::get('/informesVentas', 'Informes\Ventas\inf_ventasController@index')->name('config.inf_ventas');
Route::post('informesDatosVentas', 'Informes\Ventas\inf_ventasController@Datos')->name('config.inf_ventas.Datos');
Route::post('informesDatosVentasDetalle', 'Informes\Ventas\inf_ventasController@Detalle')->name('config.inf_ventas.Detalle');
Route::post('informesDatosVentasExcel', 'Informes\Ventas\inf_ventasController@ExportExcel')->name('config.inf_ventas.ExportExcel');

//Ventas por Producto

Route::get('/informesVentasProducto', 'Informes\Ventas\inf_productosController@index')->name('config.inf_productos');
Route::post('informesDatosProductos', 'Informes\Ventas\inf_productosController@Datos')->name('config.inf_productos.Datos');

//Ventas Mozos

Route::get('/informesVentasMozos', 'Informes\Ventas\inf_mozosController@index')->name('config.inf_mozos');
Route::post('informesDatosMozos', 'Informes\Ventas\inf_mozosController@Datos');

//Venta por forma de Pago

Route::get('/informesVentasFpago', 'Informes\Ventas\inf_fpagoController@index');
Route::post('informesDatosFpago', 'Informes\Ventas\inf_fpagoController@Datos');

//Compras

Route::get('/informesCompras', 'Informes\Compras\inf_comprasController@index');
Route::post('informesDatosCompras', 'Informes\Compras\inf_comprasController@Datos');
Route::post('informesDetalleCompras', 'Informes\Compras\inf_comprasController@Detalle');
Route::post('informesDetalleCCompras', 'Informes\Compras\inf_comprasController@DetalleC');
Route::post('informesDetalleSCCompras', 'Informes\Compras\inf_comprasController@DetalleSC');

//Compras por Proveedores

Route::get('/informesComprasProveedores', 'Informes\Compras\inf_proveedorController@index');
Route::post('informesDatosProveedores', 'Informes\Compras\inf_proveedorController@Datos');
Route::post('informesDetalleProveedores', 'Informes\Compras\inf_proveedorController@Detalle');
Route::post('informesDetalleCProveedores', 'Informes\Compras\inf_proveedorController@DetalleC');
Route::post('informesDetalle_CProveedores', 'Informes\Compras\inf_proveedorController@Detalle_C');

//Finanzas

//Aperturas y Cierres de Caja

Route::get('/informesCajas', 'Informes\Finanzas\inf_cajasController@index');
Route::post('informesDatosCajas', 'Informes\Finanzas\inf_cajasController@Datos');
Route::post('informesMontoCajas', 'Informes\Finanzas\inf_cajasController@MontoSis');

//Ingresos de Caja

Route::get('/informesIngresos', 'Informes\Finanzas\inf_ingresosController@index');
Route::post('/informesDatosIngresos', 'Informes\Finanzas\inf_ingresosController@Datos');

//Egresos de Caja

Route::get('/informesEgresos', 'Informes\Finanzas\inf_egresosController@index');
Route::post('/informesDatosEgresos', 'Informes\Finanzas\inf_egresosController@Datos');

//Egresos por Remuneracion

Route::get('/informesRemuneracion', 'Informes\Finanzas\inf_remuneracionesController@index');
Route::post('/informesDatosRemuneraciones', 'Informes\Finanzas\inf_egresosController@Datos');

//Kardex

Route::get('/informesKardex', 'Informes\Inventario\inf_kardexController@index');
Route::post('informesDatosKardex', 'Informes\Inventario\inf_kardexController@Datos');
Route::post('informesComboIPKardex', 'Informes\Inventario\inf_kardexController@ComboIP');