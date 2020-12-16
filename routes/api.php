<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API de autenticación
|--------------------------------------------------------------------------
*/
// Login user
Route::post('/login', 'AuthController@login'); // Funciona
// Logout user
Route::post('/logout', 'AuthController@logout')->middleware('auth:api'); // Funciona

/*
|--------------------------------------------------------------------------
| API de autenticación con Google
|--------------------------------------------------------------------------
*/
// Autorización
Route::get('/authorize/google', 'SocialAuthController@redirectToProvider')->name('api.social.redirect'); // Funciona
// Ruta de callback
Route::get('/authorize/google/callback', 'SocialAuthController@handleProviderCallback')->name('api.social.callback'); // Funciona

/*
|--------------------------------------------------------------------------
| API de usuario
|--------------------------------------------------------------------------
*/
Route::prefix('/user')->group(function() {

  // Obtener usuario
  Route::get('/', 'UserController@user')->middleware('auth:api'); // Funciona

  // Obtener usuario
  Route::get('/index', 'UserController@index')->middleware('auth:api', 'permission:user_index'); // Funciona

  // Obtener rol de usuario
  Route::get('/role', 'UserController@role')->middleware('auth:api'); // Funciona

  // Obtener sistema del usuario
  Route::get('/system', 'UserController@system')->middleware('auth:api'); // Funciona

  // Obtener rutas del usuario
  Route::get('/routes', 'UserController@routes')->middleware('auth:api'); // Funciona

  // Obtener usuario con su rol, sus rutas(de url) y su sistema correspondiente
  Route::get('/full', 'UserController@userData')->middleware('auth:api'); // Funciona

  // Actualizar perfil de usuario
  Route::post('/profile/update', 'UserController@updateProfile')->middleware('auth:api'); // Funciona
});

/*
|--------------------------------------------------------------------------
| API de seguros médicos
|--------------------------------------------------------------------------
*/
Route::prefix('/medical_ensurance')->middleware('auth:api')->group(function() {
  
  // Retorna todos los seguros médicos
  Route::get('index', 'MedicalEnsuranceController@index'); //Funciona
});

/*
|--------------------------------------------------------------------------
| API de sistemas
|--------------------------------------------------------------------------
*/
Route::prefix('/system')->group(function() {

  // Retorna todos los sistemas.
  Route::get('/index', 'SystemController@index')->middleware('auth:api', 'permission:system_index'); // Funciona

  // Retorna todos los sistemas habiilitados (bajo regla) para hacer el cambio de sistema.
  Route::post('/allowed/index', 'SystemController@allowedIndex')->middleware('auth:api'); // Funciona

  // Retorna todo un sistema con su información de camas y habitaciones
  Route::get('/show', 'SystemController@show')->middleware('auth:api', 'permission:system_show'); // Funciona
});

Route::prefix('/system/guard')->group(function() {

  // Retorna todos los sistemas.
  Route::post('/inite_beds/update', 'SystemController@updateInfiniteBedsOnGuard')->middleware('auth:api', 'system:Guardia', 'role:Jefe de Sistema'); // Funciona

    // Obtener si la guardia tiene la posibilidad de adminir un nuevo paciente.
    Route::post('/available', 'SystemController@guardAvailable')->middleware('auth:api'); // Funciona

});

/*
|--------------------------------------------------------------------------
| API de estados de pacientes
|--------------------------------------------------------------------------
*/
Route::prefix('/patient_state')->middleware('auth:api')->group(function() {
  
  // Retorna todos los estados de pacientes
  Route::get('index', 'PatientStateController@index'); // ?
});

