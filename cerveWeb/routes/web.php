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
    return redirect('home');
});

Route::get('/main', function () {
    return redirect('catalogoCervezas');
});



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function()
{
	if(Auth::guest())
	{
		return redirect('catalogoCervezas');
	}
	else
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
 

	}})->name('home');
	


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
	
	
	//PORCENTAJE PRECIOS

	//Proveedores
	Route::get('/cambioprecioProveedor/{idProveedor}','CervezaProveedorController@cambioPreciosProveedor' )->name('cambioprecioProveedor');
	Route::post('/updateprecioProveedor','CervezaProveedorController@updatePreciosProveedor' )->name('updateprecioProveedor');

	//Clientes

	Route::get('/cambioprecioCervezas','CervezaController@cambioPrecios' )->name('cambioprecioCervezas');
	Route::post('/updateprecioCervezas','CervezaController@updatePrecios' )->name('updateprecioCervezas');

	//CAMBIO PRECIOS A MANO

	Route::post('/updateprecioCervezaManual/{idCerveza}','CervezaController@updatePrecioCerveza' )->name('updateprecioCervezaManual');
	

	//Administración de pedidos

	Route::get('/blPedidos','PedidoController@obtenerPedidos' )->name('blPedidos');

	Route::get('/deletePedidosAdmin/{id}','PedidoController@logic_delete2' )->name('deletePedidos2');

	//NOTIFICACIONES
	Route::get('/notificaciones/{mensaje}','MensajeController@show' )->name('notificacion');
	Route::get('/panelNotificaciones','MensajeController@showAllNotificaciones' )->name('panelNotificaciones');
	Route::get('/panelInformacion','MensajeController@showInformacion' )->name('panelInformacion');
	Route::get('/eliminarNotificacionStock/{mensaje}','MensajeController@eliminarInformacion' )->name('eliminarNotificacionStock');
	Route::get('/eliminarMensajes','MensajeController@eliminarMensajesInfo' )->name('eliminarMensajes');
	

	//INFORMES

	Route::get('/informes','InformesController@showMain' )->name('informes');
	Route::get('/informeVentas','InformesController@showVentasMenu' )->name('informeVentas');
	Route::get('/informeCompras','InformesController@showComprasMenu' )->name('informeCompras');
	Route::get('/informeGerencial','InformesController@showInformeGerencial' )->name('informeGerencial');
	
	Route::get('/informeComprasProveedor','InformesController@showComprasProveedores' )->name('informeComprasProveedor');
	Route::get('/informeComprasProveedoresSeleccionados','InformesController@showComprasProveedoresSelect' )->name('informeComprasProveedoresSeleccionados');
	Route::get('/informeComprasCervezas','InformesController@showComprasCervezas' )->name('informeComprasCervezas');
	Route::get('/informeVentasCervezasSeleccionados','InformesController@showComprasCervezasSelect' )->name('informeVentasCervezasSeleccionados');
	Route::get('/informeVentasClientes','InformesController@showVentasClientes' )->name('informeVentasClientes');
	Route::get('/informeVentasClientesSeleccionados','InformesController@showVentasClientesSelect' )->name('informeVentasClientesSeleccionados');
	Route::get('/informeVentasCervezas','InformesController@showVentasCervezas' )->name('informeVentasCervezas');
	Route::get('/informeVentasCervezasSeleccionados','InformesController@showVentasCervezasSelect' )->name('informeVentasCervezasSeleccionados');




	
	//BUSCAR CLIENTE
	Route::get('/buscarCliente','InformesController@buscarCliente' )->name('buscarCliente');

	//BUSCAR CERVEZA
	Route::get('/buscarCerveza','InformesController@buscarCerveza' )->name('buscarCerveza');
	Route::get('/buscarCompraCerveza','InformesController@buscarCompraCerveza' )->name('buscarCompraCerveza');
	

	//BUSCAR PROVEEDOR
	Route::get('/buscarCompraProveedor','CompraController@buscarCompraProveedor' )->name('buscarCompraProveedor');

	Route::get('/buscarProveedor','InformesController@buscarProveedor' )->name('buscarProveedor');

	Route::get('/confirmarAbastecimiento/{cerveza}/{proveedor}/{mensaje}','PDFController@enviarEmail' )->name('confirmarAbastecimiento');
	Route::get('/procesarAbastecimiento','PDFController@enviarVariosEmails' )->name('procesarAbastecimiento');
	
	//INFOSTOCK

	Route::get('/infoStock','CervezaController@infoStock' )->name('infoStock');
	Route::post('/updateloteOptimo/{cerveza}', [
		'as' => 'updateloteOptimo',
		'uses' => 'CervezaController@updateloteOptimo'
	]);



	//RECEPCION MERCADERIA

	Route::get('/recepcionMercaderia','CompraController@recepcionMercaderia' )->name('recepcionMercaderia');
	Route::get('/registroIngresoMercaderia/{compra}','CompraController@registroIngresoMercaderia' )->name('registroIngresoMercaderia');
	Route::get('/registroTodoIngresoMercaderia','CompraController@registroTodoIngresoMercaderia' )->name('registroTodoIngresoMercaderia');
	
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
Route::get('/informeCargaCamion','PedidoController@informeCargaCamion' )->name('informeCargaCamion');
Route::get('/hojaRuta','PedidoController@showHojaRuta' )->name('hojaRuta');
Route::get('/logisticaCamion','PedidoController@logisticaPedidos' )->name('logisticaCamion');
Route::get('/imprimirFacturas','PedidoController@imprimirFacturas' )->name('imprimirFacturas');
Route::get('/imprimirRemitos','PedidoController@imprimirRemitos' )->name('imprimirRemitos');


//CAMBIO DE CONTRASEÑAS

Route::get('/cambiarContraseña','UserController@editarContraseña' )->name('cambiarContraseña');
Route::post('/actualizarContraseña','UserController@actualizarContraseña' )->name('actualizarContraseña');



//CUENTA CORRIENTE USUARIOS

Route::get('/cuentaCorriente','CuentaCorrienteController@estadoCuenta' )->name('cuentaCorriente');
Route::get('/verFactura/{pedido}','CuentaCorrienteController@mostrarFactura' )->name('verFactura');
Route::get('/verRemito/{pedido}','CuentaCorrienteController@mostrarRemito' )->name('verRemito');

//ENVIO FACTURAS VIA MAIL
Route::get('/enviarFactura/{pedido}','PDFController@envioFactura' )->name('enviarFactura');
Route::get('/enviarFacturas','PDFController@envioFacturas' )->name('enviarFacturas');

Route::get('/mostrarFacturamail/{pedido}','PDFController@mostrarFactura' )->name('mostrarFacturamail');








