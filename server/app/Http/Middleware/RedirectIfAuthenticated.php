<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

//        foreach ($guards as $guard) {
//            if (Auth::guard($guard)->check()) {
//                return redirect(RouteServiceProvider::HOME);
//            }
//        }
        $username = $request->username;
        $password = $request->password;

        $user = Auth::attempt(['username' => $username, 'password' => $password]);
        if ($user) {
            $user = Auth::user();
            //Account disable
            if ($user->trangthai == 0) {
                Auth::logout();
                Session::flush();
                return redirect()->route('user.block');
            }
        }
        return $next($request);
    }
}
