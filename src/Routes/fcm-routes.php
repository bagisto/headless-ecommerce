<?php

use Illuminate\Support\Facades\Route;
use Webkul\GraphQLAPI\Http\Controllers\Admin\NotificationController;

/**
 * FCM Notification routes.
 */
Route::group([
    'middleware' => ['web', 'admin'],
    'prefix'     => config('app.admin_url').'/settings/push-notifications',
], function () {
    Route::controller(NotificationController::class)->group(function () {
        Route::get('', 'index')->name('admin.settings.push_notification.index');

        Route::get('create', 'create')->name('admin.settings.push_notification.create');

        Route::post('store', 'store')->name('admin.settings.push_notification.store');

        Route::get('edit/{id}', 'edit')->name('admin.settings.push_notification.edit');

        Route::put('edit/{id}', 'update')->name('admin.settings.push_notification.update');

        Route::post('delete/{id}', 'destroy')->name('admin.settings.push_notification.delete');

        Route::post('massdelete', 'massDestroy')->name('admin.settings.push_notification.mass_delete');

        Route::post('massupdate', 'massUpdate')->name('admin.settings.push_notification.mass_update');

        Route::get('send/{id}', 'sendNotification')->name('admin.settings.push_notification.send_notification');

        Route::post('exist', 'exist')->name('admin.settings.push_notification.cat-product-id');
    });
});
