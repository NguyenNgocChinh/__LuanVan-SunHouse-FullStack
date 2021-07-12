<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Admin_LoginController extends Controller
{
    public function login()
    {
        session(['link' => '/ad']);
        return view('admin.login');
    }
}
