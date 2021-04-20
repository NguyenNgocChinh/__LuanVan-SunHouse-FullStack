<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function redirect(){
        return \Laravel\Socialite\Facades\Socialite ::driver('google')->redirect();
    }

    public function callback($service){
        $serviceUser  = Socialite::driver($service)->stateless()->user();
        if ( $service != 'google') {
            $email = $serviceUser->getId() . '@' . $service . '.local';
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





//        try {
//            $user = Socialite::driver('google')->stateless()->user();
//        } catch (Exception $e) {
//            return $e;
//        }
//        auth()->loginUsingId(1);
//        return response()->json($user);
//
//        $name = $user->getName();
//        $id = $user->getId();
//        $email = $user->getEmail();
//        $avatar = $user->getAvatar();
//
//        $existingUser = User::where('email', $email)->first();
//
//        if ($existingUser)
//            auth()->login($existingUser, true);
//        else {
//            $newUser = new User();
//            $newUser->name = $name;
//            $newUser->email = $email;
//            $newUser->avatar_origin = $avatar;
//            $newUser->google_id = $id;
//            $newUser->save();
//            auth()->login($newUser, true);
//
//        }

        return "LOGIN";
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
        return User::where('email', $email)->orWhereHas('social', function($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
