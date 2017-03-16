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

    public function initialChunk() {
        return response()->json([
            'bills' => Bill::take(10)->get(),
            'user' => Auth::user()
        ]);
    }

    public function remainingChunk() {
        return response()->json([
            'bills' => Bill::skip(10)->take(5000)->get(),
        ]);
    }

    /**
     * @return mixed
     */
    public function mine() {
        $user = Auth::user();
        return response()->json([
            'bills' => $user->bills,
            'user' => $user
        ]);
    }
}
