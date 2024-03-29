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
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\UserOnlineController;
use \App\Http\Controllers\ThongTinDangKyController;
use App\Http\Controllers\YeuThichController;
use App\Mail\MailRegistered;
use App\Models\BaiDang;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
 * Broadcast
 */
Broadcast::routes(["middleware" => "auth:sanctum"]);
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
Route::get('/auth/{service}', [SocialLoginController::class, 'redirect']);

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
    Route::put('/updateNumberPhone', [ApiUserController::class, "updateNumberPhone"])->middleware('auth:sanctum');
    Route::post('/sendMailResetPassword', [ApiUserController::class, "sendMailResetPassword"]);
    Route::get('/checkTokenExpired', [ApiUserController::class, "checkTokenExpired"]);
    Route::post('/resetPassword', [ApiUserController::class, "resetPassword"]);
    Route::put('/updatepass', [ApiUserController::class, "updatePassword"])->middleware('auth:sanctum');

    Route::get('/dangkynhantin', [ThongTinDangKyController::class, "show"])->middleware('auth:sanctum');
    Route::post('/dangkynhantin', [ThongTinDangKyController::class, "store"])->middleware('auth:sanctum');
    Route::put('/dangkynhantin/{id}', [ThongTinDangKyController::class, "update"])->middleware('auth:sanctum')->whereNumber('id');
    Route::delete('/dangkynhantin/{id}', [ThongTinDangKyController::class, "delete"])->middleware('auth:sanctum')->whereNumber('id');

    Route::get('/checkIsValidNumberPhone/{numberphone}', [ApiUserController::class, "checkIsValidNumberPhone"]);
    Route::get('/checkIsValidEmail/{email}', [ApiUserController::class, "checkIsValidEmail"]);
    Route::get('/checkIsValidUsername/{username}', [ApiUserController::class, "checkIsValidUsername"]);
    Route::get('/checkIsValidUsernameForUpdate/{username}', [ApiUserController::class, "checkIsValidUsernameForUpdate"])->middleware('auth:sanctum');

    Route::put('/toggleVaiTro', [ApiUserController::class, "toggleVaiTro"]);
});

/*
     * BAI DANG
     */
Route::group(['prefix' => 'baidang'], function () {
    Route::get('/', [ApiBaiDangController::class, 'getAllPosts']);
    Route::post('/', [ApiBaiDangController::class, 'storeBaiDang'])->middleware(['auth:sanctum', 'throttle:dangbai']);
    Route::get('/{id}', [ApiBaiDangController::class, 'getDetailPost'])->whereNumber('id')->middleware('filterView');
    Route::get('/count', [ApiBaiDangController::class, 'countPosts']);
    Route::delete('/{id}', [ApiBaiDangController::class, 'deletePost'])->whereNumber('id');
    Route::post('/edit/{id}', [ApiBaiDangController::class, 'updateBaiDang'])->whereNumber('id');

    Route::get('/hot', [ApiBaiDangController::class, 'getHotPosts']);
    Route::get('/raoban', [ApiBaiDangController::class, 'getRaoBanPosts']);
    Route::get('/chothue', [ApiBaiDangController::class, 'getChoThuePosts']);
    Route::get('/choduyet', [ApiBaiDangController::class, 'getChoDuyetPosts']);
    Route::get('/choduyet/count', [ApiBaiDangController::class, 'countChoDuyetPosts']);
    Route::put('/duyetbai', [ApiBaiDangController::class, 'duyetBai'])->middleware('auth:sanctum');
    Route::get('/deletePosts', [ApiBaiDangController::class, 'deletePosts'])->middleware('auth:sanctum');
    Route::delete('/forceDeleteAllPost', [ApiBaiDangController::class, 'forceDeleteAllPost'])->middleware('auth:sanctum');
    Route::put('/restorePost/{id}', [ApiBaiDangController::class, 'restorePost'])->middleware('auth:sanctum')->whereNumber('id');
    Route::delete('/forceDeletePost/{id}', [ApiBaiDangController::class, 'forceDeletePost'])->middleware('auth:sanctum')->whereNumber('id');

    Route::put('/updateDuyetBai', [ApiBaiDangController::class, 'updateDuyetBai']);
    Route::put('/updateTrangThai', [ApiBaiDangController::class, 'updateTrangThai']);

    Route::get('/getUserPost', [ApiBaiDangController::class, 'getAllBaiDangOfUser'])->middleware('auth:sanctum');
    Route::get('/getAllBaiDangOfOtherUser/{idUser}', [ApiBaiDangController::class, 'getAllBaiDangOfOtherUser'])->whereNumber('idUser');
    Route::get('/getUserWaitingPost', [ApiBaiDangController::class, 'getWaitingBaiDangOfUser'])->middleware('auth:sanctum');
    Route::put('/pushDoUuTien/{idBaiDang}', [ApiBaiDangController::class, 'pushDoUuTien'])->whereNumber('idBaiDang');
    Route::get('/checkScopePosts', [ApiBaiDangController::class, 'checkScopePosts'])->middleware('auth:sanctum');
});

/*
     * LOAI
     */
Route::get('/loai', [ApiLoaiController::class, 'getAllLoai']);
Route::put('/loai', [ApiLoaiController::class, 'editLoai']);
Route::post('/loai', [ApiLoaiController::class, 'addLoai']);
Route::delete('/loai/{id}', [ApiLoaiController::class, 'deleteLoai'])->whereNumber('id');
/*
     * TIEN NGHI
     */
