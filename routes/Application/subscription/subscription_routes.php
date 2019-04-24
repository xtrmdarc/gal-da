<?php

Route::get('upgrade', 'Application\Subscripcion\SubscriptionController@upgradeShow')->name('app.subscription.upgradeShow');
Route::post('upgrade', 'Application\Subscripcion\SubscriptionController@upgrade')->name('app.subscription.upgrade');
Route::get('upgrade/plan/{id}','Application\Subscripcion\SubscriptionController@upgrade_plan')->name('app.subscription.payment_plan');
Route::post('checkout', 'Application\Subscripcion\SubscriptionController@checkout')->name('app.subscription.checkout');
Route::post('agregar_tarjeta', 'Application\Subscripcion\SubscriptionController@agregar_tarjeta')->name('app.subscription.agregar_tarjeta');
Route::post('pagar_subscripcion', 'Application\Subscripcion\SubscriptionController@pagar_subscripcion')->name('app.subscription.pagar_subscripcion');

Route::post('ConfirmarInfoFact','Application\Subscripcion\SubscriptionController@confirmar_informacion_facturacion');
Route::get('payment_completed/{id_plan}','Application\Subscripcion\SubscriptionController@paymentCompleted');

?>