<?php

use App\Http\Controllers\api\ApiBaiDangController;
use App\Http\Controllers\api\ApiLoaiController;
use App\Http\Controllers\api\ApiTienNghiController;
use App\Http\Controllers\api\ApiUserController;
use App\Http\Controllers\api\DiaDiemController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ApiGoiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('HomeApi', HomeController::class);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * AUTH
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [ApiUserController::class, "register"]);
    Route::post('/login', [ApiUserController::class, "login"]);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [ApiUserController::class, "logout"]);
        Route::get('/user', [ApiUserController::class, "userInfo"]);
    });
});
/*
 * USER API
 */
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [ApiUserController::class, "getAllUsers"]);
    Route::get('/{id}', [ApiUserController::class, "findUser"])->whereNumber('id');
    Route::get('/count', [ApiUserController::class, "countUser"]);
    Route::put('/disable/{id}', [ApiUserController::class, "disableUser"])->whereNumber('id');
    Route::put('/enable/{id}', [ApiUserController::class, "enableUser"])->whereNumber('id');
});

/*
 * BAI DANG API
 */
Route::group(['prefix' => 'baidang'], function () {
    Route::get('/', [ApiBaiDangController::class, 'getAllPosts']);
    Route::post('/', [ApiBaiDangController::class, 'storeBaiDang']);
    Route::get('/count', [ApiBaiDangController::class, 'countPosts']);
    Route::delete('/{id}', [ApiBaiDangController::class, 'deletePost'])->whereNumber('id');
    Route::post('/edit/{id}', [ApiBaiDangController::class, 'updateBaiDang'])->whereNumber('id');

    Route::get('/hot', [ApiBaiDangController::class, 'getHotPosts']);
    Route::get('/raoban', [ApiBaiDangController::class, 'getRaoBanPosts']);
    Route::get('/chothue', [ApiBaiDangController::class, 'getChoThuePosts']);
    Route::get('/choduyet', [ApiBaiDangController::class, 'getChoDuyetPosts']);
    Route::get('/choduyet/count', [ApiBaiDangController::class, 'countChoDuyetPosts']);
    Route::put('/duyetbai', [ApiBaiDangController::class, 'duyetBai']);
    Route::get('/{id}', [ApiBaiDangController::class, 'getDetailPost'])->whereNumber('id');

    Route::put('/updateDuyetBai', [ApiBaiDangController::class, 'updateDuyetBai']);
    Route::put('/updateTrangThai', [ApiBaiDangController::class, 'updateTrangThai']);

});

/*
 * LOAI API
 */
Route::get('/loai', [ApiLoaiController::class, 'getAllLoai']);
/*
 * TIEN NGHI API
 */
Route::get('/tiennghi', [ApiTienNghiController::class, 'getAllTienNghi']);
/*
 * LOCATION API
 */
Route::get('ThanhPho', [DiaDiemController::class, "thanhpho"]);

Route::get('QuanHuyen/{id_thanhpho}', [DiaDiemController::class, "quanhuyen"])
    ->whereNumber("id_thanhpho");

Route::get('XaPhuong/{id_quanhuyen}', [DiaDiemController::class, "xaphuong"])
    ->whereNumber("id_quanhuyen");

/*
 * TIM KIEM
 */
Route::get('timkiem', [\App\Http\Controllers\api\ApiTimkiemController::class, "timkiem"]);
/*
 * GOI API
 */
Route::group(['prefix' => 'goi'], function () {
    Route::get('/', [ApiGoiController::class, "getAllPackages"]);
    Route::post('/', [ApiGoiController::class, "storePackage"]);
    Route::get('/count', [ApiGoiController::class, "countPackages"]);
    Route::get('/{id}', [ApiGoiController::class, "getPackage"])->whereNumber('id');
    Route::put('/{id}', [ApiGoiController::class, "updatePackage"])->whereNumber('id');
    Route::delete('/{id}', [ApiGoiController::class, "deletePackage"])->whereNumber('id');
});

/*
 * GIA
 */
Route::get('gia', [HomeController::class, "getGia"]);
/*
 * DIEN TICH
 */
Route::get('dientich', [HomeController::class, "getDienTich"]);

