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
        return $this->callbackWith('facebook');
    }

    public function googleRedirect() {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback() {
        return $this->callbackWith('google');
    }

    public function anonymousRedirectAndCallback() {
        if(env('APP_ENV', 'prod')==='local') {
            $user = User::where('AuthProviderId', 'anonymous')->first();
            if($user) {
                Auth::login($user);
                return redirect('/');
            } else {
                $newUser = User::create([
                    'Email' => 'anonymous@gmail.com',
                    'AuthProviderId' => 'anonymous',
                    'Name' => 'Dana Scully'
                ]);
                if($newUser) {
                    Auth::login($newUser);
                    return redirect('/');
                }
            }
        } else {
            return redirect('/404');
        }
    }

    private function callbackWith($driver) {
        $providerUser = Socialite::driver($driver)->user();
        $email = $providerUser->getEmail();
        $pid = $providerUser->getId();
        $id = $pid ? $driver.$pid : null;
        $status = 'Log in successful';

        // abort and redirect to the homepage if no ID is returned by the provider
        if(empty($id)) {
            return redirect('/')->with('status', 'Error getting user from authentication provider');
        }
        
        // find the user by the AuthProvider ID
        $user = User::where('AuthProviderId', $id)->first();
        
        // if no user exists for a given ID, find the user by the email if it's present
        if(!$user && !empty($email)) {  
            $user = User::where('AuthProviderEmail', $email)->first();

            // if a user was found with an email, store the provider ID
            if($user) {
                $user->AuthProviderId = $id;
                $user->save();
            }
        } 
        
        // if no user exists for an ID or email, create a new user with the ID
        if(!$user) {
            $user = User::create([
                'Email' => $email,
                'AuthProviderId' => $id,
                'Name' => $providerUser->getName(),
            ]);
            $status = 'New user created';
        }

        // if we still don't have a user, something went horribly wrong
        if(!$user) {
            return redirect('/')->with('status', 'Error while creating new user');
        }

        Auth::login($user);
        return redirect('/')->with('status', $status);
    }
}
