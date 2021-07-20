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

Broadcast::channel('chat.{id}', function ($user, $id) {
    Log::info("CHAT.ID " . $user);
        //{"id":13,"username":"guest","name":"GUEST","email":"guest@gmail.com","sdt":null,"trangthai":1,"vaitro":"user","diachi":null,...
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});
//WORK... (PRIVATE CHANNEL)
Broadcast::channel('messages.{id}', function ($user, $id) {
    Log::info("private channel" . $user);
    return (int)$user->id === (int)$id;
});
// ERROR HERE (PRESENCE CHANNEL)
// POST http://localhost:8000/broadcasting/auth net::ERR_FAILED [CORS error]
Broadcast::channel('user.online', function ($user) {
    Log::info('Presence channel'.$user);
    //{"id":13,"username":"guest","name":"GUEST","email":"guest@gmail.com","sdt":null,"trangthai":1,"vaitro":"user","diachi":null,...
    // (PRESENCE CHANNEL)
    return array('name' => $user->name);
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

Broadcast::channel('chat', function ($user) {
    if (auth()->check()) {
        Log::info("chat channel");
//        Log::info(['id' => $user->id, 'name' => $user->name]);
        Log::info($user->toArray());
        return $user->toArray();
    }
//    return ['id' => $user->id, 'name' => $user->name];
//    return \App\Models\User::find($user->id);
});

Broadcast::channel('online', function ($user) {
    if (auth()->check()) {
        Log::info("online channel");
//        header("Access-Control-Allow-Origin: http://localhost:3000");
//        header("Access-Control-Allow-Credentials: true");
//        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//        header('Access-Control-Allow-Headers', 'Accept, X-Requested-With, Content-Type, X-Token-Auth, Authorization');
        return ['name' => $user->name];
    }
    return false;
});
