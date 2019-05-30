<?php
Route::get('/stock', 'Application\Inventario\Stock\StockController@index')->name('inventario.stock');
Route::post('stockDatos', 'Application\Inventario\Stock\StockController@datos')->name('inventario.stock.datos');

?>