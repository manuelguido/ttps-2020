<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// SPA
Route::get('/{any}', 'SpaController@index')->where('any', '.*');

// Ruta login 
Route::get('/login', 'SpaController@index')->name('login');
