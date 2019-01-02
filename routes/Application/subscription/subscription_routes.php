<?php

Route::get('upgrade', 'Application\Subscripcion\SubscriptionController@upgradeShow')->name('app.subscription.upgradeShow');
Route::post('upgrade', 'Application\Subscripcion\SubscriptionController@upgrade')->name('app.subscription.upgrade');
Route::get('upgrade/plan/{id}','Application\Subscripcion\SubscriptionController@upgrade_plan')->name('app.subscription.payment_plan');
Route::post('checkout', 'Application\Subscripcion\SubscriptionController@checkout')->name('app.subscription.checkout');

?>