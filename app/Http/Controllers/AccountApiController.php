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
class AccountApiController extends Controller
{
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
        $user->Name = $request->input('Name');
        $user->Email = $request->input('Email');
        $user->Mobile = $mobile;
        $user->DigestType = $request->input('DigestType');
        $user->RepresentativeId = $request->input('representative') ? $request->input('representative') : null;
        $user->SenatorId = $request->input('senator') ? $request->input('senator') : null;
        $user->save();

        if($request->ajax()) {
            return $user->toJson();
        } else {
            return redirect('/account')->with('success-message', 'Account settings saved');
        }
    }


}