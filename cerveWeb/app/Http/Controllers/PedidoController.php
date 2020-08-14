<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\ItemPedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::where('id_usuario','=',Auth::user()->id)->where('deleted_at',null)->get();
        $usuario = User::find(Auth::user()->id);
        
        return view('Usuario.listadoPedidos',compact('pedidos','usuario'));

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



    public function logic_delete($id)
    {
        $pedido = Pedido::find($id);
        if($pedido && ($pedido->estado=='pendiente'))
        {
           if(isset($pedido->deleted_at))
           {
             $pedido->deleted_at = null;
           }
           else
           {
            $pedido->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $pedido->save(); 
           return back()->with('success','Pedido eliminado con éxito.');
        }
        else
        {
           return back()->with('error','El pedido que desea borrar ya se encuentra en elaboración para su entrega');
        }    
    }
}
