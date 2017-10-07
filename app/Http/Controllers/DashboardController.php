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
        $bill = Bill::where('Name', '=', $name)
                    ->firstOrFail()
                    ->makeVisible(['authors', 'coauthors', 'sponsors', 'cosponsors']);
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

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
