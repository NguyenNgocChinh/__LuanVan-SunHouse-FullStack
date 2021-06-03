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

Broadcast::channel('messages.{id}', function ($user, $id) {
    return (int)$user->id === (int) $id;
});
//SOON DELETE
Broadcast::channel('private-messages.{id}', function ($user, $id) {
    return (int)$user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    \Illuminate\Support\Facades\Log::info( $user);
    return $user;
});
