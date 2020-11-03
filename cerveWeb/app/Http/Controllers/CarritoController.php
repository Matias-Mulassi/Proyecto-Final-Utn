<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;
use App\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CervezaController;
use App\Http\Controllers\PedidoController;

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
    
    public function updateItem(Cerveza $cerveza,$cantidad = NULL)
    {
        if(isset($cantidad))
        {
            if(ctype_digit($cantidad))
            {
                if($cantidad==0)
                {
                    return redirect()->route('mostrarCarrito')->with('error','La cantidad minima a pedir es de 1 litro');
                }
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
        else
        {
            return redirect()->route('mostrarCarrito')->with('error','Ingrese una cantidad de litros a pedir.');
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
        $cervezaController = new CervezaController();
        foreach($carrito as $item){
            $total += $cervezaController->getUltimoPrecio($item->id) * $item->cantidad; 
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
            
            $pedidos = Pedido::whereDate('fecha_entrega','=',$fechaEntrega)->where('deleted_at',null)->get();
            $cervezas = Cerveza::all()->where('deleted_at',null);
            $cervezasExcedidas=array();
            foreach($cervezas as $cerveza)
            {
                ${"litros_".$cerveza->nombre}=0;
                ${"limite_".$cerveza->nombre}=$cerveza->ventaLimite;
    
                foreach($pedidos as $pedido)
                {
                         
                    foreach($pedido->itemsPedidos as $item)
                    {
                        if($item->cerveza->nombre==$cerveza->nombre)
                        {
                            ${"litros_".$cerveza->nombre}+=$item->cantidad;
                        }
            
                    }
                }
    
            }
    
    
            $c=0;
            foreach($cervezas as $cerveza)
            {
                if(${"litros_".$cerveza->nombre}==$cerveza->ventaLimite)
                {
                    $c++;
                }
            }
    
            if($c==count($cervezas))
            {
                $message='Dia de entrega completo. Escoja otra fecha para la entrega de su pedido';
                return redirect()->route('mostrarCarrito')->with('messageError',$message);
    
            }
           
            foreach($carrito as $item)
            {
                if(${"litros_".$item->nombre}+$item->cantidad>${"limite_".$item->nombre})
                {
                    $item->cantidadExcedida=${"litros_".$item->nombre}+$item->cantidad-${"limite_".$item->nombre};
                    array_push($cervezasExcedidas,$item);
                }
            }
    
    
            if(count($cervezasExcedidas)>0)
            {
                $message="Dia de entrega completo. Escoja otra fecha o modifique su pedido:";
                
                foreach($cervezasExcedidas as $cerveza)
                {
                    $message.="
Litros excedidos cerveza ".$cerveza->nombre." a sacar : ".$cerveza->cantidadExcedida." lts";
                    
                }
                return redirect()->route('mostrarCarrito')->with('messageError2',$message);
            }

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
