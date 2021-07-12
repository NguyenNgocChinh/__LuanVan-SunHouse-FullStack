<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
//WORK...
Broadcast::channel('messages.{id}', function ($user, $id) {
    return (int)$user->id === (int) $id;
});

// POST http://localhost:8000/broadcasting/auth net::ERR_FAILED [CORS error]
Broadcast::channel('user.online', function ($user) {
    \Illuminate\Support\Facades\Log::info( $user); //{"id":13,"username":"guest","name":"GUEST","email":"guest@gmail.com","sdt":null,"trangthai":1,"vaitro":"user","diachi":null,
    return ['id' => $user->id];
});
