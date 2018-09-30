<?php

Route::get('upgrade', 'Application\Subscripcion\SubscriptionController@upgradeShow')->name('app.subscription.upgradeShow');
Route::post('upgrade', 'Application\Subscripcion\SubscriptionController@upgrade')->name('app.subscription.upgrade');

Route::post('checkout', 'Application\Subscripcion\SubscriptionController@checkout')->name('app.subscription.checkout');

?>