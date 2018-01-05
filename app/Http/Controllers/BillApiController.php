<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

/**
 * Class BillApiController
 * @package App\Http\Controllers
 */
class BillApiController extends Controller
{
    public function __construct()
    {
        if(env('APP_ENV') == 'local') {
            $this->middleware(\Clockwork\Support\Laravel\ClockworkMiddleware::class);
        }
    }

    public function all(Request $request) {
        if(Cache::has('bills') && Cache::has('bills__etag')) {
            $bills = json_decode(Cache::get('bills'));
            $etag = Cache::get('bills__etag');
        } else {
            if($request->method() == 'HEAD') {
                $bills = [];
                $etag = 'expired';
            } else {
                $session = Session::current();
                $bills = $session->bills->sortBy('Name')->values()->all();
                $billsJson = json_encode($bills);
                $etag = md5($billsJson);
                Cache::forever('bills', $billsJson);
                Cache::forever('bills__etag', $etag);
            }
        }

        return response()->json([
            'bills' => $bills
        ])->setEtag($etag);
    }

    public function details(Request $request) {
        $this->validate($request, [
            'ids' => 'required'
        ]);

        $ids = explode(',', $request->input('ids'));

        $bills = Bill::with(['actions', 'scheduledActions'])->find($ids);

        return response()->json([
            'bills' => $bills
        ]);
    }
}
