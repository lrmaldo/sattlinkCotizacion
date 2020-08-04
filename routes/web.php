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

Route::get('cliente/exportExcel',[
    'as' =>'clientes.exportExcel',
    'uses'=>'ClientesController@exportExcel'
    ]);

Route::post('cliente/importExcel','ClientesController@importExcel');

/*  Rutas de productos */
/* Route::resource('/productos','ProductosController'); */


Route::get('/productos','ProductosController@index');
Route::get('/productos/create',[
    'as' =>'productos.create',
    'uses'=>'ProductosController@create'
    ]);
    Route::post('/productos/store',[
        'as' =>'productos.store',
        'uses'=>'ProductosController@store'
        ]);

Route::get('/productos/{id}',[
    'as' =>'productos.update',
    'uses'=>'ProductosController@update'
    ]);

Route::get('/productos/destroy/{id}',[
    'as' =>'productos.destroy',
    'uses'=>'ProductosController@destroy'
    ]);

 
    Route::get('producto/exportExcel',[
        'as' =>'productos.exportExcel',
        'uses'=>'ProductosController@exportExcel'
        ]);


        Route::post('producto/importExcel','ProductosController@importExcel');
    
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

    /* ruta de datos fiscales */
Route::get('/datos','DatosfiscalesController@index');
Route::post('/datos',[
    'as' =>'datos.store',
    'uses'=>'DatosfiscalesController@store'
    ]);

Route::get('/datos/{id}',[
    'as' =>'datos.update',
    'uses'=>'DatosfiscalesController@update'
    ]);

Route::get('/datos/destroy/{id}',[
    'as' =>'datos.destroy',
    'uses'=>'DatosfiscalesController@destroy'
    ]);

Route::get('/impuesto/{id}',[
        'as' =>'datos.impuesto',
        'uses'=>'DatosfiscalesController@impuesto'
        ]);
/* Routes de cotizador */

Route::resource('cotizador','CotizacionController');

