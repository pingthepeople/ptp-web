<?php

namespace App\Http\Controllers;

use App\Legislator;
use App\Utils;
use Illuminate\Http\Request;

class LegislatorApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Utils::cache('legislators', function() {
            return Legislator::all();
        }, $request);
    }
}
