<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Legislator;
use App\Session;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

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

        if($request->input('Mobile')) {
            // phone number will contain 10 or 11 digits
            $mobile = preg_replace("/[^0-9]/", "", $request->input('Mobile'));
            if(strlen($mobile) == 10) {
                $request->merge(['Mobile'=>"+1$mobile"]);
            } else {
                $request->merge(['Mobile'=>"+$mobile"]);
            }
        }

        $user = Auth::user();
        $user->update($request->input());
        $user->save();

        return redirect('/account')->with('success-message', 'Account settings saved');
    }

    public function findMyLegislator(Request $request) {
        $this->validate($request, [
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric'
        ]);

        $client = new Client();
        $params = $request->only(['address', 'city', 'zip']);
        $params['code'] = env('FIND_LEGISLATOR_SECRET');

        try {
            $response = $client->post(env('FIND_LEGISLATOR_URL'), [
                'json' => $params
            ]);
        } catch (RequestException $e) {
            if(env('APP_ENV', 'prod')==='local') {
                dump(Psr7\str($e->getRequest()));
                if ($e->hasResponse()) {
                    dump(Psr7\str($e->getResponse()));
                }
                die();
            }
        }

        $body = $response->getBody();
        $result = json_decode($body->getContents(), true);

        if(isset($result['Representative']) && isset($result['Senator'])) {
            $user = Auth::user();
            $user->update([
                'RepresentativeId' => $result['Representative']['Id'],
                'SenatorId' => $result['Senator']['Id'],
            ]);
            $user->save();

            $messageType = 'success-message';
            $messageBody = "Your legislators have been saved";
        } else {
            $messageType = 'errors';
            $messageBody = collect(["Sorry, we couldn't find your legislators"]);
        }

        return redirect("/account")->with($messageType, $messageBody);
    }
}
