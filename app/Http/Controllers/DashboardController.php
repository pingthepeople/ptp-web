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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function main() {
        $user = Auth::user();

        // TODO only pull bills for the current Session
        $bills = Bill::all();

        return view('default', compact('user', 'bills'));
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

        if(!$user->bills->contains($bill->Id)) {
            $user->bills()->attach($bill->Id);
            $user->save();
        }

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
