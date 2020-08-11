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
    return redirect('catalogoCervezas');
});

Route::get('/main', function () {
    return redirect('catalogoCervezas');
});



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function()
{
	switch (Auth::user()->id_tipo_usuario)
	{
			case 1:
				return redirect('catalogoCervezas');							
				break;
			
			case 2:
			    return view('Administrador.homeAdmin');
				break;
			
			case 3:
			    return view('Operador.homeOperador');
				break;		
			
	}   
 
})->name('home');


/*
|--------------------------------------------------------------------------
| Inyección de Dependencias
|--------------------------------------------------------------------------
*/

Route::bind('cerveza', function($id){
	return App\Cerveza::where('id',$id)->first();
});


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

Route::get('/mostrarCarrito','CarritoController@show' )->name('mostrarCarrito');
Route::get('/agregarItemCarrito/{cerveza}','CarritoController@addItem' )->name('agregarItemCarrito');
Route::get('/eliminarItemCarrito/{cerveza}','CarritoController@deleteItem' )->name('eliminarItemCarrito');
Route::get('/vaciarCarrito','CarritoController@trashCart' )->name('vaciarCarrito');
Route::get('/updateItemCarrito/{cerveza}/{cantidad?}', [
	'as' => 'updateItemCarrito',
	'uses' => 'CarritoController@updateItem'
]);

Route::get('/detallePedido',[
	'middleware' =>'auth',
	'as' => 'detallepedido',
	'uses' => 'CarritoController@detallePedido'
]);


//Paypal

// Enviamos nuestro pedido a PayPal

Route::get('/pago',array(
	'as' => 'pago',
	'uses' => 'PaypalController@registrarPago'
));

// Paypal redirecciona a esta ruta

Route::get('/estadoPago',array(
	'as' => 'estadoPago',
	'uses' => 'PaypalController@getEstadoPago'
));




