<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bills', 'BillApiController@all');
Route::post('/track', 'TrackingApiController@track');
Route::post('/stop-tracking', 'TrackingApiController@stopTracking');

/*
 * /bills
 * /bills/{id}
 * /track
 * /stop-tracking
 * /subjects
 */