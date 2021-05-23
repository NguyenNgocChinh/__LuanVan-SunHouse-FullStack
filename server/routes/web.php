<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{service}',[SocialLoginController::class, 'redirect']);

