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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function()
{
	switch (Auth::user()->id_tipo_usuario)
	{
			case 1:
                return view('Usuario.homeUser');							
				break;
			
			case 2:
			    return view('Administrador.homeAdmin');
				break;
			
			case 3:
			    return view('Operador.homeOperador');
				break;		
			
	}   
 
})->name('home');


Route::get('/abmlUsuarios','UserController@index' )->name('abmlUsuarios');
Route::get('/altaUsuario','UserController@create' )->name('altaUsuario');
Route::post('/agregarUsuario','UserController@store' )->name('agregarUsuario');
Route::get('/editarUsuario/{id}','UserController@edit' )->name('editarUsuario');
Route::post('/updateUsuario','UserController@update' )->name('updateUsuario');
Route::get('/deleteUsuarios/{id}','UserController@logic_delete' )->name('deleteUsuarios');

Route::get('/abmlCervezas','CervezaController@index' )->name('abmlCervezas');
Route::get('/altaCerveza','CervezaController@create' )->name('agregarCerveza');
Route::post('/altaCerveza','CervezaController@store' )->name('altaCerveza');
Route::get('/editarCerveza/{id}','CervezaController@edit' )->name('editarCerveza');
Route::post('/actualizarCerveza','CervezaController@update' )->name('updateCerveza');
Route::get('/deleteCerveza/{id}','CervezaController@logic_delete' )->name('deleteCerveza');

Route::get('/catalogoCervezas','StoreController@index' )->name('catalogoCervezas');
Route::get('/detalleCerveza/{id}','StoreController@show' )->name('cerveza-detalle');



