<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{service}',[SocialLoginController::class, 'redirect']);


\Illuminate\Support\Facades\Broadcast::routes(['middleware' => ['auth:sanctum'] ]);

/*
 * AUTH
 */
Route::post('/register', [\App\Http\Controllers\api\ApiUserController::class, "register"]);
Route::post('/login', [\App\Http\Controllers\api\ApiUserController::class, "login"]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [\App\Http\Controllers\api\ApiUserController::class, "logout"]);
    Route::get('/user', [\App\Http\Controllers\api\ApiUserController::class, "userInfo"]);
});

Route::get('/{service}/callback', [SocialLoginController::class, 'callback']);
