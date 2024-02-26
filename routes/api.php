<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\UserLoanController;
use App\Http\Controllers\UserPaymentController;
use Illuminate\Support\Facades\Route;

Route::controller(ApiAuthController::class)
    ->group(static function () {
        Route::post('/sign-up', 'signup');
        Route::post('/log-in', 'login');
        Route::post('/logout', 'logout')->middleware('auth:api');
    });

Route::controller(UserPaymentController::class)
    ->middleware('auth:api')
    ->group(static function () {
        Route::post('/add-payment', 'store');
    });

Route::controller(UserLoanController::class)
    ->middleware('auth:api')
    ->group(static function () {
        Route::post('/add-loan', 'create');
    });
