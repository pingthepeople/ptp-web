<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockApiController extends Controller
{
    public function findMyLegislator(Request $request) {
        return response()->json([
            'RepresentativeId' => 2,
            'SenatorId' => 1
        ]);
    }
}
