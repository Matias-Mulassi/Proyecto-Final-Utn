<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\ItemPedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registrarPedido($fechaEntrega)
    {
        $total = 0;
		$carrito = \Session::get('carrito');
 
		foreach($carrito as $cerveza){
			$total += $cerveza->cantidad * $cerveza->precio;
		}
 
        $pedido = new Pedido();
        $pedido->fecha_entrega= $fechaEntrega;
        $pedido->total=$total;
        $pedido->id_usuario=\Auth::user()->id;
        $pedido->save();

		foreach($carrito as $cerveza){
			$this->registrarItemPedido($cerveza, $pedido->id);
        }
        
        \Session::forget('carrito');
        return \Redirect::route('catalogoCervezas')
				->with('message', 'Pedido realizado de forma exitosa, Gracias por su Compra!');
    }

    protected function registrarItemPedido($cerveza, $pedido_id)
	{
        $item_pedido = new ItemPedido();
        $item_pedido->cantidad= $cerveza->cantidad;
        $item_pedido->id_cerveza=$cerveza->id;
        $item_pedido->id_pedido=$pedido_id;
        $item_pedido->save();
	}

}
