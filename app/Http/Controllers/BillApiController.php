<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Session;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return Utils::cache('bills', function() {
            $session = Session::current();
            return $session->bills->sortBy('Name')->values()->all();
        }, $request);
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
