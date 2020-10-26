<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Cerveza;
use App\Mensaje;
use App\ProductoCerveza;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;

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
        set_time_limit (120);
        $ordenCompra =   PDF :: loadView ('Administrador.ordenCompra' , [ 'cerveza' => $cerveza , 'proveedor' => $proveedor ])->setPaper('a4', 'landscape')->setWarnings(false);
        Mail::to($proveedor->email)->send(new MessageReceived($ordenCompra->output(),$proveedor));
        $message = 'Solicitud de abastecimiento enviada al proveedor '.$proveedor->razonSocial;
        $mensaje->procesado=true;
        $mensaje->update();
        return \Redirect::route('home')->with('message', $message);
    }


    public function enviarVariosEmails()
    {
    
        set_time_limit (120);
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::all();
        $cervezas=array();
        foreach($mensajes as $mensaje)
        {
            foreach($cervezasCerveWeb as $cerveza)
            {
                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                if($pos==true)
                {
                    $cerveza->proveedor=$this->getMejorProveedor($cerveza);
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
        $cervezaProveedor = ProductoCerveza::where('deleted_at',null)->where('nombre','=',$cerveza->nombre)->get()->first();
        $litroMasBarato=$cerveza->precio;
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
}
