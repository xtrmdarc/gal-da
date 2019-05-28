<?php 
    //Application\Configuracion - Restaurante

    Route::get('/ajustes', 'Application\Config\OtrosController@index')->name('ajustes');

    //Caja

    Route::get('/ajustesCaja', 'Application\Config\CajaController@index')->name('config.Cajas');
    Route::post('ajustesListaCaja', 'Application\Config\CajaController@ListaCajas')->name('config.ListaCajas');
    Route::post('ajustesCrudCaja', 'Application\Config\CajaController@CrudCaja')->name('config.CrudCaja');
    Route::post('/ajustesEliminarCaja', 'Application\Config\CajaController@Eliminar')->name('config.Caja.Eliminar');
    
    //Almacen

    Route::get('/ajustesAlmacen', 'Application\Config\AlmacenController@index')->name('config.Almacen');
    Route::post('ajustesListaAlmacen', 'Application\Config\AlmacenController@ListaAlmacenes')->name('config.ListaAlmacenes');
    Route::post('ajustesListaAreasP', 'Application\Config\AlmacenController@ListaAreasP')->name('config.ListaAreasP');
    Route::post('ajustesCrudAlmacen', 'Application\Config\AlmacenController@CrudAlmacen')->name('config.CrudAlmacen');
    Route::post('ajustesCrudAreaP', 'Application\Config\AlmacenController@CrudAreaP')->name('config.CrudAreaP');
    Route::post('ajustesComboAlm', 'Application\Config\AlmacenController@ComboAlm')->name('config.ComboAlm');

    //Salon y Mesas

    Route::get('/ajustesSalonyMesas', 'Application\Config\MesaController@index')->name('config.SalonesMesas');
    Route::post('ajustesListaSalones', 'Application\Config\MesaController@ListaSalones')->name('config.ListaSalones');
    Route::post('ajustesListaMesas', 'Application\Config\MesaController@ListaMesas')->name('config.ListaMesas');
    Route::post('ajustesCrudSalones', 'Application\Config\MesaController@CrudSalones')->name('config.CrudSalones');
    Route::post('ajustesCrudMesas', 'Application\Config\MesaController@CrudMesas')->name('config.CrudMesas');
    Route::post('ajustesEliminarS', 'Application\Config\MesaController@EliminarS')->name('config.EliminarS');
    Route::post('ajustesEliminarM', 'Application\Config\MesaController@EliminarM');
    Route::post('ajustesEstadoM', 'Application\Config\MesaController@EstadoM')->name('config.EstadoM');

    //Productos

    Route::get('/ajustesProductos', 'Application\Config\ProductoController@index')->name('config.Productos');
    Route::post('ajustesListarSucursalesProd', 'Application\Config\ProductoController@ListaSucursalesProd');
    Route::post('ajustesListarCatg', 'Application\Config\ProductoController@ListaCatgs');
    Route::post('ajustesCrudCatg', 'Application\Config\ProductoController@CrudCatg');
    Route::post('ajustesCrudProd', 'Application\Config\ProductoController@CrudProd');
    Route::post('ajustesCrudPres', 'Application\Config\ProductoController@CrudPres');
    Route::post('ajustesComboCatg', 'Application\Config\ProductoController@ComboCatg');
    Route::post('ajustesListarProductos', 'Application\Config\ProductoController@ListaProd');
    Route::post('ajustesListarPres', 'Application\Config\ProductoController@ListaPres');
    Route::post('AreasProdXSucursal', 'Application\Config\ProductoController@AreasProdXSucursal');
    Route::post('CategoriasXSucursal', 'Application\Config\ProductoController@CategoriasXSucursal');

    //Ingredientes

    Route::post('ajustesListarIngredientes', 'Application\Config\ProductoController@ListaIngs');
    Route::post('ajustesBuscarIngredientes', 'Application\Config\ProductoController@BuscarIns');
    Route::post('ajustesComboUMedida', 'Application\Config\ProductoController@ComboUniMed');
    Route::post('ajustesGuardarIng', 'Application\Config\ProductoController@GuardarIng');
    Route::post('ajustesEliminarIng', 'Application\Config\ProductoController@EIng');

    //Insumos

    Route::get('/ajustesProductosInsumos', 'Application\Config\InsumoController@index')->name('config.Insumos');
    Route::post('ajustesListarSucursalesInsum', 'Application\Config\InsumoController@ListaSucursalesInsum');
    Route::post('ajustesListarCatgI', 'Application\Config\InsumoController@ListaCatgs');
    Route::post('ajustesCrudCatgI', 'Application\Config\InsumoController@CrudCatg');
    Route::post('ajustesCrudIns', 'Application\Config\InsumoController@CrudIns');
    Route::post('ajustesActualizarIns', 'Application\Config\InsumoController@ActualizarIns');
    Route::post('ajustesListarInsumos', 'Application\Config\InsumoController@ListaIns');
    Route::post('CategoriasIXSucursal', 'Application\Config\InsumoController@CategoriasXSucursal');
    
    //Application\Configuracion - Sistema

    //Datos en la Empresa

    Route::get('/ajustesDatosEmpresa', 'Application\Config\OtrosController@datosEmpresa')->name('config.DatosEmpresa');
    Route::get('/ajustesTipoDocumento', 'Application\Config\OtrosController@tiposdeDocumentos')->name('config.TiposdeDocumentos');
    Route::post('/ajustesListaTipoDocumento', 'Application\Config\OtrosController@ListarTD')->name('config.tiposdeDocumentosListar');
    Route::post('/ajustesGuardarTipoDocumento', 'Application\Config\OtrosController@GuardarTD')->name('config.tiposdeDocumentosGuardar');
    Route::post('/ajustesDatosEmpresa', 'Application\Config\OtrosController@GuardarDE');

    //Facturacion
    Route::get('/ajustesFacturacion', 'Application\Config\OtrosController@configFacturacion')->name('config.Facturacion');
    Route::post('/ajustesFacturacion', 'Application\Config\OtrosController@guardarConfigFacturacion')->name('config.guardarFacturacion');
    //Tipo de Documentos

    Route::get('/ajustesDocumentos', 'Application\Config\AlmacenController@index');

    //Usuarios

    Route::get('/ajustesUsuarios', 'Application\Config\UsuarioController@index')->name('config.Usuarios');
    Route::get('/ajustesRUsuario/{id_usu}', 'Application\Config\UsuarioController@CrudUsuario');
    Route::get('/ajustesRegistrarUsuario', 'Application\Config\UsuarioController@RegistrarUsuario');
    Route::post('/ajustesRUsuario', 'Application\Config\UsuarioController@RUUsuario');
    Route::post('/ajustesEliminar', 'Application\Config\UsuarioController@Eliminar');
    Route::post('/ajustesUsuarioEstado', 'Application\Config\UsuarioController@Estado');
    Route::post('/areasProdXSucursal','Application\Config\UsuarioController@GetAreasProdXSucursal' );

    //Sucursal

    Route::get('/ajustesSucursal', 'Application\Config\SucursalController@index')->name('config.Sucursal');
    Route::post('ajustesListaSucursales', 'Application\Config\SucursalController@ListaSucursales')->name('config.ListaSucursales');
    Route::post('ajustesCrudSucursal', 'Application\Config\SucursalController@CrudSucursal')->name('config.CrudSucursal');

    //Turnos

    Route::get('/ajustesTurnos', 'Application\Config\TurnosController@index')->name('config.Turnos');
    Route::post('ajustesListaTurnos', 'Application\Config\TurnosController@ListarTurnos')->name('config.ListaTurnos');
    Route::post('ajustesCrudTurnos', 'Application\Config\TurnosController@GuardarTurnos')->name('config.CrudTurnos');
    Route::post('ajustesEliminarTurno', 'Application\Config\TurnosController@EliminarTurno')->name('config.EliminarTurno');
?>