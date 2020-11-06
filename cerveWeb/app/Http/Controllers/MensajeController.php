<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensaje;
use App\Proveedor;
use App\Cerveza;
use App\ProductoCerveza;
use App\Http\Controllers\CervezaController;

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

    public function showInformacion()
    {
        $mensajes = Mensaje::where('informativo',true)->get();
        foreach($mensajes as $mensaje)
        {
            $mensaje->leido=true;
            $mensaje->update();
        }
        return view('Administrador.panelInformacion',compact('mensajes'));
    }
    
    public function showAllNotificaciones()
    {
        $cervezasCerveWeb = Cerveza::where('deleted_at',null)->get();
        $mensajes = Mensaje::where('procesado',false)->where('informativo',false)->get();
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

    public function eliminarInformacion(Mensaje $mensaje)
    {
        $mensaje->delete();
        return redirect('home')->with('message','Mensaje Eliminado con exito.');

    }

    public function eliminarMensajesInfo()
    {
        $mensajes = Mensaje::where('informativo',true)->get();
        foreach($mensajes as $mensaje)
        {
            $mensaje->delete();
        }
        return redirect('panelInformacion')->with('success','Todos los mensajes fueron eliminados con exito.');
        
        

    }

    public function eliminarMensaje(Mensaje $mensaje)
    {
        
        $mensaje->delete();
     
        return redirect('home')->with('message','Mensaje eliminado con exito.');
        
    }


    public function eliminarTodosMensajes()
    {   $mensajes = Mensaje::where('procesado',false)->where('informativo',false)->get();
        if(count($mensajes)>0)
        {
            foreach($mensajes as $mensaje)
            {
                $mensaje->delete();
            }
            return redirect('home')->with('message','Mensajes eliminado con exito.');
        }
        else
        {
            return redirect('home')->with('messageError','No hay mensajes que borrar.');
        }
        
    }
}
