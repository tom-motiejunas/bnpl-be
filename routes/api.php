<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['json.response'], 'namespace' => 'Api'], static function () {
    Route::post('/log-in', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/sign-up', [ApiAuthController::class, 'signup'])->name('signup.api');
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api')->middleware('auth:api');
});
