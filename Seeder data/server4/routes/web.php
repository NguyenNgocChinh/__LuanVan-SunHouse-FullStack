<?php

use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\api\ApiBaiDangController;
use App\Http\Controllers\api\ApiLoaiController;
use App\Http\Controllers\api\ApiTienNghiController;
use App\Http\Controllers\api\ApiTimkiemController;
use App\Http\Controllers\api\ApiUserController;
use App\Http\Controllers\api\DiaDiemController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\UserOnlineController;
use \App\Http\Controllers\ThongTinDangKyController;
use App\Mail\MailRegistered;
use App\Models\BaiDang;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
 * Broadcast
 */
Route::put('users/{user}/online', [UserOnlineController::class, 'userOnline'])->middleware('auth:sanctum');
Broadcast::routes(['middleware' => ['auth:sanctum'] ]);
/*
 * AUTH
 */
Route::post('/register', [ApiUserController::class, "register"]);
Route::post('/login', [ApiUserController::class, "login"]);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [ApiUserController::class, "logout"]);
    Route::get('/user', [ApiUserController::class, "userInfo"]);
});
/*
 * SERVICES (GG-FB)
 */
Route::get('/auth/{service}',[SocialLoginController::class, 'redirect']);
Route::get('/auth/{service}/callback', [SocialLoginController::class, 'callback']);
/*
 * USER
 */
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [ApiUserController::class, "getAllUsers"]);
    Route::get('/{id}', [ApiUserController::class, "findUser"])->whereNumber('id');
    Route::get('/count', [ApiUserController::class, "countUser"]);
    Route::put('/disable/{id}', [ApiUserController::class, "disableUser"])->whereNumber('id');
    Route::put('/enable/{id}', [ApiUserController::class, "enableUser"])->whereNumber('id');
    Route::post('/update', [ApiUserController::class, "updateInfomationUser"])->middleware('auth:sanctum');
    Route::put('/updatepass', [ApiUserController::class, "updatePassword"])->middleware('auth:sanctum');

    Route::get('/dangkynhantin', [ThongTinDangKyController::class, "show"])->middleware('auth:sanctum');
    Route::post('/dangkynhantin', [ThongTinDangKyController::class, "store"])->middleware('auth:sanctum');
    Route::put('/dangkynhantin/{id}', [ThongTinDangKyController::class, "update"])->middleware('auth:sanctum')->whereNumber('id');
    Route::delete('/dangkynhantin/{id}', [ThongTinDangKyController::class, "delete"])->middleware('auth:sanctum')->whereNumber('id');
});

/*
 * BAI DANG
 */
Route::group(['prefix' => 'baidang'], function () {
    Route::get('/', [ApiBaiDangController::class, 'getAllPosts']);
    Route::post('/', [ApiBaiDangController::class, 'storeBaiDang'])->middleware('auth:sanctum');
    Route::get('/{id}', [ApiBaiDangController::class, 'getDetailPost'])->whereNumber('id');
    Route::get('/count', [ApiBaiDangController::class, 'countPosts']);
    Route::delete('/{id}', [ApiBaiDangController::class, 'deletePost'])->whereNumber('id');
    Route::post('/edit/{id}', [ApiBaiDangController::class, 'updateBaiDang'])->whereNumber('id');

    Route::get('/hot', [ApiBaiDangController::class, 'getHotPosts']);
    Route::get('/raoban', [ApiBaiDangController::class, 'getRaoBanPosts']);
    Route::get('/chothue', [ApiBaiDangController::class, 'getChoThuePosts']);
    Route::get('/choduyet', [ApiBaiDangController::class, 'getChoDuyetPosts']);
    Route::get('/choduyet/count', [ApiBaiDangController::class, 'countChoDuyetPosts']);
    Route::put('/duyetbai', [ApiBaiDangController::class, 'duyetBai'])->middleware('auth:sanctum');

    Route::put('/updateDuyetBai', [ApiBaiDangController::class, 'updateDuyetBai']);
    Route::put('/updateTrangThai', [ApiBaiDangController::class, 'updateTrangThai']);

    Route::get('/getUserPost', [ApiBaiDangController::class, 'getAllBaiDangOfUser'])->middleware('auth:sanctum');

});

/*
 * LOAI
 */
Route::get('/loai', [ApiLoaiController::class, 'getAllLoai']);
/*
 * TIEN NGHI
 */
Route::get('/tiennghi', [ApiTienNghiController::class, 'getAllTienNghi']);
/*
 * LOCATION
 */
Route::get('ThanhPho', [DiaDiemController::class, "thanhpho"]);

Route::get('QuanHuyen/{id_thanhpho}', [DiaDiemController::class, "quanhuyen"])
    ->whereNumber("id_thanhpho");

Route::get('XaPhuong/{id_quanhuyen}', [DiaDiemController::class, "xaphuong"])
    ->whereNumber("id_quanhuyen");
/*
 * TIM KIEM
 */
Route::get('timkiem', [ApiTimkiemController::class, "timkiem"]);
/*
 * GIA
 */
Route::get('gia', [HomeController::class, "getGia"]);
/*
 * DIEN TICH
 */
Route::get('dientich', [HomeController::class, "getDienTich"]);
/*
 * CHAT
 */
Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::get('/contacts', [ContactController::class, 'get' ]);
    Route::get('/messages', [ContactController::class, 'getAllMessage' ]);
    Route::get('/conversation/{id}', [ContactController::class, 'getMessagesFor']);
    Route::post('/conversation/send', [ContactController::class,'send']);
});

//MAIL
Route::get('/send-mail', function () {
    $user = User::find(11);
    Mail::to('chinhnguyen.210399@gmail.com')->send(new MailRegistered($user));

    return 'A message has been sent!';

});
Route::get('/test-mail', function (){
    return view('mails.matchTinDang', ['name' => 'Chinh', 'baidang' => BaiDang::find(10)]);
});

Route::get('/test', function (){
    DB::enableQueryLog(); // Enable query log
    $toadoX = '14.637517864181';
    $toadoY = '108.66037951208';
//    dd(DB::select(DB::raw("")));
//    ST_GeomFromText('point($toadoX $toadoY)',4326)
   $distance = DB::select( DB::raw("
        SELECT st_distance_sphere((SELECT HEX(ST_GeomFromText('point($toadoX $toadoY)',4326)) ),(SELECT position FROM location WHERE id=5)) as distance
    ") );

// Your Eloquent query executed by using get()

    dd(DB::getQueryLog()); // Show results of log
    dd($distance);
});
