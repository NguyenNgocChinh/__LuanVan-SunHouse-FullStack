<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public $graphUrl = 'https://graph.facebook.com';
    public $version = 'v10.0';

    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function getFacebookAvatar($userID, $access_token)
    {

        $path = "{$this->graphUrl}/{$this->version}/{$userID}/picture?type=large&redirect=false&access_token={$access_token}";
        $res = Http::get($path);

        // Get the final User Image URL out of the response
        return Arr::get($res->json(), 'data.url', false);
    }

    public function callback($service, Request $request)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        if ($service != 'google') {
            $email = $serviceUser->getId() . '@' . $service . '.local';
            $image = $this->getFacebookAvatar($serviceUser->getId(), $serviceUser->token);
        } else {
            $email = $serviceUser->getEmail();
        }

        $user = $this->getExistingUser($serviceUser, $email, $service);
        $newUser = false;
        if (!$user) {
            $newUser = true;
            $user = new User();
            $user->name = $serviceUser->getName();
            $user->email = $email;
            $user->password = '';

            if ($service == 'facebook')
                $user->profile_photo_path = $image;
            else
                $user->profile_photo_path = $serviceUser->getAvatar();

            $user->save();
        }

        if ($this->needsToCreateSocial($user, $service)) {
            UserSocial::create([
                'user_id' => $user->id,
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);

        }
//        USE TOKEN
        if ($user->tokens()->get()) {
            $user->tokens()->delete();
        }
        $token = $user->createToken('tokenSocial')->plainTextToken;
        //USE COOKIE
//          $result = Auth::loginUsingId($user->id, true);
//        Auth::setUser($user);


    //    return redirect(env('CLIENT_BASE_URL'));
        return redirect(env('CLIENT_BASE_URL') . 'login/social-callback?token=' . $token . '&origin=' . ($newUser ? 'register' : 'login'));
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if (($service != 'google')) {
            $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
            return $userSocial ? $userSocial->user : null;
        }
        return User::where('email', $email)->orWhereHas('social', function ($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
