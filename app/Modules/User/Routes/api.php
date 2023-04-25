<?php

use Illuminate\Support\Facades\Route;

Route::name('api.users.')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
    });

    Route::post('login', \App\Modules\User\Http\Controllers\UserLoginController::class)->name('login');
    Route::post('register', \App\Modules\User\Http\Controllers\UserRegistrationController::class)->name('register');
});
