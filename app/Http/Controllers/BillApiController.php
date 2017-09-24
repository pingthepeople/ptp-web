<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function bills(Request $request)
    {
        $this->validate($request, [
            'page' => 'nullable|integer',
            'q' => 'nullable|string'
        ]);

        $cacheKey = 'bills';
        $page = 0;
        $q = null;

        if($request->input('page')) {
            $page = $request->input('page');
            $cacheKey .= '--page-'.$page;
        }
        if($request->input('q')) {
            $q = $request->input('q');
            $cacheKey .= "--q-$q";
        }

        if(Cache::has($cacheKey) && 0) {
            $bills = json_decode(Cache::get($cacheKey));
        } else {
            $bills = Bill::paginate(50);
            Cache::put($cacheKey, $bills->toJson(), 600);
        }

        $pager = json_decode($bills->toJson(), true);
        $bills = $pager['data'];
        unset($pager['data']);

        return response()->json([
            'bills' => $bills,
            'pager' => $pager,
        ]);
    }

    public function all() {
        if(Cache::has('bills--all')) {
            $bills = json_decode(Cache::get('bills--all'));
        } else {
            $bills = Bill::all();
            Cache::put('bills--all', $bills->toJson(), 600);
        }

        return response()->json([
            'bills' => $bills,
        ]);
    }
}
