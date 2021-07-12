<?php

namespace App\Http\Controllers;

use App\Events\UserOnline;
use App\Models\User;
use Illuminate\Http\Request;

class UserOnlineController extends Controller
{
//    public function __invoke(User $user)
//    {
//        $user->online = true;
//        $user->save();
//
//        broadcast(new UserOnline($user));
//    }

    public function userOnline($user)
    {
        $user->online = true;
        $user->save();
        broadcast(new UserOnline($user));
    }
}
