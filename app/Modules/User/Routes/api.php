<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function() {

});

Route::post('login', \App\Modules\User\Http\Controllers\UserLoginController::class);
