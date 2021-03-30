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
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(ApiLoginRequest $request)
    {
        $isEmail = filter_var($request->username, FILTER_VALIDATE_EMAIL);

        if (!Auth::attempt([ $isEmail ? "email" : "username" => $request->username, 'password' => $request->password]))

            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        return true;
    }

    public function userInfo(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return response()->json(1);
    }

    public function findUser(Request $request)
    {
        $user = User::select('id')->where('email', $request->email)->first();
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
