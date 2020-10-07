<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensaje;
use App\Proveedor;
use App\Cerveza;
use App\ProductoCerveza;

class MensajeController extends Controller
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
    public function show(Mensaje $mensaje)
    {
        $mensaje->leido=true;
        $mensaje->update();
        $cervezas = Cerveza::all()->where('deleted_at',null);
        foreach($cervezas as $cerveza)
        {
            $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
            if($pos==true)
            {
                $proveedor=$this->getMejorProveedor($cerveza);
                return view('Administrador.notificacion',compact('mensaje','cerveza','proveedor'));
            }
        }
        $mensaje->delete();
        return redirect('home')->with('error','No existe la cerveza a procesar stock');

        
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

    public function showAllNotificaciones()
    {
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::all();
        $cervezas=array();
        foreach($mensajes as $mensaje)
        {
            $mensaje->leido=true;
            $mensaje->update();
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
        return view('Administrador.panelNotificaciones',compact('mensajes','cervezas'));

    }

}
