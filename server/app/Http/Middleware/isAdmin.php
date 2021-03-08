<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $username = $request->username;
        $password = $request->password;
        $user = Auth::check();
        if ($user) {
            $user = Auth::user();
            if ($user->vaitro == 'admin')
                return $next($request);
        }
//        abort(403, 'Unauthorized action.');
        return redirect()->route('login_admin')->withErrors('Bạn không có quyền truy cập vào hệ quản trị của website!');
    }
}
