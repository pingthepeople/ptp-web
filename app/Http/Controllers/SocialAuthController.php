<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $email = $facebookUser->getEmail();

        if(User::where('Email', $email)->exists()) {
            $user = User::where('Email', $email)->first();
            //Auth::login($user);
            Auth::loginUsingId(1);
            return redirect('/')->with('status', 'Login successful');
        } else {
            $newUser = User::create([
                'Email' => $email,
                'Name' => $facebookUser->getName(),
            ]);
            if($newUser) {
                Auth::login($newUser);
                return redirect('/')->with('status', 'New user created');
            }
        }
    }
}
