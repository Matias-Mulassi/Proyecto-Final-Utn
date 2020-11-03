<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Pedido;
use App\Cerveza;
use App\Mensaje;
use App\ProductoCerveza;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;
use App\Mail\BillReceived;
use Carbon\Carbon;
use App\Http\Controllers\CervezaController;
use App\Http\Controllers\CompraController;


class PDFController extends Controller
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

    public function enviarEmail(Cerveza $cerveza, Proveedor $proveedor, Mensaje $mensaje)
    {
        $compraController= new CompraController();
        set_time_limit (120);
        $ordenCompra =   PDF :: loadView ('Administrador.ordenCompra' , [ 'cerveza' => $cerveza , 'proveedor' => $proveedor ])->setPaper('a4', 'landscape')->setWarnings(false);
        Mail::to($proveedor->email)->send(new MessageReceived($ordenCompra->output(),$proveedor));
        $message = 'Solicitud de abastecimiento enviada al proveedor '.$proveedor->razonSocial;
        $mensaje->procesado=true;
        $mensaje->update();
        $compraController->registrarCompra($cerveza,$proveedor);

        return \Redirect::route('home')->with('message', $message);
    }


    public function enviarVariosEmails()
    {
        $compraController= new CompraController();
        set_time_limit (120);
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::where('procesado',false)->get();
        $cervezas=array();
        foreach($mensajes as $mensaje)
        {
            foreach($cervezasCerveWeb as $cerveza)
            {
                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                if($pos==true)
                {
                    $cerveza->proveedor=$this->getMejorProveedor($cerveza);
                    $compraController->registrarCompra($cerveza,$cerveza->proveedor);
                    array_push($cervezas,$cerveza);
                }
            }         
        }


        $proveedores = Proveedor::all()->where('deleted_at',null);
        for ($i = 0; $i <= count($proveedores)-1; $i++)
        {
            ${"cervezasProveedor_".$proveedores[$i]->razonSocial}=array();
        }

        foreach($proveedores as $proveedor)
        {
            foreach($cervezas as $cerveza)
            {
                if($proveedor->razonSocial == $cerveza->proveedor->razonSocial)
                {
                    array_push(${"cervezasProveedor_".$proveedor->razonSocial},$cerveza);
                }
            }
        }

        foreach($proveedores as $proveedor)
        {
            if(count(${"cervezasProveedor_".$proveedor->razonSocial})>0)
            {
                $ordenCompra =   PDF :: loadView ('Administrador.ordenCompraVarios' , [ 'cervezas' => ${"cervezasProveedor_".$proveedor->razonSocial} , 'proveedor' => $proveedor ])->setPaper('a4', 'landscape')->setWarnings(false);
                Mail::to($proveedor->email)->send(new MessageReceived($ordenCompra->output(),$proveedor));
            }
        }
        foreach($mensajes as $mensaje)
        {
            $mensaje->procesado=true;
            $mensaje->update();
        }
        $message = 'Solicitud de abastecimiento enviada a todos los proveedores ';
        return \Redirect::route('home')->with('message', $message);
    }
    
    static function getMejorProveedor(Cerveza $cerveza)
    {
        $cervezaController = new CervezaController();
        $cervezaProveedor = ProductoCerveza::where('deleted_at',null)->where('nombre','=',$cerveza->nombre)->get()->first();
        $litroMasBarato=$cervezaController->getUltimoPrecio($cerveza->id);
        $mejorProveedor=null;
        foreach($cervezaProveedor->proveedores as $proveedor)
        {
            if($proveedor->pivot->costo <$litroMasBarato)
            {
                $litroMasBarato=$proveedor->pivot->costo;
                $mejorProveedor=$proveedor;
            }
        }
        return $mejorProveedor;

    }

    public function envioFactura(Pedido $pedido)
    {   set_time_limit (500);

        
      
            switch ($pedido->usuario->condicionIVA) 
            {
                case "Responsable Inscripto":
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaAmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    Mail::to('fernandoalbertengo5@gmail.com')->send(new BillReceived($factura->output(),$pedido->id));
                    break;
                default:
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaBmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    Mail::to('fernandoalbertengo5@gmail.com')->send(new BillReceived($factura->output(),$pedido->id));
                    break;

            }
        $message = 'Facturas enviada a '.$pedido->usuario->razonSocial;
        return \Redirect::route('home')->with('message', $message);
    }
    public function envioFacturas()
    {   set_time_limit (500);
        $pedidos = Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get();

        foreach($pedidos as $pedido)
        {
            switch ($pedido->usuario->condicionIVA) 
            {
                case "Responsable Inscripto":
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaAmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    Mail::to('fernandoalbertengo5@gmail.com')->send(new BillReceived($factura->output(),$pedido->id));
                    break;
                default:
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaBmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    Mail::to('fernandoalbertengo5@gmail.com')->send(new BillReceived($factura->output(),$pedido->id));
                    break;

            }
        }
    }


    public function mostrarFactura(Pedido $pedido)
    {
        switch ($pedido->usuario->condicionIVA) 
            {
                case "Responsable Inscripto":
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaAmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    return $factura->stream();
     
                    break;
                default:
                    $fechapago= Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y');
                    $factura =   PDF :: loadView ('Usuario.facturaBmail' , [ 'pedido' => $pedido , 'fechaPago' => $fechapago ])->setPaper('a3', 'portrait')->setWarnings(false);
                    return $factura->stream();
                   
                    break;

            }
        
    }
}
