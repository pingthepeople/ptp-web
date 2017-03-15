<?php

namespace App\Http\Controllers;

use App\Bill;
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

        return response()->json($user->track($bills));
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

        return response()->json($user->track($bills, false));
    }

    public function toggleEmailSubscription(Request $request, $id) {
        $user = Auth::user();
        $isSubscribed = $user->bills()->find($id)->pivot->ReceiveAlertEmail;
        $user->bills()->updateExistingPivot($id, ['ReceiveAlertEmail'=>!$isSubscribed]);
    }

    public function toggleSmsSubscription(Request $request, $id) {
        $user = Auth::user();
        $isSubscribed = $user->bills()->find($id)->pivot->ReceiveAlertSms;
        $user->bills()->updateExistingPivot($id, ['ReceiveAlertSms'=>!$isSubscribed]);
    }
}
