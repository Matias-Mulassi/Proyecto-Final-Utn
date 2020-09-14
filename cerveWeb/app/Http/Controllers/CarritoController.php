<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if(ctype_digit($cantidad))
        {
            if($cantidad<=60)
            {
                $carrito = \Session::get('carrito');
                $carrito[$cerveza->id]->cantidad=$cantidad;
                \Session::put('carrito',$carrito);
                return redirect()->route('mostrarCarrito');
            }
            else
            {
                return redirect()->route('mostrarCarrito')->with('error','La cantidad en litros no puede ser mayor a 60.');
            }
        }
        else
        {
            return redirect()->route('mostrarCarrito')->with('error','La cantidad en litros debe ser entera y positiva.'); 
        }
        
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



    public function detallePedido(Request $request)
    {
        if(isset(Auth::user()->deleted_at)){
            return view('Usuario.noHabilitado');
        }
        else
        {
            if(count(\Session::get('carrito'))<=0) return \Redirect::route('catalogoCervezas')
            ->with('messageError', 'Carrito de compra Vacio!, añada cervezas');
            $current_date = Carbon::now()->modify('+1 day')->format('Y-m-d');

            $rules = [
                
                'fechaPedido' => ['required','date','after_or_equal:'.$current_date],            
            ];   

            $messages = [
                    'fechaPedido.required'=>'Ingrese fecha de entrega Pedido.',
                    'fechaPedido.after_or_equal'=>'La fecha de Entrega del pedido debe ser mayor o igual a la fecha actual y un dia de agregado como minimo para la preparación del pedido',
                ];


            $validacion = $this->validate($request,$rules,$messages);

            if($validacion)
            {
            $fechaEntrega = Carbon::parse($request['fechaPedido'])->format('Y-m-d');
            $carrito = \Session::get('carrito');
            $total = $this->getTotal();

            return view('Usuario.detallePedido',compact('carrito','total','fechaEntrega'));
            }
            else
            {
            return redirect('mostrarCarrito')->with('error','Error.No se ha podido registrar pedido.');
            } 
        }
        

    }
}
