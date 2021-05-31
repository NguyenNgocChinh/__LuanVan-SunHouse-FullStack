<?php

use App\Http\Controllers\api\ApiBaiDangController;
use App\Http\Controllers\api\ApiLoaiController;
use App\Http\Controllers\api\ApiTienNghiController;
use App\Http\Controllers\api\ApiTimkiemController;
use App\Http\Controllers\api\ApiUserController;
use App\Http\Controllers\api\DiaDiemController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ApiGoiController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Laravel\Socialite\Facades\Socialite;


//
//Route::apiResource('HomeApi', HomeController::class);



/*
 * GOI
 */
//Route::group(['prefix' => 'goi'], function () {
//    Route::get('/', [ApiGoiController::class, "getAllPackages"]);
//    Route::post('/', [ApiGoiController::class, "storePackage"]);
//    Route::get('/count', [ApiGoiController::class, "countPackages"]);
//    Route::get('/{id}', [ApiGoiController::class, "getPackage"])->whereNumber('id');
//    Route::put('/{id}', [ApiGoiController::class, "updatePackage"])->whereNumber('id');
//    Route::delete('/{id}', [ApiGoiController::class, "deletePackage"])->whereNumber('id');
//});



//
//Route::get('messages', [\App\Http\Controllers\api\ChatsController::class , 'fetchMessages']);
//Route::post('messages', [\App\Http\Controllers\api\ChatsController::class, 'sendMessage']);




