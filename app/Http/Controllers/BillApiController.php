<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BillApiController
 * @package App\Http\Controllers
 */
class BillApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(Request $request)
    {
        return response()->json([
            'bills' => Bill::all(),
            'user' => Auth::user()
        ]);
    }

    /**
     * @return mixed
     */
    public function mine() {
        $user = Auth::user();
        $user->load([
            'bills',
            'bills.subjects',
            'bills.actions',
            'bills.scheduledActions']);
        return response()->json([
            'bills' => $user->bills,
            'user' => $user
        ]);
    }
}
