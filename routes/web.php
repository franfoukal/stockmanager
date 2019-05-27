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
    return view('modules/container')->with('component', 'materiales');
})->middleware(['auth', 'auth.admin:admin, user,employee']);
Route::get('/materiales/listar', 'MaterialController@index');
Route::post('/materiales/agregar', 'MaterialController@store');
Route::post('/materiales/actualizar', 'MaterialController@update');
Route::delete('/materiales/eliminar/{id}', 'MaterialController@destroy');

//Rutas para calendario
Route::get('/calendario', function () {
    return view( 'modules/container')->with('component', 'full-calendar');
});

//Rutas para consumo
Route::get('/consumo', function () {
    return view('modules/container')->with('component', 'consumos');
});
Route::get('/consumo/listar', 'ConsumoController@index');
Route::post('/consumo/agregar', 'ConsumoController@store');
Route::post('/consumo/actualizar', 'ConsumoController@update');
Route::delete('/consumo/eliminar/{id}', 'ConsumoController@destroy');

//Rutas para contratistas
Route::get('/contratistas', function () {
    return view( 'modules/container')->with('component', 'contratistas');
});
Route::get('/contratistas/listar', 'ContratistaController@index');
Route::post('/contratistas/agregar', 'ContratistaController@store');
Route::post('/contratistas/actualizar', 'ContratistaController@update');
Route::delete('/contratistas/eliminar/{id}', 'ContratistaController@destroy');

//Rutas para usuarios
Route::get('/user', function () {
    return view('modules/container')->with('component', 'usuarios');
});
Route::get('/user/list', 'UserController@index');
Route::get('/user/roles', 'UserController@getRoles');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
