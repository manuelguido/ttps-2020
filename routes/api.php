<?php

use Illuminate\Http\Request;

/**
 * API de usuario
 * 
 */
// Retorna el usuario
Route::middleware('auth:api')->get('/user', 'UserController@user');
// Retorna el rol de usuario
Route::middleware('auth:api')->get('/user/role', 'UserController@role');
// Retorna el sistema del usuario
Route::middleware('auth:api')->get('/user/system', 'UserController@system');
// Retorna las rutas del usuario
Route::middleware('auth:api')->get('/user/routes', 'UserController@routes');
// Retorna el usuario con el rol, sus rutas(de url) y su sistema correspondiente
Route::middleware('auth:api')->get('/user/full', 'UserController@fullUser');
// Actualizar el perfil de usuario
Route::middleware('auth:api')->post('/user/profile/update', 'UserController@updateProfile');


/**
 * API de Autenticacion
 * 
 */
// Login user
Route::post('/login', 'AuthController@login');
// Logout user
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
// Consultar si tiene el rol correspondiente
Route::middleware('auth:api')->get('/', 'RoleController@hasRole');


/**
 * API de seguros médicos
 * 
 */
// Retorna todos los seguros médicos
Route::get('/medical_ensurance/index', 'MedicalEnsuranceController@index');


/**
 * API de sistemas
 * 
 */
// Retorna todos los sistemas
Route::middleware('auth:api')->get('/system/index', 'SystemController@index');
// Retorna todos los sistemas con su información de camas y habitaciones
Route::middleware('auth:api')->get('/system/index/full', 'SystemController@indexFull');
// Retorna todo un sistema con su información de camas y habitaciones
Route::middleware('auth:api')->get('/system/full', 'SystemController@showFull');


/**
 * API de estados de pacientes
 * 
 */
// Retorna todos los estados de pacientes
Route::middleware('auth:api')->get('/patient_state/index', 'PatientStateController@index');


/**
 * API pacientes
 * 
 */
// Retorna todos los pacientes
Route::middleware('auth:api')->get('/patient/index', 'PatientController@index');
// Retorna todos los pacientes por sistema
Route::middleware('auth:api')->get('/patient/index/{system_id}', 'PatientController@indexBySystem');
// Retorna todos los pacientes
Route::middleware('auth:api')->get('/patient/show/{id}', 'PatientController@show');
// Almacena un paciente
Route::middleware('auth:api')->post('/patient/store', 'PatientController@store');
// Retorna toda la información hospitalizaciones de un paciente (Tanto cambios de sistema como)
Route::get('/patient/hospitalizations/{patient_id}', 'PatientController@hospitalizations');
// Cambia un paciente de sistema
Route::middleware('auth:api')->post('/patient/change_system', 'PatientController@changeSystem');
// Retorna los medicos asignados al paciente y los posibles médicos a asignar
Route::middleware('auth:api')->get('/patient/medics/{patient_id}', 'PatientController@medics');
// Retorna los medicos asignados al paciente y los posibles médicos a asignar
Route::middleware('auth:api')->post('/patient/medic/add', 'PatientController@addMedic');
// Retorna los medicos asignados al paciente y los posibles médicos a asignar
Route::middleware('auth:api')->post('/patient/medic/remove', 'PatientController@removeMedic');


/**
 * API médicos
 * 
 */
// Retorna todos los medicos
Route::middleware('auth:api')->get('/medic/index', 'UserController@indexMedic');
// Retorna todos los medicos por sistema
Route::middleware('auth:api')->get('/medic/index/{system_id}', 'UserController@indexMedicBySystem');
// Almacena un medico
Route::middleware('auth:api')->post('/medic/store', 'UserController@storeMedic');


/**
 * API de autenticación con google
 */
// Autorización
Route::get('/authorize/google', 'SocialAuthController@redirectToProvider')->name('api.social.redirect');
// Ruta de callback
Route::get('/authorize/google/callback', 'SocialAuthController@handleProviderCallback')->name('api.social.callback');