/*
|--------------------------------------------------------------------------
| API de pacientes
|--------------------------------------------------------------------------
*/
Route::prefix('/patient')->group(function() {

  // Retorna todos los pacientes
  Route::get('/index', 'PatientController@index')->middleware('auth:api', 'permission:patient_index'); // Funciona

  // Retorna todos los pacientes
  Route::get('/assigned/index', 'PatientController@indexAssigned')->middleware('auth:api', 'permission:patient_index'); // Funciona

  // Retorna todos los pacientes por sistema
  Route::get('/index/{system_id}', 'PatientController@indexBySystem')->middleware('auth:api', 'permission:patient_index'); // Funciona

  // Retorna todos los pacientes
  Route::get('/show/{id}', 'PatientController@show')->middleware('auth:api', 'permission:patient_show'); // Funciona

  // Almacena un paciente
  Route::post('/store', 'PatientController@store')->middleware('auth:api', 'permission:patient_store', 'system:Guardia'); // Funciona

  // Almacena una entrada de un paciente
  Route::post('/new_entry', 'PatientController@newEntry')->middleware('auth:api', 'permission:patient_store', 'system:Guardia'); // Funciona

  // Actualizar el perfil de usuario
  Route::post('/update', 'PatientController@update')->middleware('auth:api', 'permission:patient_update'); // tiene problemas

  // Buscar paciente por DNI
  Route::post('/search', 'PatientController@searchByDni')->middleware('auth:api', 'permission:patient_show'); // Funciona

  // Retorna toda la información hospitalizaciones de un paciente
  Route::get('/clinic_data/{patient_id}', 'PatientController@clinicData')->middleware('auth:api'); // Funciona

  // Cambia un paciente de sistema
  Route::post('/system/change', 'PatientController@changeSystem')->middleware('auth:api', 'permission:patient_change_system'); // Funciona

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::get('/medics/{patient_id}', 'PatientController@medics')->middleware('auth:api', 'permission:patient_show'); // Funciona

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/medic/add', 'PatientController@addMedic')->middleware('auth:api', 'permission:patient_assign'); // Funciona

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/medic/remove', 'PatientController@removeMedic')->middleware('auth:api', 'permission:patient_assign'); // Funciona

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/declare/exit', 'PatientController@declareExit')->middleware('auth:api', 'permission:patient_update'); // Funciona

  // Retorna los medicos asignados al paciente y los posibles médicos a asignar
  Route::post('/declare/death', 'PatientController@declareDeath')->middleware('auth:api', 'permission:patient_update'); // Funciona
});

/*
|--------------------------------------------------------------------------
| API de evoluciones
|--------------------------------------------------------------------------
*/
Route::prefix('/evolution')->group(function() {

  // Almacenar una evolución
  Route::post('/store', 'EvolutionController@store')->middleware('auth:api', 'permission:patient_store'); //  Función

  // Actualizar el perfil de usuario
  Route::post('/update', 'EvolutionController@update')->middleware('auth:api', 'permission:patient_update'); // ?

  // Actualizar el perfil de usuario
  Route::get('/form_data', 'EvolutionController@formData')->middleware('auth:api'); // Funciona
});

/*
|--------------------------------------------------------------------------
| API de alertas
|--------------------------------------------------------------------------
*/
Route::prefix('/alert')->group(function() {

  // Obtener todas las notificaciones de un usuario.
  Route::get('/index', 'AlertController@index')->middleware('auth:api'); // Funciona (Aun no esta en uso)

  // Obtener todas las notificaciones de un usuario.
  Route::get('/read/index', 'AlertController@readIndex')->middleware('auth:api'); // Funciona

  // Obtener todas las notificaciones de un usuario.
  Route::get('/unread/index', 'AlertController@unreadIndex')->middleware('auth:api'); // Funciona

  // Obtener todas las notificaciones de un usuario.
  Route::get('/unread/count', 'AlertController@unreadCount')->middleware('auth:api'); // Funciona

  // Marcar noficación como leída.
  Route::post('/read', 'AlertController@read')->middleware('auth:api'); // Funciona

});

/*
|--------------------------------------------------------------------------
| API de médicos
|--------------------------------------------------------------------------
*/
Route::prefix('/medic')->group(function() {
  
  // Retorna todos los medicos
  Route::get('/index', 'MedicController@index')->middleware('auth:api', 'permission:medic_index'); // ?
  
  // Retorna todos los pacientes
  Route::get('/assigned/index', 'MedicController@indexAssigned')->middleware('auth:api', 'permission:medic_index'); // Funciona

  // Retorna todos los medicos por sistema
  Route::get('/index/{system_id}', 'MedicController@indexBySystem')->middleware('auth:api', 'permission:medic_index'); // Funciona
  
  // Almacena un medico
  Route::post('/store', 'MedicController@store')->middleware('auth:api', 'permission:medic_store'); // Tiene problemas
});

/*
|--------------------------------------------------------------------------
| API de seguros médicos
|--------------------------------------------------------------------------
*/
Route::prefix('/settings')->middleware('auth:api', 'role:Administrador')->group(function() {
  
  // Actualizar parametros de alertas.
  Route::get('/show', 'SettingsController@show'); //Funciona

  // Actualizar parametros de alertas.
  Route::post('/update', 'SettingsController@update'); //Funciona
});



Route::prefix('/settings/rules')->middleware('auth:api', 'permission:rule_crud', 'role:Configurador de Reglas')->group(function() {
  
  // Obtener parametros de alertas.
  Route::get('/show', 'RulesSettingsController@show'); //Funciona

  // Actualizar parametros de alertas.
  Route::post('/update', 'RulesSettingsController@update'); //Funciona
});

