<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Cerveza;
use App\Proveedor;
use App\Mensaje;
use App\User;
use Carbon\Carbon;

class CompraController extends Controller
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


    public function registrarCompra(Cerveza $cerveza,Proveedor $proveedor)
    {
        $compra = new Compra();
        $compra->fecha= Carbon::now()->format('Y-m-d');
        $compra->cantidad= $cerveza->loteOptimo;
        $compra->id_proveedor=$proveedor->id;
        $compra->id_cerveza=$cerveza->id;
        $compra->efectiva=false;
        foreach($proveedor->productos_cervezas as $cervezaProveedor)
        {
            if($cervezaProveedor->nombre===$cerveza->nombre)
            {
                $compra->total= $cervezaProveedor->pivot->costo * $cerveza->loteOptimo;
                break;
            }
        }
        $compra->save();
    }

    public function recepcionMercaderia()
    {
        $compras = Compra::where('efectiva',false)->get();
        return view('Administrador.recepcionMercaderia',compact('compras'));
    }


    public function buscarCompraProveedor(Request $request)
    {
        $razonSocial= $request['razonSocial'];
        if($request['razonSocial']!="")
        {
            $proveedor= Proveedor::where('razonSocial','like',"%$razonSocial%")->get()->first();
            if(isset($proveedor))
            {
                $compras= Compra::where('id_proveedor',$proveedor->id)->where('efectiva',false)->get();
                return view('Administrador.recepcionMercaderia',compact('compras'));
            }
            else
            {
                return back()->with('messageError','Proveedor no encontrado.');
            }
        }
        else
        {
            $compras = Compra::where('efectiva',false)->get();
            return view('Administrador.recepcionMercaderia',compact('compras'));
        }
        
        
    }
    

    public function registroIngresoMercaderia(Compra $compra)
    {
        $cerveza = Cerveza::find($compra->cerveza->id);
        $mensajes = Mensaje::all()->where('procesado',true);

        if(isset($cerveza))
        {
            foreach($mensajes as $mensaje)
            {
                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                if($pos==true)
                {
                    $mensaje->delete();
                    break;
                }
                      
            }

            $administradores = User::where('id_tipo_usuario', '=',2)->get();
            $cerveza->cantidadStock+= $cerveza->loteOptimo;
            $cerveza->update();

            foreach($administradores as $admin)
                {
                    $mensaje = new Mensaje();
                    $mensaje->id_usuario=$admin->id;
                    $mensaje->cuerpo='Stock: Ingresaron '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre. ' el dia '.Carbon::now()->format('d-m-Y').' a las '.Carbon::now()->format('H:i').' hs';
                    $mensaje->leido=false;
                    $mensaje->procesado=false;
                    $mensaje->informativo=true;
                    $mensaje->save();
                }
            $compra->efectiva=true;
            $compra->update();
            return redirect('recepcionMercaderia')->with('success','Ingreso de mercaderia registrado con exito.');
        }
        else
        {
          return back()->with('error','Error al confirmar ingreso mercaderia.');
        }   


        
    }


    public function registroTodoIngresoMercaderia()
    {
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::all()->where('procesado',true);
        $cervezas=array();
        if(count($mensajes)>0)
        {
            foreach($mensajes as $mensaje)
            {
                foreach($cervezasCerveWeb as $cerveza)
                {
                    $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                    if($pos==true)
                    {
                        array_push($cervezas,$cerveza);
                    }
                }         
            }
            $administradores = User::where('id_tipo_usuario', '=',2)->get();
            foreach($cervezas as $cerveza)
            {
                $cerveza->cantidadStock+= $cerveza->loteOptimo;
                $cerveza->update();
                $compra= Compra::where('id_cerveza',$cerveza->id)->where('efectiva',false)->get()->first();
                $compra->efectiva=true;
                $compra->update();
                
                foreach($administradores as $admin)
                {
                    $mensaje = new Mensaje();
                    $mensaje->id_usuario=$admin->id;
                    $mensaje->cuerpo='Stock: Ingresaron '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre.' el dia '.Carbon::now()->format('d-m-Y').' a las '.Carbon::now()->format('H:i').' hs';
                    $mensaje->leido=false;
                    $mensaje->procesado=false;
                    $mensaje->informativo=true;
                    $mensaje->save();
                }
            }

            foreach($mensajes as $mensaje)
            {
                $mensaje->delete();       
            }

            return redirect('recepcionMercaderia')->with('success','Ingreso de toda la mercaderia registrado con exito.');    
        }
        return redirect('recepcionMercaderia')->with('info','No hay mercaderia a ingresar.');    
    }
    

    public function getComprasByProveedor($idProveedor,$fechaDesde,$fechaHasta)
    {
        $compras = Compra::where('id_proveedor','=',$idProveedor)->where('efectiva',true)->whereDate('fecha','>=',$fechaDesde)->whereDate('fecha','<=',$fechaHasta)->orderBy('fecha', 'ASC')->get();
        return $compras;
    }

    public function getComprasByCerveza($idCerveza,$fechaDesde,$fechaHasta)
    {
        $compras = Compra::where('id_cerveza','=',$idCerveza)->where('efectiva',true)->whereDate('fecha','>=',$fechaDesde)->whereDate('fecha','<=',$fechaHasta)->orderBy('fecha', 'ASC')->get();
        return $compras;
    }

    public function eliminarCompra(Compra $compra)
    {
       
        $cerveza = Cerveza::find($compra->cerveza->id);
        $mensajes = Mensaje::all()->where('procesado',true);

        if(isset($cerveza))
        {
            foreach($mensajes as $mensaje)
            {
                $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                if($pos==true)
                {
                    $mensaje->delete();
                    break;
                }
                      
            }

            $administradores = User::where('id_tipo_usuario', '=',2)->get();

            foreach($administradores as $admin)
                {
                    $mensaje = new Mensaje();
                    $mensaje->id_usuario=$admin->id;
                    $mensaje->cuerpo='Compra: Se anuló la compra de '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre.' al proveedor '.$compra->proveedor->razonSocial.' el dia '.Carbon::now()->format('d-m-Y').' a las '.Carbon::now()->format('H:i').' hs';
                    $mensaje->leido=false;
                    $mensaje->procesado=false;
                    $mensaje->informativo=true;
                    $mensaje->save();
                }
            $compra->delete();
            return redirect('recepcionMercaderia')->with('success','Anulación de compra registrado con exito.');
        }
        else
        {
          return back()->with('error','Error al anular Compra.');
        }   

    }

    public function eliminarTodasCompras()
    {
        $cervezasCerveWeb = Cerveza::all()->where('deleted_at',null);
        $mensajes = Mensaje::all()->where('procesado',true);
        $cervezas=array();
        if(count($mensajes)>0)
        {
            foreach($mensajes as $mensaje)
            {
                foreach($cervezasCerveWeb as $cerveza)
                {
                    $pos=strpos($mensaje->cuerpo, $cerveza->nombre);
                    if($pos==true)
                    {
                        array_push($cervezas,$cerveza);
                    }
                }         
            }
            $administradores = User::where('id_tipo_usuario', '=',2)->get();
            foreach($cervezas as $cerveza)
            {
                $compra= Compra::where('id_cerveza',$cerveza->id)->where('efectiva',false)->get()->first();
                $compra->delete();
                
                foreach($administradores as $admin)
                {
                    $mensaje = new Mensaje();
                    $mensaje->id_usuario=$admin->id;
                    $mensaje->cuerpo='Compra: Se anuló la compra de '.$cerveza->loteOptimo.' lts de la cerveza '.$cerveza->nombre.' al proveedor '.$compra->proveedor->razonSocial.' el dia '.Carbon::now()->format('d-m-Y').' a las '.Carbon::now()->format('H:i').' hs';
                    $mensaje->leido=false;
                    $mensaje->procesado=false;
                    $mensaje->informativo=true;
                    $mensaje->save();
                }
            }

            foreach($mensajes as $mensaje)
            {
                $mensaje->delete();       
            }

            return redirect('recepcionMercaderia')->with('success','Anulación de compras registrado con exito.');    
        }
        return redirect('recepcionMercaderia')->with('info','No hay mercaderia a ingresar.');    
    }

    

}
