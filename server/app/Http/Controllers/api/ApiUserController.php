<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    public function register(ApiRegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user);
    }

    public function login(ApiLoginRequest $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = User::where('username', '=', $request->username)
                ->orWhere('email', '=', $request->username)
                ->first();
            $user->token = $user->createToken('Api')->accessToken;
            return response()->json($user);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function userInfo(Request $request)
    {
        return response()->json($request->user('api'));
    }

    public function findUser(Request $request)
    {
        $user = User::select('id')->where('email', $request->email)->limit(1)->get();
        if (count($user) == 0) {
            return response()->json(false);
        }
        return response()->json(true);
    }

    public function getAllUsers()
    {
        return response()->json(UserResource::collection(User::get()->sortBy('created_at', SORT_REGULAR, true)));
    }
}
