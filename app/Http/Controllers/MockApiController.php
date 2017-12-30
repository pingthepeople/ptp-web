<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockApiController extends Controller
{
    public function findMyLegislator(Request $request) {
        $this->validate($request, [
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required|numeric'
        ]);

        return response()->json([
            "Senator"=> [
                "Id" => 1,
                "SessionId" => 1,
                "FirstName" => "Mark",
                "LastName" => "Stoops",
                "Chamber" => "Senate",
                "District" => 40,
                "Party" => "Democratic",
                "Link" => "http://iga.in.gov/legislative/2017/legislators/legislator_mark_stoops_1107",
                "Image" => "http://iga.in.gov/legislative/2017/portraits/legislator_mark_stoops_1107"
            ],
            "Representative" => [
                "Id" => 2,
                "SessionId" => 1,
                "FirstName" => "Matt",
                "LastName" => "Pierce",
                "Chamber" => "House",
                "District" => 61,
                "Party" => "Democratic",
                "Link" => "http://iga.in.gov/legislative/2017/legislators/legislator_matthew_pierce_708",
                "Image" => "http://iga.in.gov/legislative/2017/portraits/legislator_matthew_pierce_708"
            ]
        ]);
    }
}
