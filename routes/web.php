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

use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::to('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Rutas de usuarios */
Route::resource('/usuarios','UsersController');
//Route::delete('/usuarios/destroy/{id}','UsersController@destroy');

Route::get('/usuarios/destroy/{id}',[
'as' =>'usuarios.destroy',
'uses'=>'UsersController@destroy'
]);


/* Rutas de clientes */
Route::resource('/clientes','ClientesController');

/*  Rutas de productos */
/* Route::resource('/productos','ProductosController'); */


Route::get('/productos','ProductosController@index');

Route::get('/productos/{id}',[
    'as' =>'productos.update',
    'uses'=>'ProductosController@update'
    ]);

Route::get('/productos/destroy/{id}',[
    'as' =>'productos.destroy',
    'uses'=>'ProductosController@destroy'
    ]);



/* Rutas de unidad */

/* Route::resource('/unidad','UnidadController'); */

Route::get('/unidad','UnidadController@index');
Route::post('/unidad',[
    'as' =>'unidad.store',
    'uses'=>'UnidadController@store'
    ]);

Route::get('/unidad/{id}',[
    'as' =>'unidad.update',
    'uses'=>'UnidadController@update'
    ]);

Route::get('/unidad/destroy/{id}',[
    'as' =>'unidad.destroy',
    'uses'=>'UnidadController@destroy'
    ]);