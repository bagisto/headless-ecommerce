<?php

use Illuminate\Support\Facades\Route;
use Webkul\GraphQLAPI\Http\Controllers\Admin\NotificationController;

/**
 * FCM Notification routes.
 */
Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::prefix('api_notification')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->defaults('_config', [
            'view' => 'bagisto_graphql::admin.push_notification.index'
            ])->name('admin.push_notification.index');

        Route::get('/create', [NotificationController::class, 'create'])->defaults('_config', [
            'view' => 'bagisto_graphql::admin.push_notification.create'
        ])->name('admin.push_notification.create');

        Route::post('/store', [NotificationController::class, 'store'])->defaults('_config', [
            'redirect' => 'admin.push_notification.index'
        ])->name('admin.push_notification.store');

        Route::get('/edit/{id}', [NotificationController::class, 'edit'])->defaults('_config', [
            'view' => 'bagisto_graphql::admin.push_notification.edit'
        ])->name('admin.push_notification.edit');

        Route::put('/edit/{id}', [NotificationController::class, 'update'])->defaults('_config', [
            'redirect' => 'admin.push_notification.index'
        ])->name('admin.push_notification.update');

        Route::post('/delete/{id}', [NotificationController::class, 'delete'])->defaults('_config', [
            'redirect' => 'admin.push_notification.index'
        ])->name('admin.push_notification.delete');

        Route::post('/massdelete', [NotificationController::class, 'massDestroy'])->defaults('_config', [
            'redirect' => 'admin.push_notification.index'
        ])->name('admin.push_notification.mass-delete');

        Route::post('/massupdate', [NotificationController::class, 'massUpdate'])->defaults('_config', [
            'redirect' => 'admin.push_notification.index'
        ])->name('admin.push_notification.mass-update');

        Route::get('/send/{id}', [NotificationController::class, 'sendNotification'])->name('admin.push_notification.send-notification');

        Route::post('/exist', [NotificationController::class, 'exist'])->name('admin.push_notification.cat-product-id');
    });
});
