<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

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

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int)$user->id === (int)$id;
//});

//WORK... (PRIVATE CHANNEL)
Broadcast::channel('messages.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
//WORK... (PRESENCE  CHANNEL)
Broadcast::channel('user.online', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

