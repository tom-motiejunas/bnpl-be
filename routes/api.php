<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::post('/sign-up', [UserController::class, 'store'])->middleware('auth:api');
});
