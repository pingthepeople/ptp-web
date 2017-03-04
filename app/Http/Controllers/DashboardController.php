<?php

namespace App\Http\Controllers;

use App\Bill;
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
    }

    public function start() {
        $user = Auth::user();
        $bills = Bill::all();

        return view('start', compact('user', 'bills'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function myBills() {
        $user = Auth::user();
        $bills = Bill::all();

        if($user->bills->count() < 1) {
            return redirect('/start');
        } else {
            return view('default', compact('user', 'bills'));
        }
    }

    /**
     *
     */
    public function allBills() {
        $user = Auth::user();
        $bills = Bill::all();
        return view('all-bills', compact('user','bills'));
    }

    public function trackBill(Request $request, $id) {
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
