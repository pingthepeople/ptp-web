<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingApiController extends Controller
{
    public function track(Request $request) {
        $user = Auth::user();

        // accept 'bill', 'bills', or 'id', parameter
        $bills =
            $request->input('bill')
                ? $request->input('bill')
                : ($request->input('bills')
                    ? $request->input('bills')
                    : $request->input('id'));

        if(!$bills || !$user) {
            // whatever, go away
            return null;
        }

        return $user->track($bills);
    }

    public function stopTracking(Request $request) {
        $user = Auth::user();

        // accept 'bill', 'bills', or 'id', parameter
        $bills =
            $request->input('bill')
                ? $request->input('bill')
                : ($request->input('bills')
                ? $request->input('bills')
                : $request->input('id'));

        if(!$bills || !$user) {
            // whatever, go away
            return null;
        }

        return $user->track($bills, false);
    }
}
