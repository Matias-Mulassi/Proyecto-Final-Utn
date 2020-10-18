<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pedido;
use Carbon\Carbon;
use App\Http\Controllers\CervezaController;

class CuentaCorrienteController extends Controller
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

    public function estadoCuenta()
    {
        $cervezaController = new CervezaController();
        $pedidos= Pedido::where('id_usuario','=',Auth::user()->id)->where('deleted_at',null)->where('pagado',false)->get();
        $totalAbonar=0;

        foreach($pedidos as $pedido)
        {
            foreach($pedido->itemsPedidos as $item)
            {   $precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at);
                $totalAbonar+= $item->cantidad * $precioCerveza;
            }
        }

        return view('Usuario.cuentaCorriente',compact('totalAbonar','pedidos'));
    }

    public function mostrarFactura(Pedido $pedido)
    {
        $fechaPago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');

        switch ($pedido->usuario->condicionIVA)
            {
                case "Responsable Inscripto":
                    return view('Usuario.facturaA',compact('pedido','fechaPago'));
                    break;
                case "Monotributista":
                    return view('Usuario.facturaB',compact('pedido','fechaPago'));
                    break;
                
                case "Exento":
                    return view('Usuario.facturaB',compact('pedido','fechaPago'));
                    break;

                case "Consumidor Final":
                    return view('Usuario.facturaB',compact('pedido','fechaPago'));
                    break;
            }

    }

    public function mostrarRemito(Pedido $pedido)
    {
        return view('Usuario.remito',compact('pedido'));
    }
}
