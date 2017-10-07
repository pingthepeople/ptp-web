<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Legislator;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    public function account(Request $request) {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $user->load(['representative', 'senator']);
        $session = Session::current()->first();
        $legislators = Legislator::where('SessionId', '=', $session->id)->get();
        $representatives = $legislators->filter(function($l) {return $l->Chamber=='House';});
        $senators = $legislators->filter(function($l) {return $l->Chamber=='Senate';});

        return view('account', compact('user', 'representatives', 'senators'));
    }

    public function saveAccount(Request $request) {
        $this->validate($request, [
            'Email' => 'nullable|Email',
            'Mobile' => 'nullable|regex:/\+?1?[- (]?[0-9]{3}[- )]?[0-9]{3}[- ]?[0-9]{4}/',
            'DigestType' => 'digits_between:0,2',
        ]);

        $mobile = '';
        if($request->input('Mobile')) {
            // phone number will contain 10 or 11 digits
            $mobile = preg_replace("/[^0-9]/", "", $request->input('Mobile'));
            if(strlen($mobile) == 10) {
                $mobile = "+1$mobile";
            } else {
                $mobile = "+$mobile";
            }
        }

        $user = Auth::user();
        $user->update($request->input());
        $user->save();

        return redirect('/account')->with('success-message', 'Account settings saved');
    }

    public function findMyLegislator(Request $request) {
        $client = new Client();
        $params = $request->only(['address', 'city', 'zip']);
        $params['code'] = env('FIND_LEGISLATOR_SECRET');
        $result = $client->post(env('FIND_LEGISLATOR_URL'), [
            'form_params' => $params
        ]);

        dd($result);
    }
}