<?php

Route::get('upgrade', 'Application\Subscripcion\SubscriptionController@upgradeShow')->name('app.subscription.upgradeShow');
Route::post('upgrade', 'Application\Subscripcion\SubscriptionController@upgrade')->name('app.subscription.upgrade');

?>