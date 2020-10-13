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
				if(isset(Auth::user()->deleted_at))
				{
					return view('Usuario.noHabilitado');
					break;
				}
				else
				{
				return redirect('catalogoCervezas');
				break;
				}
				
				
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

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/abmlUsuarios','UserController@index' )->name('abmlUsuarios');
	Route::post('/altaUsuario','UserController@store' )->name('altaUsuario');
	Route::get('/agregarUsuario','UserController@create' )->name('agregarUsuario');
	Route::get('/editarUsuario/{id}','UserController@edit' )->name('editarUsuario');
	Route::post('/updateUsuario','UserController@update' )->name('updateUsuario');
	Route::get('/deleteUsuarios/{id}','UserController@logic_delete' )->name('deleteUsuarios');

	Route::get('/abmlTiposUsuarios','TipoUsuarioController@index')->name('abmlTiposUsuarios');
	Route::get('/altaTiposUsuarios','TipoUsuarioController@create' )->name('agregarTiposUsuarios');
	Route::post('/altaTiposUsuarios','TipoUsuarioController@store' )->name('altaTiposUsuarios');
	Route::get('/editarTiposUsuarios/{id}','TipoUsuarioController@edit' )->name('editarTiposUsuarios');
	Route::post('/actualizarTipoUsuario','TipoUsuarioController@update' )->name('updateTiposUsuarios');
	Route::get('/abmlTiposUsuarios/{id}','TipoUsuarioController@logic_delete' )->name('deleteTiposUsuarios');

	Route::get('/abmlCervezas','CervezaController@index' )->name('abmlCervezas');
	Route::get('/agregarCerveza','CervezaController@create' )->name('agregarCerveza');
	Route::post('/altaCerveza','CervezaController@store' )->name('altaCerveza');
	Route::get('/editarCerveza/{id}','CervezaController@edit' )->name('editarCerveza');
	Route::post('/actualizarCerveza','CervezaController@update' )->name('updateCerveza');
	Route::get('/deleteCerveza/{id}','CervezaController@logic_delete' )->name('deleteCerveza');

	Route::get('/abmlCategorias','CategoriaController@index' )->name('abmlCategorias');
	Route::get('/agregarCategoria','CategoriaController@create' )->name('agregarCategoria');
	Route::post('/altaCategoria','CategoriaController@store' )->name('altaCategoria');
	Route::get('/editarCategoria/{id}','CategoriaController@edit' )->name('editarCategoria');
	Route::post('/actualizarCategoria','CategoriaController@update' )->name('updateCategoria');
	Route::get('/deleteCategoria/{id}','CategoriaController@logic_delete' )->name('deleteCategoria');

	Route::get('/abmlProveedores','ProveedorController@index' )->name('abmlProveedores');
	Route::get('/agregarProveedor','ProveedorController@create' )->name('agregarProveedor');
	Route::post('/altaProveedor','ProveedorController@store' )->name('altaProveedor');
	Route::get('/editarProveedor/{id}','ProveedorController@edit' )->name('editarProveedor');
	Route::post('/actualizarProveedor','ProveedorController@update' )->name('updateProveedor');
	Route::get('/deleteProveedor/{id}','ProveedorController@logic_delete' )->name('deleteProveedor');
	
	Route::get('/asignarCerveza/{id}','ProveedorController@asignarCerveza' )->name('asignarCerveza');
	Route::get('/abmlCervezasProveedores/{id}','CervezaProveedorController@index' )->name('abmlCervezasProveedores');
	Route::post('/registroCervezasProveedor','CervezaProveedorController@store' )->name('registroCervezaProveedor');
	Route::get('/editarCervezaProveedor/{idProveedor}/{idCerveza}','CervezaProveedorController@edit' )->name('editarCervezaProveedor');
	Route::post('/updateCervezaProveedor','CervezaProveedorController@update' )->name('updateCervezaProveedor');
	Route::get('/deleteCervezaProveedor/{idProveedor}/{idCerveza}','CervezaProveedorController@destroy' )->name('deleteCervezaProveedor');
	
	

	//Administración de pedidos

	Route::get('/blPedidos','PedidoController@obtenerPedidos' )->name('blPedidos');

	Route::get('/deletePedidosAdmin/{id}','PedidoController@logic_delete2' )->name('deletePedidos2');

	//NOTIFICACIONES
	Route::get('/notificaciones/{mensaje}','MensajeController@show' )->name('notificacion');
	Route::get('/panelNotificaciones','MensajeController@showAllNotificaciones' )->name('panelNotificaciones');
	Route::get('/confirmarAbastecimiento/{cerveza}/{proveedor}/{mensaje}','PDFController@enviarEmail' )->name('confirmarAbastecimiento');
	Route::get('/procesarAbastecimiento','PDFController@enviarVariosEmails' )->name('procesarAbastecimiento');
	
	

});




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

Route::post('/detallePedido',[
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

//Registrar un pedido sin pagar

Route::get('/registroSinPago/{fechaEntrega}',[
	'middleware' =>'prioridad',
	'as' => 'registroSinPago',
	'uses' => 'PedidoController@registrarPedido'
]);

//Route::get('/registroSinPago/{fechaEntrega}','PedidoController@registrarPedido' )->name('registroSinPago');

//Lista de Pedidos de un Usuario
Route::get('/listadoPedidos','PedidoController@index')->name('listadoPedidos');
Route::get('/deletePedidos/{id}','PedidoController@logic_delete' )->name('deletePedidos');

// Usuario sin permiso no habilitado.

Route::get('/noHabilitado', ['as' => 'noHablitado', function() {
    return view('Usuario.noHabilitado');
}]);





// OPERADOR //

Route::get('/listadoPedidosEntrega','PedidoController@getPedidosProxEntrega' )->name('listadoPedidosEntrega');
Route::get('/procesarTodosPedidos','PedidoController@procesarTodosPedidos' )->name('procesarTodosPedidos');
Route::get('/controlStock/{id}','PedidoController@controlStock' )->name('controlStock');

Route::get('/expedicionPedido/{id}','PedidoController@expedicionPedido' )->name('expedicionPedido');
Route::get('/expedicionCamion','PedidoController@getPedidosExpedicion' )->name('expedicionCamion');
Route::get('/mostrarFactura/{id}','PedidoController@mostrarFactura' )->name('mostrarFactura');
Route::get('/mostrarRemito/{id}','PedidoController@mostrarRemito' )->name('mostrarRemito');
Route::get('/estadoCamion','PedidoController@mostrarCamion' )->name('mostrarCamion');
Route::get('/logisticaCamion','PedidoController@logisticaPedidos' )->name('logisticaCamion');

