<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\Cerveza;
use App\ItemPedido;
use Carbon\Carbon;
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

    public function obtenerPedidos()
    {
        $pedidos = Pedido::where('deleted_at',null)->get();
        return view('Administrador.blPedidos',compact('pedidos'));
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
        
		$carrito = \Session::get('carrito');
 
        $pedido = new Pedido();
        $pedido->fecha_entrega= $fechaEntrega;
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

    public function logic_delete2($id)
    {
        $ped = Pedido::find($id);
        if($ped)
        {
           if(isset($ped->deleted_at))
           {
             $ped->deleted_at = null;
           }
           else
           {
            $ped->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $ped->save(); 
           return back()->with('success','Pedido eliminado con éxito.');
        }
        else
        {
           return back()->with('error','Pedido no encontrado.');
        }    
    }

    public function getPedidosEntregaHoy()
    {
        $nombreDia=Carbon::now()->format('l');
        $nombreDia=$this->traducirDia($nombreDia);
        
        $fechaActual=Carbon::now()->format('d-m-Y');
        $pedidos = Pedido::where('fecha_entrega','=',Carbon::now()->format('Y-m-d'))->where('deleted_at',null)->where('estado','pendiente')->orderBy('id', 'ASC')->get();
        return view('Operador.listadoPedidosEntregaHoy',compact('pedidos','fechaActual','nombreDia'));

    }

    static function traducirDia($nombreDia)
    {
        switch ($nombreDia)
	{
			case "Monday":
                return "Lunes";
                break;
			case "Tuesday":
                return "Martes";
                break;
            
            case "Wednesday":
                return "Miércoles";
                break;

            case "Thursday":
                return "Jueves";
                break;
            
            case "Friday":
                return "Viernes";
                break;

            case "Saturday":
                return "Sábado";
                break;

            case "Sunday":
                return "Domingo";
                break;
			
	}   

    }

    public function controlStock($idPedido)
    {
        $fechaActual= Carbon::now()->format('d-m-Y');
        $fechaPago= Carbon::now()->addDays(15)->format('d-m-Y');
        $pedido = Pedido::find($idPedido);
        if(isset($pedido))
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cantidad<=$item->cerveza->cantidadStock)
                {
                    if($item->cerveza->cantidadStock>$item->cerveza->puntoPedido)
                    {
                        $cerveza = Cerveza::find($item->cerveza->id);
                        if(isset($cerveza))
                        { 
                            $cerveza->cantidadStock = $cerveza->cantidadStock - $item->cantidad;
                            $cerveza->update();
                        }
                        else{
                            return redirect('listadoPedidosEntregaHoy')->with('error','Se ha producido un error al procesar el pedido');
                        }
                    }
                    else
                    {
                        //Ver como disparar proceso de compra
                    }
                }
                else
                {
                    return redirect('listadoPedidosEntregaHoy')->with('error','No hay stock para procesar este pedido');
                }
                
            }
            
            switch ($pedido->usuario->condicionIVA)
            {
                case "Responsable Inscripto":
                    return view('Operador.generaciónFacturaElectronicaA',compact('pedido','fechaActual','fechaPago'));
                    break;
                case "Monotributista":
                    return view('Operador.generaciónFacturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;
                
                case "Exento":
                    return view('Operador.generaciónFacturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;

                case "Consumidor Final":
                    return view('Operador.generaciónFacturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;
            }   
            
        }
        else
        {
            return redirect('listadoPedidosEntregaHoy')->with('error','Se ha producido un error al procesar el pedido');
        }
        
    }

}
