<?php

use Cjpanilag\SimpleNotifications\Http\Controllers\FcmTokenController;
use Cjpanilag\SimpleNotifications\Http\Controllers\SimpleDeviceController;
use Cjpanilag\SimpleNotifications\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::apiResource('device', SimpleDeviceController::class)->except(['show', 'update', 'destroy']);
Route::apiResource('fcm-token', FcmTokenController::class)->except(['show', 'update', 'destroy']);

Route::prefix('test')->group(function () {
    Route::prefix('sns')->group(function () {
        Route::get('default', [TestController::class, 'snsDefault']);
        Route::get('mobile', [TestController::class, 'snsUsingMobile']);
        Route::get('content-user', [TestController::class, 'snsUsingContentWithUser']);
        Route::get('content-mobile', [TestController::class, 'snsUsingMobileContent']);
    });
    Route::prefix('mail')->group(function () {
        Route::get('default', [TestController::class, 'mailDefault']);
        Route::get('with-email', [TestController::class, 'snsUsingMail']);
        Route::get('content-user', [TestController::class, 'mailUsingContentWithUser']);
        Route::get('content-email', [TestController::class, 'mailUsingEmailContent']);
    });
    Route::prefix('fcm')->group(function () {
        Route::get('default', [TestController::class, 'fcmDefault']);
    });
});
