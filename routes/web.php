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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');
 
Auth::routes();

//Route::get('/materiales', 'MaterialController@index');
Route::get('/materiales', function () {
    return view('modules/materiales');
});
Route::post('/materiales/agregar', 'MaterialController@store');
Route::post('/materiales/actualizar', 'MaterialController@update');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
