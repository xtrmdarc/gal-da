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

Route::post('login','Login\login@login');

//Creditos

Route::get('/creditos', 'Creditos\Compras\ComprasController@index');

Route::prefix('/inicio')->group(function(){
    
    Route::get('/','Inicio\InicioController@Index');
    Route::post('RegistrarMesa','Inicio\InicioControlle@RMesa');
    Route::get('PedidoMesa/{cod}', function($cod){
        session(['cod_tipe'=>1]);
        return App::call('App\Http\Controllers\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });
    Route::post('DatosGrles','Inicio\InicioController@DatosGrles');
    Route::post('ListarPedidos','Inicio\InicioController@listarPedidos');
    Route::post('ListarCategorias','Inicio\InicioController@listarCategorias');
    Route::post('ListarProductos','Inicio\InicioController@listarProductos');
    Route::post('BuscarProducto','Inicio\InicioController@buscarProducto');
    //crud
    Route::post('RegistrarPedido','Inicio\InicioController@registrarPedido');
    Route::post('ListarDetallePed','Inicio\InicioController@ListarDetallePed');
    Route::post('ListarDetalleSubPed','Inicio\InicioController@ListarDetalleSubPed');
    Route::post('BuscarCliente','Inicio\InicioController@BuscarCliente');
    Route::post('preCuenta','Inicio\InicioController@preCuenta');
    Route::post('RegistrarVenta','Inicio\InicioController@RegistrarVenta');
    Route::post('CancelarPedido','Inicio\InicioController@CancelarPedido');
    Route::post('CambiarMesa','Inicio\InicioController@CambiarMesa');
    Route::post('ComboMesaOri','Inicio\InicioController@ComboMesaOri');
    Route::post('ComboMesaDes','Inicio\InicioController@ComboMesaDes');

    Route::post('DetalleMostrador','Inicio\InicioController@DetalleMostrador');
    Route::post('DetalleDelivery','Inicio\InicioController@DetalleDelivery');

    
    Route::post('ListarDelivery','Inicio\InicioController@ListarDelivery');
    Route::get('pedidoDelivery/{cod}', function($cod){
        session(['cod_tipe'=>3]);
        return App::call('App\Http\Controllers\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });
    Route::post('RegistrarDelivery','Inicio\InicioController@RegistrarDelivery');
    

    Route::post('ListarMostrador','Inicio\InicioController@ListarMostrador');
    Route::get('pedidoMostrador/{cod}',  function($cod){
        session(['cod_tipe'=>2]);
        return App::call('App\Http\Controllers\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });

});

Route::prefix('cocina')->group(function(){
    Route::get('/','AreaProd\AreaProdController@index');
    Route::post('/ListarM','AreaProd\AreaProdController@ListarM');
    Route::post('/ListarMO','AreaProd\AreaProdController@ListarMO');
    Route::post('/ListarDE','AreaProd\AreaProdController@ListarDE');
});


Route::prefix('caja')->group(function(){

    Route::prefix('aper')->group(function(){
        
        Route::get('/','Caja\Aper_CajaController@index');
        Route::post('datos','Caja\Aper_CajaController@datos');
        Route::post('montoSis','Caja\Aper_CajaController@montoSis');
        Route::post('montoSisDet','Caja\Aper_CajaController@montoSisDet');
        Route::get('Guardar','Caja\Aper_CajaController@Guardar');

    });
    Route::prefix('egr')->group(function(){

        Route::get('/','Caja\Egr_CajaController@index');
        Route::get('Guardar','Caja\Egr_CajaController@Guardar');
        Route::post('Estado','Caja\Egr_CajaController@Estado');
        
    });
    Route::prefix('ing')->group(function(){

        Route::get('/','Caja\Ing_CajaController@index');  
        Route::get('Guardar','Caja\Ing_CajaController@Guardar');      
        Route::post('Estado','Caja\Ing_CajaController@Estado');
    });
    
});

Route::prefix('cliente')->group(function(){

    Route::get('/','Cliente\ClienteController@index');
    Route::post('Estado','Cliente\ClienteController@Estado');
    Route::post('Eliminar','Cliente\ClienteController@Eliminar');
    

});


Route::prefix('cliente_e')->group(function(){
    
    //Route::get('/','Cliente\ClienteController@index_e');
    Route::get('/{id?}','Cliente\ClienteController@index_e');
    Route::post('RUCliente','Cliente\ClienteController@RUCliente');
    
});




Route::prefix('compras')->group(function(){

    Route::get('/','Compras\ComprasController@index');

    Route::get('crear','Compras\ComprasController@crear');
    Route::post('ObtenerDatos','Compras\ComprasController@obtenerDatos');
    Route::post('Detalle','Compras\ComprasController@detalle');

    Route::post('BuscarIns','Compras\ComprasController@buscarIns');
    Route::post('BuscarProv','Compras\ComprasController@buscarProv');

    Route::post('NuevoProv','Compras\ComprasController@nuevoProv');
    Route::post('GuardarCompra','Compras\ComprasController@GuardarCompra');
    Route::post('nuevoProv','Compras\ComprasController@nuevoProv');
    Route::post('AnularCompra','Compras\ComprasController@AnularCompra');
    

});

Route::prefix('proveedores')->group(function(){

    Route::get('/','Compras\ProveedorController@index');

    Route::get('crear','Compras\ProveedorController@crear');
    
    Route::get('editar/{id}','Compras\ProveedorController@editar');
    Route::post('RUProveedor','Compras\ProveedorController@RUProveedor');

});

Route::prefix('tablero')->group (function(){

    Route::get('/','Tablero\TableroController@index');
    Route::post('DatosGrls','Tablero\TableroController@datosGrls');
    Route::post('DatosGraf','Tablero\TableroController@datosGraf');

});
