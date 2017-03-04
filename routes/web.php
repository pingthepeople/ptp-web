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
Route::get('/all-bills', 'DashboardController@allBills');
    Route::post('/track-bill/{Id}', 'DashboardController@trackBill');

Route::get('/logout', 'DashboardController@logout');
Route::get('/login', 'GuestController@guest');

Route::get('/login-via-facebook', 'SocialAuthController@redirect');
Route::get('/facebook-callback', 'SocialAuthController@callback');