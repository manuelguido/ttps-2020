<?php

use Illuminate\Http\Request;

/**
 * API de Autenticacion
 */
// Login user
Route::post('/login', 'AuthController@login');
// Logout user
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');
// Consultar si tiene el rol correspondiente
Route::middleware('auth:api')->get('/', 'RoleController@hasRole');


/**
 * API de usuario
 */
Route::prefix('/user')->middleware('auth:api')->group(function() {

  // Obtener usuario
  Route::get('/', 'UserController@user');

  // Obtener rol de usuario
  Route::get('/role', 'UserController@role');

  // Obtener sistema del usuario
  Route::get('/system', 'UserController@system');

  // Obtener rutas del usuario
  Route::get('/routes', 'UserController@routes');

  // Obtener usuario con su rol, sus rutas(de url) y su sistema correspondiente
  Route::get('/full', 'UserController@fullUser');

  // Actualizar perfil de usuario
  Route::post('/profile/update', 'UserController@updateProfile');
});
// // Retorna el usuario
// Route::middleware('auth:api')->get('/user', 'UserController@user');
// // Retorna el rol de usuario
// Route::middleware('auth:api')->get('/user/role', 'UserController@role');
// // Retorna el sistema del usuario
// Route::middleware('auth:api')->get('/user/system', 'UserController@system');
// // Retorna las rutas del usuario
// Route::middleware('auth:api')->get('/user/routes', 'UserController@routes');
// // Retorna el usuario con el rol, sus rutas(de url) y su sistema correspondiente
// Route::middleware('auth:api')->get('/user/full', 'UserController@fullUser');
// // Actualizar el perfil de usuario
// Route::middleware('auth:api')->post('/user/profile/update', 'UserController@updateProfile');


/**
 * API de seguros médicos
 */
// Retorna todos los seguros médicos
Route::get('/medical_ensurance/index', 'MedicalEnsuranceController@index');


/**
 * API de sistemas
 */
Route::prefix('/system')->middleware('auth:api')->group(function() {

  // Retorna todos los sistemas
  Route::get('/index', 'SystemController@index');
  
  // Retorna todos los sistemas con su información de camas y habitaciones
  Route::get('/index/full', 'SystemController@indexFull');
  
  // Retorna todo un sistema con su información de camas y habitaciones
  Route::get('/full', 'SystemController@showFull');  
});


/**
 * API de estados de pacientes
 */
// Retorna todos los estados de pacientes
Route::middleware('auth:api')->get('/patient_state/index', 'PatientStateController@index');


/**
 * API pacientes
 */
Route::prefix('/patient')->middleware('auth:api')->group(function() {

  // Retorna todos los pacientes
  Route::get('/index', 'PatientController@index');

  // Retorna todos los pacientes por sistema
  Route::get('/index/{system_id}', 'PatientController@indexBySystem');

  // Retorna todos los pacientes
  Route::get('/show/{id}', 'PatientController@show');

  // Almacena un paciente
  Route::post('/store', 'PatientController@store');

  // Actualizar el perfil de usuario
  Route::post('/update', 'PatientController@update');

  // Retorna toda la información hospitalizaciones de un paciente (Tanto cambios de sistema como)
  Route::get('/hospitalizations/{patient_id}', 'PatientController@hospitalizations');

  // Cambia un paciente de sistema
  Route::post('/change_system', 'PatientController@changeSystem');

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::get('/medics/{patient_id}', 'PatientController@medics');

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/medic/add', 'PatientController@addMedic');

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/medic/remove', 'PatientController@removeMedic');
});


/**
 * API médicos
 */
Route::prefix('/medic')->group(function() {
  
  // Retorna todos los medicos
  Route::get('/index', 'MedicController@index')->middleware('auth:api', 'permission:medic_index'); // Funciona
  
  // Retorna todos los medicos por sistema
  Route::get('/index/{system_id}', 'MedicController@indexBySystem')->middleware('auth:api', 'permission:medic_index'); // Funciona
  
  // Almacena un medico
  Route::post('/store', 'MedicController@store')->middleware('auth:api', 'permission:medic_store'); // Ver
});

/**
 * API de autenticación con google
 */
// Autorización
Route::get('/authorize/google', 'SocialAuthController@redirectToProvider')->name('api.social.redirect');
// Ruta de callback
Route::get('/authorize/google/callback', 'SocialAuthController@handleProviderCallback')->name('api.social.callback');
