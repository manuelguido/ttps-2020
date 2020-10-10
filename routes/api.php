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

/*--------------------------------------------------------------------------
| API de usuario
--------------------------------------------------------------------------*/
// Retorna el usuario
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Retorna todos los pacientes
Route::middleware('auth:api')->get('/user/routes', 'UserController@routes');

/*--------------------------------------------------------------------------
| Autenticacion
--------------------------------------------------------------------------*/
// Login user
Route::post('/login', 'AuthController@login');
// Logout user
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

/*--------------------------------------------------------------------------
| API de seguros médicos
--------------------------------------------------------------------------*/
// Retorna todos los seguros médicos
Route::middleware('auth:api')->get('/medical_ensurance/index', 'MedicalEnsuranceController@index');


/*--------------------------------------------------------------------------
| API Pacientes
--------------------------------------------------------------------------*/
// Retorna todos los pacientes
Route::get('/patient/index', 'PatientController@index');
// Almacena un paciente
Route::middleware('auth:api')->post('/patient/store', 'PatientController@store');






/*--------------------------------------------------------------------------
| Social auth
--------------------------------------------------------------------------*/
Route::get('/authorize/google', 'SocialAuthController@redirectToProvider')->name('api.social.redirect');
Route::get('/authorize/google/callback', 'SocialAuthController@handleProviderCallback')->name('api.social.callback');
