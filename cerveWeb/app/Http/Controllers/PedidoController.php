<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use App\User;
use App\Pedido;
use App\Cerveza;
use App\ItemPedido;
use Carbon\Carbon;
use App\Mensaje;
use App\Proveedor;
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
        if(($fechaEntrega == Carbon::now()->modify('+1 day')->format('Y-m-d')) & (Carbon::now()->format('H:i:s')>='20:00:00' | ($this->getLitrosCamion(Pedido::where('fecha_entrega','=',Carbon::now()->modify('+1 day')->format('Y-m-d'))->where('deleted_at',null)->where('estado','en expedicion')->orderBy('id', 'ASC')->get())==1500))  )
        {
            $pedido->fecha_entrega= Carbon::parse($fechaEntrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
        }
        else
        {
            $pedido->fecha_entrega= Carbon::parse($fechaEntrega)->hour(10)->minute(00)->second(00)->format('Y-m-d H:i:s');
        }
        
        $pedido->id_usuario=\Auth::user()->id;
        $pedido->pagado=false;
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

    public function getPedidosProxEntrega()
    {
        $nombreDia=Carbon::now()->modify('+1 day')->format('l');
        $nombreDia=$this->traducirDia($nombreDia);
        
        $fechaMañana=Carbon::now()->modify('+1 day')->format('d-m-Y');
        $pedidos = Pedido::whereDate('fecha_entrega','=',Carbon::now()->modify('+1 day')->format('Y-m-d'))->where('deleted_at',null)->where('estado','pendiente')->orderBy('fecha_entrega', 'ASC')->orderBy('id', 'ASC')->get();

        if(Carbon::now()->format('H:i:s')>='20:00:00' | ($this->getLitrosCamion(Pedido::where('fecha_entrega','=',Carbon::now()->modify('+1 day')->format('Y-m-d'))->where('deleted_at',null)->where('estado','en expedicion')->orderBy('id', 'ASC')->get())==1500))
        {
            foreach($pedidos as $pedido)
            {
                $pedido->fecha_entrega = Carbon::parse($pedido->fecha_entrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
                $pedido->update();
                $indice=array_search($pedido,$pedidos->toArray());
                unset($pedidos[$indice]);
            }
        }
        return view('Operador.listadoPedidosEntrega',compact('pedidos','fechaMañana','nombreDia'));

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

    public function procesarTodosPedidos()
    {
        if(!\Session::has('pedidosPostergadosCapacidad')) \Session::put('pedidosPostergadosCapacidad',array());
        if(!\Session::has('pedidosPostergados')) \Session::put('pedidosPostergados',array());
        $pedidosPostergados = \Session::get('pedidosPostergados');
        $pedidosPostergadosCapacidad=\Session::get('pedidosPostergadosCapacidad');
        $pedidos = Pedido::whereDate('fecha_entrega','=',Carbon::now()->modify('+1 day')->format('Y-m-d'))->where('deleted_at',null)->where('estado','pendiente')->orderBy('fecha_entrega', 'ASC')->orderBy('id', 'ASC')->get();
        foreach($pedidos as $pedido)
        {
            $c=0;
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cantidad<=$item->cerveza->cantidadStock)
                {
                  //Ok, hay stock para este item Pedido   
                  $c++;
                  if(($item->cerveza->cantidadStock-$item->cantidad)<=$item->cerveza->puntoPedido)
                    {   
                        $cerveza = Cerveza::find($item->cerveza->id);
                        if(isset($cerveza))
                        {   
                            $contador=0;
                            $mensajes = Mensaje::all();
                            foreach($mensajes as $mensaje)
                            {
                                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                                if($pos===false)
                                {
                                    $contador++;
                                }
                            }
                            if($contador==count($mensajes))
                            {
                                $this->notificaciónPuntoPedido($cerveza);
                            }
                            
                        }
                        else
                        {
                          return back()->with('error','Ha ocurrido un error.');
                        }
                       
                    }
                }
                else
                {
                    $pedido->fecha_entrega = Carbon::parse($pedido->fecha_entrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
                    $pedido->update();
                    array_push($pedidosPostergados,$pedido->id);
                    break;
                }
                
               
            }

            
            if($c==count($pedido->itemsPedidos))
            {   
                $litrosAcumulados= $this->getLitrosCamion(Pedido::whereDate('fecha_entrega','=',Carbon::now()->modify('+1 day')->format('Y-m-d'))->where('deleted_at',null)->where('estado','en expedicion')->orderBy('id', 'ASC')->get()) + $this->getTotalLitrosPedido($pedido);
                if($litrosAcumulados>1500)
                {
                    $pedido->fecha_entrega = Carbon::parse($pedido->fecha_entrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
                    $pedido->update();
                    array_push($pedidosPostergadosCapacidad,$pedido->id);
                    
                }
                else
                {
                    $this->actualizarStock($pedido);
                    $pedido->estado = "en expedicion";
                    $pedido->fecha_facturacion=Carbon::now()->format('Y-m-d H:i:s');
                    $pedido->update();
                }
                
                
            }
        }
        \Session::put('pedidosPostergados',$pedidosPostergados);
        \Session::put('pedidosPostergadosCapacidad',$pedidosPostergadosCapacidad);
        return redirect()->route('expedicionCamion');

    }

    public static function actualizarStock($pedido)
    {
        foreach($pedido->itemsPedidos as $item)
            {
                $cerveza = Cerveza::find($item->cerveza->id);
                if(isset($cerveza))
                { 
                    $cerveza->cantidadStock = $cerveza->cantidadStock - $item->cantidad;
                    $cerveza->update();
                }
                else{
                    return redirect('listadoPedidosEntregaHoy')->with('error','Se ha producido un error al procesar los pedido');
                }
            }
    }

    //Procesamiento de un pedido
    public function controlStock($idPedido)
    {
        $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
        if(!\Session::has('pedidosPostergadosCapacidad')) \Session::put('pedidosPostergadosCapacidad',array());
        if(!\Session::has('pedidosPostergados')) \Session::put('pedidosPostergados',array());
        $pedidosPostergados = \Session::get('pedidosPostergados');
        $pedidosPostergadosCapacidad=\Session::get('pedidosPostergadosCapacidad');
        $fechaActual= Carbon::now()->format('d-m-Y');
        $fechaPago= Carbon::now()->addDays(15)->format('d-m-Y');
        $pedido = Pedido::find($idPedido);
        if(isset($pedido))
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cantidad<=$item->cerveza->cantidadStock)
                {
                    if(($item->cerveza->cantidadStock-$item->cantidad)<=$item->cerveza->puntoPedido)
                    {   
                        $cerveza = Cerveza::find($item->cerveza->id);
                        if(isset($cerveza))
                        {
                            $contador=0;
                            $mensajes = Mensaje::all();
                            foreach($mensajes as $mensaje)
                            {
                                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                                if($pos===false)
                                {
                                    $contador++;
                                }
                            }
                            if($contador==count($mensajes))
                            {
                                $this->notificaciónPuntoPedido($cerveza);
                            }
                        }
                        else
                        {
                          return back()->with('error','Ha ocurrido un error.');
                        }
                       
                    }
                }
                else
                {
                    $pedido->fecha_entrega = Carbon::parse($pedido->fecha_entrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
                    $pedido->update();
                    array_push($pedidosPostergados,$pedido->id);
                    \Session::put('pedidosPostergados',$pedidosPostergados);
                    return redirect('listadoPedidosEntrega')->with('error','No hay stock para procesar este pedido. El pedido '.$pedido->id.' posterga su fecha de entrega hasta el dia siguiente');
                    
                }
                
            }

            $litrosAcumulados= $this->getLitrosCamion($pedidos) + $this->getTotalLitrosPedido($pedido);
            if($litrosAcumulados>1500)
            {
                $pedido->fecha_entrega = Carbon::parse($pedido->fecha_entrega)->addDays(1)->hour(8)->minute(00)->second(00)->format('Y-m-d H:i:s');
                $pedido->update();
                array_push($pedidosPostergadosCapacidad,$pedido->id);
                \Session::put('pedidosPostergadosCapacidad',$pedidosPostergadosCapacidad);
                return redirect('listadoPedidosEntrega')->with('error','Se excede la capacidad del camion al procesar este pedido. El pedido '.$pedido->id.' posterga su fecha de entrega hasta el dia siguiente');
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
            return redirect('listadoPedidosEntrega')->with('error','Se ha producido un error al procesar el pedido');
        }
        
    }

    public static function getTotalLitrosPedido($pedido)
    {
        $lts=0;
        foreach($pedido->itemsPedidos as $item)
        
        {
            $lts+=$item->cantidad;
        }
        return $lts;
    }

    public function expedicionPedido($idPedido)
    {
        $pedido = Pedido::find($idPedido);
        if(isset($pedido))
        {
            foreach($pedido->itemsPedidos as $item)
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
            $pedido->estado = "en expedicion";
            $pedido->fecha_facturacion=Carbon::now()->format('Y-m-d H:i:s');
            $pedido->update(); 
            return redirect()->route('expedicionCamion');

        }
        else
        {
            return redirect('listadoPedidosEntrega')->with('error','Se ha producido un error al procesar el pedido');
        }


    }

    public function GetPedidosExpedicion()
    {
        if(\Session::has('pedidosPostergados') & \Session::has('pedidosPostergadosCapacidad') )
        {
            $pedidosPostergadosCapacidad= \Session::get('pedidosPostergadosCapacidad');
            $pedidosPostergados= \Session::get('pedidosPostergados');
            $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
            $litrosTotales=$this->getLitrosCamion($pedidos);
            return view('Operador.expedicionesCamion',compact('pedidos','litrosTotales','pedidosPostergados','pedidosPostergadosCapacidad'));
        }
        elseif(\Session::has('pedidosPostergados'))
        {   $pedidosPostergadosCapacidad=array();
            $pedidosPostergados= \Session::get('pedidosPostergados');
            $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
            $litrosTotales=$this->getLitrosCamion($pedidos);
            return view('Operador.expedicionesCamion',compact('pedidos','litrosTotales','pedidosPostergados','pedidosPostergadosCapacidad'));
        }
        elseif(\Session::has('pedidosPostergadosCapacidad'))
        {
            $pedidosPostergadosCapacidad=\Session::get('pedidosPostergadosCapacidad');
            $pedidosPostergados= array();
            $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
            $litrosTotales=$this->getLitrosCamion($pedidos);
            return view('Operador.expedicionesCamion',compact('pedidos','litrosTotales','pedidosPostergados','pedidosPostergadosCapacidad'));
        }
        else
        {
            $pedidosPostergadosCapacidad=array();
            $pedidosPostergados= array();
            $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
            $litrosTotales=$this->getLitrosCamion($pedidos);
            return view('Operador.expedicionesCamion',compact('pedidos','litrosTotales','pedidosPostergados','pedidosPostergadosCapacidad'));
        }
       

    }

    public function MostrarRemito($idPedido)
    {
        $pedido = Pedido::find($idPedido);
        if(isset($pedido))
        {
            return view('Operador.remito',compact('pedido'));
        }
        else
        {
            return redirect('expedicionCamion')->with('error','Se ha producido un error al visualizar el remito');
        }

    }

    public function MostrarFactura($idPedido)
    {
        $fechaActual= Carbon::now()->format('d-m-Y');
        $fechaPago= Carbon::now()->addDays(15)->format('d-m-Y');
        $pedido = Pedido::find($idPedido);
        if(isset($pedido))
        {
            switch ($pedido->usuario->condicionIVA)
            {
                case "Responsable Inscripto":
                    return view('Operador.facturaElectronicaA',compact('pedido','fechaActual','fechaPago'));
                    break;
                case "Monotributista":
                    return view('Operador.facturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;
                
                case "Exento":
                    return view('Operador.facturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;

                case "Consumidor Final":
                    return view('Operador.facturaElectronicaB',compact('pedido','fechaActual','fechaPago'));
                    break;
            }

        }
        else
        {
            return redirect('expedicionCamion')->with('error','Se ha producido un error al visualizar la factura');
        }   

    }

    public static function getLitrosCamion($pedidos)
    {
        $litrosTotales=0;
        foreach($pedidos as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                $litrosTotales+= $item->cantidad;
            }
        }
        return $litrosTotales;
    }

    public function mostrarCamion()
    {
        $nombreDia=Carbon::now()->modify('+1 day')->format('l');
        $nombreDia=$this->traducirDia($nombreDia);
        $fechaMañana=Carbon::now()->modify('+1 day')->format('d-m-Y');
        $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
        $litrosTotales=$this->getLitrosCamion($pedidos);
        return view('Operador.estadoCamion',compact('pedidos','litrosTotales','nombreDia','fechaMañana'));
    }


    public function logisticaPedidos()
    {  
        if($this->traducirDia(Carbon::now()->format('l'))=="Domingo")
        {
            $cervezas = Cerveza::all()->where('deleted_at',null);
            foreach($cervezas as $cerveza)
            {
                $this->calculoPPLO($cerveza);
            }
            
        }
        
        $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();
        $pdfController= new PDFController();
        $pdfController->envioFacturas();
        foreach($pedidos as $pedido)
        {
            $pedido->estado='entregado';
            $pedido->update();
        }

        return redirect('home')->with('message','Pedidos despachados y facturas enviados con exito');
    }


    static function calculoPPLO($cerveza)
    {
        // SUMATORIA LITROS PEDIDO LUNES
        $pedidosLunes = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-6 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltLunes=0;
        foreach($pedidosLunes as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltLunes+=$item->cantidad;
                }
            }
        }

        // SUMATORIA LITROS PEDIDO MARTES
        $pedidosMartes = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-5 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltMartes=0;
        foreach($pedidosMartes as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltMartes+=$item->cantidad;
                }
            }
        }

        // SUMATORIA LITROS PEDIDO MIERCOLES
        $pedidosMiercoles = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-4 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltMiercoles=0;
        foreach($pedidosMiercoles as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltMiercoles+=$item->cantidad;
                }
            }
        }

        // SUMATORIA LITROS PEDIDO JUEVES
        $pedidosJueves = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-3 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltJueves=0;
        foreach($pedidosJueves as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltJueves+=$item->cantidad;
                }
            }
        }

        // SUMATORIA LITROS PEDIDO VIERNES
        $pedidosViernes = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-2 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltViernes=0;
        foreach($pedidosViernes as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltViernes+=$item->cantidad;
                }
            }
        }

        // SUMATORIA LITROS PEDIDO SABADO
        $pedidosSabado = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->modify('-1 day')->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltSabado=0;
        foreach($pedidosSabado as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltSabado+=$item->cantidad;
                }
            }
        }
        
        // SUMATORIA LITROS PEDIDO DOMINGO
        $pedidosDomingo = Pedido::where('deleted_at',null)->whereDate('fecha_entrega','=',Carbon::now()->format('Y-m-d'))->where('estado','=','entregado')->get();
        $ltDomingo=0;
        foreach($pedidosDomingo as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {
                if($item->cerveza->nombre == $cerveza->nombre)
                {
                    $ltDomingo+=$item->cantidad;
                }
            }
        }

        if(count($pedidosLunes)>0 & count($pedidosMartes)>0 & count($pedidosMiercoles)>0 & count($pedidosJueves)>0 & count($pedidosViernes)>0 & count($pedidosSabado)>0 & count($pedidosDomingo)>0)
        {
            $sumaParte1=$ltLunes + $ltMartes + $ltMiercoles;
            $sumapromedioParte2= ($ltJueves + $ltViernes + $ltSabado + $ltDomingo) / 4;
            $demandaPromedio = $sumaParte1+$sumapromedioParte2;

            $desvioEstandar= sqrt((pow($sumaParte1-$demandaPromedio,2)+pow($ltJueves-$demandaPromedio,2)+pow($ltViernes-$demandaPromedio,2)+pow($ltSabado-$demandaPromedio,2)+pow($ltDomingo-$demandaPromedio,2))/4);
            $leedTime=1;
            $tStudent=2.1318; //Valor hallado de la tabla
            $costoFijoCompra=1500; //Por flete
            $costoMantenimientoInventario=1071; //Por dia
            $tasaMantenimientoExistencial=0.11; //Por dia
            
            $ptoPedido= (($demandaPromedio/5) * ($leedTime/5) + $tStudent * ($desvioEstandar/5) * sqrt($leedTime/5))*2;

            $loteOptimo= (sqrt((2*($demandaPromedio/5)*$costoFijoCompra)/($costoMantenimientoInventario*$tasaMantenimientoExistencial)))*10;

            $cerveza->puntoPedido= (int)$ptoPedido;
            $cerveza->loteOptimo= (int)$loteOptimo;
            $cerveza->update();
        }
        
    }

    static function notificaciónPuntoPedido($cerveza)
    {
        $administradores = User::where('id_tipo_usuario', '=',2)->get();
        foreach($administradores as $admin)
        {
            $mensaje = new Mensaje();
            $mensaje->id_usuario=$admin->id;
            $mensaje->cuerpo='Stock: Se necesita comprar '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre;
            $mensaje->leido=false;
            $mensaje->procesado=false;
            $mensaje->informativo=false;
            $mensaje->save();
        }
    }

    public function solicitarAbastecimiento(Cerveza $cerveza, Proveedor $proveedor)
    {
        return view('Administrador.ordenCompra',compact('cerveza','proveedor'));
    }
}
