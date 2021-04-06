<?php

use App\Http\Controllers\api\ApiBaiDangController;
use App\Http\Controllers\api\ApiLoaiController;
use App\Http\Controllers\api\ApiTienNghiController;
use App\Http\Controllers\api\ApiUserController;
use App\Http\Controllers\api\DiaDiemController;
use App\Http\Controllers\api\HomeController;
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

Route::post('/user/find', [ApiUserController::class, "findUser"]);

Route::get('/listUser', [ApiUserController::class, "getAllUsers"]);
/*
 * BAI DANG API
 */
Route::get('/baidang', [ApiBaiDangController::class, 'getAllPosts']);
Route::get('/baidang/hot', [ApiBaiDangController::class, 'getHotPosts']);
Route::get('/baidang/raoban', [ApiBaiDangController::class, 'getRaoBanPosts']);
Route::get('/baidang/chothue', [ApiBaiDangController::class, 'getChoThuePosts']);
Route::get('/baidang/choduyet', [ApiBaiDangController::class, 'getChoDuyetPosts']);
Route::put('/baidang/duyetbai', [ApiBaiDangController::class, 'duyetBai']);
Route::get('/baidang/{id}', [ApiBaiDangController::class, 'getDetailPost'])->whereNumber('id');

Route::post('/baidang', [ApiBaiDangController::class, 'storeBaiDang']);
Route::delete('/baidang/{id}', [ApiBaiDangController::class, 'deletePost']);
Route::put('/baidang/{id}', [ApiBaiDangController::class, 'updateBaiDang']);


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
 * GIA
 */
Route::get('gia', [HomeController::class, "getGia"]);
/*
 * DIEN TICH
 */
Route::get('dientich', [HomeController::class, "getDienTich"]);

/*
 * TIM KIEM
 */
Route::get('timkiem', [\App\Http\Controllers\api\ApiTimkiemController::class, "timkiem"]);
/*
 * GOI API
 */
Route::get('goi', [\App\Http\Controllers\api\ApiGoiController::class, "getAllPackages"]);
