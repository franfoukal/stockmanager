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


//Rutas para materiales
Route::get('/materiales', function(){
    return view('modules/materiales');
});
Route::get('/materiales/listar', 'MaterialController@index');
Route::post('/materiales/agregar', 'MaterialController@store');
Route::post('/materiales/actualizar', 'MaterialController@update');
Route::delete('/materiales/eliminar/{id}', 'MaterialController@destroy');

//Rutas para calendario
Route::get('/calendario', function () {
    return view('modules/calendario');
});

//Rutas para cconsumo
Route::get('/consumo', function () {
    return view('modules/consumos');
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
