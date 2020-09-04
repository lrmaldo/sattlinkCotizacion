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
Route::post('/tipocambio','HomeController@tipocambio');

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

//Route::resource('cotizador','CotizacionController');
Route::get('cotizador','CotizacionController@index');

Route::get('cotizador/create',[
    'as'=>'cotizador.create',
    'uses'=> 'CotizacionController@create']);

Route::post('cotizador/add',[
    'as'=>'cotizador.add',
    'uses'=>'CotizacionController@add'
]);
/* agregar producto syscom */
Route::post('cotizador/add_syscom',[
    'as'=>'cotizador.add_syscom',
    'uses'=>'CotizacionController@add_syscom'
]);


Route::post('cotizador/add_cliente',[
'as'=>'cotizador.add',
'uses'=>'CotizacionController@add_cliente'
]);

Route::post('/cotizador/destroy_tmp',[
'as' =>'cotizador.destroy_tmp',
'uses'=>'CotizacionController@destroy_tmp'
]);
Route::post('/cotizador/destroy_tmp_syscom',[
'as' =>'cotizador.destroy_tmp_syscom',
'uses'=>'CotizacionController@destroy_tmp_syscom'
]);

Route::post('/cotizador/email_pdf/{id}',[
    'as' =>'cotizador.email_pdf',
    'uses'=>'CotizacionController@email_pdf'
    ]);

    /* destroy_tmp_syscom */
/* Route::get('/cotizador/generar',[
    'as'=>'cotizador.generar',
    'uses'=>'CotizacionController@guardarCoti'  
]); */

Route::get('cotizador/generar','CotizacionController@guardarCoti');

/* cargar datos productos internos y syscom cotizados */
Route::get('cotizador/cargardatos','CotizacionController@cargardatos');

//buscador de productos en la BD con un input
Route::get('cotizador/autocomplete',[
    'as'=>'cotizador.autocomplete',
    'uses'=>'CotizacionController@autocompleteProducto'
]);


//generador de pdf con id de cotizacion
Route::get('/pdf/{id}','CotizacionController@generadorPdf');