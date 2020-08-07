<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;

class CarritoController extends Controller
{
    
    public function __construct()
    {

        if(!\Session::has('carrito')) \Session::put('carrito',array());

    }
    
    
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
     * Muestra el carrito cada vez que se realiza una operación
     * en él. Se obtiene la variable Session
     * Se modificará el carrito, agregar o quitar items y se
     * vuelve a guardar la variable Session.
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $carrito = \Session::get('carrito');
        $total = $this->getTotal();
        return view('Usuario.carrito',compact('carrito','total'));
        
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

 
    public function addItem(Cerveza $cerveza)
    {
        $carrito = \Session::get('carrito');
        $cerveza->cantidad = 1;
        $carrito[$cerveza->id] = $cerveza;
        \Session::put('carrito',$carrito);

        return redirect()->route('mostrarCarrito');
    }

    public function deleteItem(Cerveza $cerveza)
    {
        $carrito = \Session::get('carrito');
        unset($carrito[$cerveza->id]);
        \Session::put('carrito',$carrito);

        return redirect()->route('mostrarCarrito');
    }

    /**
     * updateItem funciona con javaScript hecha en public main.js.
     */
    
    public function updateItem(Cerveza $cerveza,$cantidad)
    {
        $carrito = \Session::get('carrito');
        $carrito[$cerveza->id]->cantidad=$cantidad;
        \Session::put('carrito',$carrito);

        return redirect()->route('mostrarCarrito');
    }

    public function trashCart()
    {
        \Session::forget('carrito');
        return redirect()->route('mostrarCarrito');
    }

    private function getTotal()
    {
        $carrito = \Session::get('carrito');
        $total = 0;
        foreach($carrito as $item){
            $total += $item->precio * $item->cantidad; 
        }
    
        return $total;
    
    }

}
