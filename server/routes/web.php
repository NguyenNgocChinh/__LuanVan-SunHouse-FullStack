<?php

use App\Http\Controllers\Admin\Admin_BaiDangController;
use App\Http\Controllers\Admin\Admin_BinhLuanController;
use App\Http\Controllers\Admin\Admin_GoiController;
use App\Http\Controllers\Admin\Admin_IndexController;
use App\Http\Controllers\Admin\Admin_LoaiController;
use App\Http\Controllers\Admin\Admin_LoginController;
use App\Http\Controllers\Admin\Admin_NguoiDungController;
use App\Http\Controllers\Admin\Admin_TienNghiController;
use App\Http\Controllers\BaiDangController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TimKiemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/ad/login', [Admin_LoginController::class, 'login'])->name('login_admin');
//--------------------------ADMIN
Route::group(['prefix' => 'ad', 'middleware' => ['admin', 'auth']], function () {
    Route::get('/', [Admin_IndexController::class, 'index'])->name('index_admin');

    Route::put('/baidang/duyet/{id}', [Admin_IndexController::class, 'duyetBai']);

    Route::resource(
        '/baidang',
        Admin_BaiDangController::class,
        ['except' => [
            'create', 'edit', 'show'
        ]]
    )->names([
        'index' => 'index_admin_baidang',
        'destroy' => 'xoa_admin_baidang',
        'update' => 'sua_admin_baidang',
        'store' => 'them_admin_baidang'
    ]);

    Route::resource('/loai', Admin_LoaiController::class)->names([
        'store' => 'them_loai',
        'destroy' => 'xoa_loai',
        'index' => 'index_admin_loai',
        'update' => 'sua_loai'
    ]);
    Route::resource(
        '/binhluan',
        Admin_BinhLuanController::class,
        ['except' => [
            'create', 'edit', 'show', 'update', 'create', 'store'
        ]]
    )->names([
        'index' => 'index_admin_binhluan',
        'destroy' => 'xoa_admin_binhluan',
    ]);
    Route::resource('/user', Admin_NguoiDungController::class)->names([
        'index' => 'index_admin_nguoidung',
        'destroy' => 'xoa_admin_nguoidung',
        'update' => 'sua_admin_nguoidung',
        'store' => 'them_admin_nguoidung'
    ]);
    Route::resource('/tiennghi', Admin_TienNghiController::class)->names([
        'index' => 'index_admin_tiennghi',
        'destroy' => 'xoa_admin_tiennghi',
        'update' => 'sua_admin_tiennghi',
        'store' => 'them_admin_tiennghi'
    ]);
    Route::resource('/goi', Admin_GoiController::class)->names([
        'index' => 'index_admin_goi',
        'destroy' => 'xoa_admin_goi',
        'update' => 'sua_admin_goi',
        'store' => 'them_admin_goi'
    ]);
});

//---------------------------END ADMIN


Route::get('/', [HomeController::class, 'index'])->name('trangchu_user');

Route::resource('/baidang', BaiDangController::class)->names([

    'store' => 'guitaisan',
    'create' => 'thembaidang',
    'show' => 'baidang_show',
    'update' => 'suataisan',
]);
Route::get('/dangkynhantin', function () {
    return view('nguoidung.dangkynhantin');
});

Route::resource('binhluan', BinhLuanController::class)->names([
    'store' => 'them_binhluan',
]);
Route::get('/search', [TimKiemController::class, 'show'])->name("timkiem_baidang");

Route::resource('binhluan', BinhLuanController::class);

Route::get('/daily', function () {
    return view('nguoidung.daily');
});
Route::get('/lienhe', function () {
    return view('nguoidung.lienhe');
});
Route::get('/hotro', function () {
    return view('nguoidung.hotro');
});

Route::get('/map', function () {
    return view('Component.MAP.map-draggable');
});
Route::get('/user-block', function () {
    return view('nguoidung.taikhoanvohieuhoa');
})->name('user.block');


Route::get('/run-migrations', function () {
    ini_set('max_execution_time', '0');
    return Artisan::call('migrate:refresh --seed');
});
