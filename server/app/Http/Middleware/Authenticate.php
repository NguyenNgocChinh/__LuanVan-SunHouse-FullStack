<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $url = parse_url($request->url());
        $path = $url['path'];
        $url = explode('/', $path)[1];

        if ($url == 'ad') {
            if (!$request->expectsJson()) {
                return route('login_admin');
            }
        } else {
            if (!$request->expectsJson()) {
                return route('login');
            }
        }
    }
}