<?php

namespace App\Http\Responses;

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        //dd(session('link'));
        if (session('link') != null) {
            return redirect(session('link'));
        }

//        setcookie("TestCookie", $value, time()+3600, "/", "example.com");
        return redirect(RouteServiceProvider::HOME);
    }
}
