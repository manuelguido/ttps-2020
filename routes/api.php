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

// Returns the user
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Login user
Route::post('/login', 'AuthController@login');
// Logout user
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

/*--------------------------------------------------------------------------
| Social
--------------------------------------------------------------------------*/
Route::get('/authorize/google', 'SocialAuthController@redirectToProvider')->name('api.social.redirect');
Route::get('/authorize/google/callback', 'SocialAuthController@handleProviderCallback')->name('api.social.callback');
