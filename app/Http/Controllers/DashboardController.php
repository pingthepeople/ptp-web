<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Legislator;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        if(env('APP_ENV') == 'local') {
            $this->middleware(\Clockwork\Support\Laravel\ClockworkMiddleware::class);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function myBills() {
        $user = Auth::user();
        if($user->bills->count() == 0) {
            return redirect('/bills?welcome=true');
        }

        return view('my-watch-list', compact('user'));
    }

    /**
     *
     */
    public function allBills(Request $request) {
        $user = Auth::user();
        $showWelcome = $request->get('welcome');
        return view('all-bills', compact('user', 'showWelcome'));
    }

    public function singleBill($name) {
        $session = Session::current();
        $bill = $session->bills->where('Name', '=', $name)->first();
        if(!$bill) {
            abort(404);
        }
        $bill->makeVisible(['authors', 'coauthors', 'sponsors', 'cosponsors']);
        $bill = $bill->toArray();

        if(Auth::check()) {
            $user = Auth::user();
            $bill['isTracked'] = $user->trackedBills->map(function($pivot) {return $pivot->BillId;})->contains($bill['Id']);
        } else {
            $user = null;
        }

        return view('single-bill', compact(['user', 'bill']));
    }

    public function trackBill(Request $request) {
        $id = $request->input('id', 0);

        $bill = Bill::findOrFail($id);
        $user = Auth::user();

        if(!$user->bills->pluck('Id')->contains($bill->Id)) {
            $user->bills()->attach($bill->Id);
        } else {
            $user->bills()->detach($bill->Id);
        }
        $user->save();

        return back();
    }

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
                'Name' => 'required',
                'Email' => 'nullable|Email',
                'DigestType' => 'digits_between:0,2',
                'Mobile' => 'nullable|regex:/\+?1?[- (]?[0-9]{3}[- )]?[0-9]{3}[- ]?[0-9]{4}/'
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
        $user->Name = $request->input('Name');
        $user->Email = $request->input('Email');
        $user->Mobile = $mobile;
        $user->DigestType = $request->input('DigestType');
        $user->RepresentativeId = $request->input('representative') ? $request->input('representative') : null;
        $user->SenatorId = $request->input('senator') ? $request->input('senator') : null;
        $user->save();
        return redirect('/account')->with('success-message', 'Account settings saved');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
