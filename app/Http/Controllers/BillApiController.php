<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;

class BillApiController extends Controller
{
    public function all(Request $request)
    {
        return Bill::all();
    }
}
