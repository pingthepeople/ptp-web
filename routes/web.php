<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/start', 'DashboardController@start');
Route::get('/', 'DashboardController@myBills');
Route::get('/bills', 'DashboardController@allBills');
    Route::post('/track', 'DashboardController@trackBill');
    Route::get('/bills/{id}', 'DashboardController@singleBill');

Route::get('/my-bills.csv', 'SpreadsheetExportController@myBillsToCsv');

Route::get('/logout', 'DashboardController@logout');
Route::get('/login', 'GuestController@guest');
Route::get('/privacy', 'GuestController@privacy');
Route::get('/support', 'GuestController@support');
Route::get('/thank-you', 'GuestController@thankyou');
Route::get('/about', 'GuestController@about');

Route::get('/account', 'AccountController@account');
Route::post('/account/save', 'AccountController@saveAccount');
Route::post('/account/find-my-legislator', 'AccountController@findMyLegislator');
if(env('APP_ENV','prod')==='local') {
    Route::post('/mocked/find-my-legislator', 'MockApiController@findMyLegislator');
}

Route::get('/login-via-facebook', 'SocialAuthController@redirect');
Route::get('/facebook-callback', 'SocialAuthController@callback');
Route::get('/login-via-google', 'SocialAuthController@googleRedirect');
Route::get('/google-callback', 'SocialAuthController@googleCallback');
if(env('APP_ENV','prod')==='local') {
    Route::get('/login-anonymously', 'SocialAuthController@anonymousRedirectAndCallback');
}


/*
 * Legacy urls
 * let's try not to break anyone's bookmarks!
 * do people still use bookmarks?
 */
Route::get('/all-bills', function() {
    return redirect('/bills');
});
