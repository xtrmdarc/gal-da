<?php
Route::prefix('/inicio')->group(function(){
    
    Route::get('/','Application\Inicio\InicioController@Index')->name('produccion');
    Route::post('RegistrarMesa','Application\Inicio\InicioController@RMesa');
    Route::get('PedidoMesa/{cod}', function($cod){
        session(['cod_tipe'=>1]);
        return App::call('App\Http\Controllers\Application\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });
    Route::post('DatosGrles','Application\Inicio\InicioController@DatosGrles');
    Route::post('ListarPedidos','Application\Inicio\InicioController@listarPedidos');
    Route::post('ListarCategorias','Application\Inicio\InicioController@listarCategorias');
    Route::post('ListarProductos','Application\Inicio\InicioController@listarProductos');
    Route::post('BuscarProducto','Application\Inicio\InicioController@buscarProducto'); 
    Route::post('VerificarMozoPIN','Application\Inicio\InicioController@VerificarMozoPIN');
    Route::get('ImprimirPC/{cod}','Application\Inicio\InicioController@ImprimirPC');
    Route::get('Imprimir/{cod}','Application\Inicio\InicioController@Imprimir');
    //crud
    Route::post('RegistrarPedido','Application\Inicio\InicioController@registrarPedido');
    Route::post('ListarDetallePed','Application\Inicio\InicioController@ListarDetallePed');
    Route::post('ListarDetalleSubPed','Application\Inicio\InicioController@ListarDetalleSubPed');
    Route::post('BuscarCliente','Application\Inicio\InicioController@BuscarCliente');
    Route::post('preCuenta','Application\Inicio\InicioController@preCuenta');
    Route::post('RegistrarVenta','Application\Inicio\InicioController@RegistrarVenta');
    Route::post('CancelarPedido','Application\Inicio\InicioController@CancelarPedido');
    Route::post('CambiarMesa','Application\Inicio\InicioController@CambiarMesa');
    Route::post('ComboMesaOri','Application\Inicio\InicioController@ComboMesaOri');
    Route::post('ComboMesaDes','Application\Inicio\InicioController@ComboMesaDes');
    Route::post('FinalizarPedido','Application\Inicio\InicioController@FinalizarPedido');
    Route::post('Desocupar','Application\Inicio\InicioController@Desocupar');
    Route::post('BuscarClienteTelefono','Application\Inicio\InicioController@BuscarClienteTelefono');
    Route::post('EscogerApc','Application\Inicio\InicioController@EscogerApc');
    Route::post('DetalleMostrador','Application\Inicio\InicioController@DetalleMostrador');
    Route::post('DetalleDelivery','Application\Inicio\InicioController@DetalleDelivery');
    Route::post('NuevoCliente','Application\Inicio\InicioController@NuevoCliente');

    
    Route::post('ListarDelivery','Application\Inicio\InicioController@ListarDelivery');
    Route::get('PedidoDelivery/{cod}', function($cod){
        session(['cod_tipe'=>3]);
        return App::call('App\Http\Controllers\Application\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });
    Route::post('RegistrarDelivery','Application\Inicio\InicioController@RegistrarDelivery');
    

    Route::post('ListarMostrador','Application\Inicio\InicioController@ListarMostrador');
    Route::get('PedidoMostrador/{cod}',  function($cod){
        session(['cod_tipe'=>2]);
        return App::call('App\Http\Controllers\Application\Inicio\InicioController@ValidarEstadoPedido', ['cod' => $cod]);
    });
    Route::post('RegistrarMostrador','Application\Inicio\InicioController@RegistrarMostrador');

});
?>
