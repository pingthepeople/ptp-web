<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guest()
    {
        return view('guest');
    }

    public function support()
    {
        return view ('support');
    }

    public function thankyou()
    {
        return view('thankyou');
    }

    public function about()
    {
        return view('about');
    }
}