Route::get('/tiennghi', [ApiTienNghiController::class, 'getAllTienNghi']);
Route::put('/tiennghi', [ApiTienNghiController::class, 'editTienNghi']);
Route::post('/tiennghi', [ApiTienNghiController::class, 'addTienNghi']);
Route::delete('/tiennghi/{id}', [ApiTienNghiController::class, 'deleteTienNghi'])->whereNumber('id');
/*
     * LOCATION
     */
Route::get('ThanhPho', [DiaDiemController::class, "thanhpho"]);

Route::get('QuanHuyen/{id_thanhpho}', [DiaDiemController::class, "quanhuyen"])
    ->whereNumber("id_thanhpho");

Route::get('XaPhuong/{id_quanhuyen}', [DiaDiemController::class, "xaphuong"])
    ->whereNumber("id_quanhuyen");

Route::get('Duong/{id_xaphuong}', [DiaDiemController::class, "duong"])
    ->whereNumber("id_xaphuong");

Route::post('/Duong', [DiaDiemController::class, "addDuong"]);

/*
     * TIM KIEM
     */
Route::get('timkiem', [ApiTimkiemController::class, "timkiem"]);
/*
     * YEU THICH
     */
Route::get('/yeuthich', [YeuThichController::class, "getYeuThichOfUser"])->middleware('auth:sanctum');
Route::post('/addYeuThich', [YeuThichController::class, "addYeuThich"])->middleware('auth:sanctum');
Route::post('/removeYeuThich', [YeuThichController::class, "removeYeuThich"])->middleware('auth:sanctum');
/*
     * GIA
     */
Route::get('gia', [HomeController::class, "getGia"]);
/*
     * BAO CAO
     */
Route::get('/getBaoCaoForUser', [BaoCaoController::class, "getBaiDangBaoCaoForUser"])->middleware('auth:sanctum');
Route::post('/baocao', [BaoCaoController::class, "storeBaoCao"])->middleware(['auth:sanctum']); //'throttle:1:60']
Route::delete('/baocao', [BaoCaoController::class, "deleteBaoCao"])->middleware('auth:sanctum');
Route::put('/baocao', [BaoCaoController::class, "editBaoCao"])->middleware('auth:sanctum');
Route::get('/thongkebaocao', [BaoCaoController::class, "getBaoCaoWithUser"]);
/*
     * DANH GIA
     */
    Route::group(['prefix' => 'danhgia',  'middleware' => 'auth:sanctum'], function()
    {
    // Route::prefix('danhgia')->middleware(['auth:sanctum'])->group(['prefix' => 'baidang'],function () {
    Route::get('/', [DanhGiaController::class, 'getAllDanhGia']);
    Route::post('/', [DanhGiaController::class, 'danhGiaUser']);
    Route::put('/', [DanhGiaController::class, 'editDanhGia']);
    Route::delete('/{idDanhGia}', [DanhGiaController::class, 'removeDanhGia']);
    Route::get('/getDanhGiaForUser', [DanhGiaController::class, 'getDanhGiaForUser']);
});

/*
     * DIEN TICH
     */
Route::get('dientich', [HomeController::class, "getDienTich"]);
/*
     * CHAT
     */
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/contacts', [ContactController::class, 'get']);
    Route::get('/messages', [ContactController::class, 'getAllMessage']);
    Route::get('/conversation/{id}', [ContactController::class, 'getMessagesFor']);
    Route::post('/conversation/send', [ContactController::class, 'send']);
});

//MAIL
Route::get('/send-mail', function () {
    $user = User::find(11);
    Mail::to('chinhnguyen.210399@gmail.com')->send(new MailRegistered($user));

    return 'A message has been sent!';
});
Route::get('/test-mail', function () {
    return view('mails.matchTinDang', ['name' => 'Chinh', 'baidang' => BaiDang::find(10)]);
});
Route::get('/test-search', function () {
    return BaiDang::search('Biệt Thự')->with('loai')->get();;
});

Route::get('/test', function () {
    DB::enableQueryLog();
    $toadoX = '14.637517864181';
    $toadoY = '108.66037951208';
    $R = 1;

    for ($R; $R <= 10; $R++) {
        $begin = microtime(true);
        $distance = DB::select("
            select count(*) as distance from location
            WHERE ST_Distance_Sphere((position), (ST_GeomFromText('point($toadoY $toadoX)',4326)))
            <= $R * 1609.344 and trangthai = 1");
        \Illuminate\Support\Facades\Log::info(DB::getQueryLog());
        $end = round(microtime(true) - $begin, 2);
        echo "Trong bán kính <b style='color: blue'>" . $R . "km</b> tìm thấy <b style='color: red'>" . $distance[0]->distance . "</b> tin đăng trong thời gian: <b>" . $end . "</b> s";
        echo "<br />";
    }
});

Route::get('/testView', function () {
    $begin = microtime(true);
    $result = DB::select("
        SELECT * FROM view_location
    ");
    $end = round(microtime(true) - $begin, 2);
    echo "Kết quả từ view là: <b>" . $result[0]->sl . "</b> record. Với thời gian là: " . $end . "s";
});
