<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;
use App\Categoria;
use App\HistoricoPrecio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Cookie;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class CervezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cervezas = Cerveza::all()->where('deleted_at',null);     
        return view('Administrador.abmlCervezas',compact('cervezas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $categorias = Categoria::all()->where('deleted_at',null);
        return view('Administrador.altaCerveza',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
            'descripcion' => ['required', 'string'],
            'limite' => ['required','integer','min:1'],
            'desperdicio' => ['required','integer','min:1','max:5'],
            'precio' => ['required', 'numeric','min:1'],
            'stockDisponible' => ['required','integer','min:1'],
            'puntoPedido' => ['required','integer','min:1'],
            'image' => ['required','image'],
            'id_categoria' => ['required','integer'],
            
          ];
        
        $messages = [ 'nombre.regex'=>'Formato de nombre incorrecto',
          'nombre.required'=>'Complete el campo requerido',
          'nombre.max'=>'La longitud del nombre supera el máximo requerido',
          'descripcion.required'=>'Complete el campo requerido.',
          'precio.required'=>'Complete el campo requerido.',
          'precio.numeric'=>'Formato de precio incorrecto.',
          'precio.min'=>'El precio debe ser positivo.',
          'limite.required'=>'Complete el campo requerido.',
          'limite.integer'=>'El limite debe ser entero.',
          'limite.min'=>'El limite debe ser positivo.',
          'desperdicio.required'=>'Complete el campo requerido.',
          'desperdicio.integer'=>'Ingrese el % desperdicio con un numero entero.',
          'desperdicio.min'=>'El % de desperdicio minimo es 1.',
          'desperdicio.max'=>'El % de desperdicio maximo es 5.',
          'stockDisponible.required'=>'Complete el campo requerido.',
          'stockDisponible.integer'=>'El stock debe ser entero.',
          'stockDisponible.min'=>'El stock debe ser positivo.',
          'puntoPedido.required'=>'Complete el campo requerido.',
          'puntoPedido.integer'=>'El puntoPedido debe ser entero.',
          'puntoPedido.min'=>'El punto de pedido debe ser positivo.',
          'image.required'=>'Adjunte una Imagen',
          'image.image'=>'El archivo adjuntado debe ser una imagen',
          'id_categoria.required'=>'Seleccione una categoría',
        ];  
        
        $validacion = $this->validate($request,$rules,$messages);
     
     if($validacion)
     {
        DB::transaction(function() use ($request){
          
           
            $nombre = str_replace ('.','_',$request->file('image')->getClientOriginalName());
            $extension = $request->file('image')->getClientOriginalExtension();
            $nombreImage = time().'_'.$nombre.'.'.$extension;
            $ruta = $request->file('image')->storeAs('imagenes/cervezas',$nombreImage);   
            $request->file('image')->move(public_path('../public/imagenes/cervezas'),$nombreImage);       
            $cerveza = new Cerveza();
            $cerveza->nombre = $request['nombre'];
            $cerveza->ventaLimite = $request['limite'];
            $cerveza->desperdicio = ($request['desperdicio']/100);
            $cerveza->descripcion = $request['descripcion'];
            $cerveza->cantidadStock = $request['stockDisponible'];
            $cerveza->puntoPedido = $request['puntoPedido'];
            $cerveza->image = $ruta;
            $cerveza->id_categoria = $request['id_categoria'];
            $cerveza->loteOptimo=300;
            $cerveza->save(); 
            $this->registrarPrecio($cerveza->id,$request['precio']);
            
        });
        return redirect('abmlCervezas')->with('success','Cerveza registrada con éxito.');
     }          
    }

    protected function registrarPrecio($id_cerveza,$precio)
	{
        $historico_precio = new HistoricoPrecio();
        $historico_precio->fecha_vigencia =Carbon::now()->format('Y-m-d H:i:s');
        $historico_precio->precio=$precio;
        $historico_precio->id_cerveza=$id_cerveza;
        $historico_precio->save();
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
        $cerveza = Cerveza::find($id);
        
        $categorias = Categoria::all()->where('deleted_at',null);

        if($cerveza && $categorias)
        {
          return view('Administrador.editarCerveza',compact('cerveza','categorias'));  
        }
        else
        {
          return back()->with('error','Cerveza no encontrada.');
        }    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'nombre' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
            'descripcion' => ['required', 'string'],
            'limite' => ['required','integer','min:1'],
            'desperdicio' => ['required','integer','min:1','max:5'],
            'precio' => ['required', 'numeric','min:1'],
            'stockDisponible' => ['required','integer','min:1'],
            'puntoPedido' => ['required','integer','min:1'],
            'image' => ['required','image'],
            'id_categoria' => ['required','integer'],
           ];   

        $messages = [ 'nombre.regex'=>'Formato de nombre incorrecto',
        'nombre.required'=>'Complete el campo requerido',
        'nombre.max'=>'La longitud del nombre supera el máximo requerido',
        'descripcion.required'=>'Complete el campo requerido.',
        'limite.required'=>'Complete el campo requerido.',
        'limite.integer'=>'El limite debe ser entero.',
        'limite.min'=>'El limite debe ser positivo.',
        'desperdicio.required'=>'Complete el campo requerido.',
        'desperdicio.integer'=>'Ingrese el % desperdicio con un numero entero.',
        'desperdicio.min'=>'El % de desperdicio minimo es 1.',
        'desperdicio.max'=>'El % de desperdicio maximo es 5.',
        'precio.required'=>'Complete el campo requerido.',
        'precio.numeric'=>'Formato de precio incorrecto.',
        'precio.min'=>'El precio debe ser positivo.',
        'stockDisponible.required'=>'Complete el campo requerido.',
        'stockDisponible.integer'=>'El stock debe ser entero.',
        'stockDisponible.min'=>'El stock debe ser positivo.',
        'puntoPedido.required'=>'Complete el campo requerido.',
        'puntoPedido.integer'=>'El puntoPedido debe ser entero.',
        'puntoPedido.min'=>'El punto de pedido debe ser positivo.',
        'image.required'=>'Adjunte una Imagen',
        'image.image'=>'El archivo adjuntado debe ser una imagen',
        'id_categoria.required'=>'Seleccione una categoría',
        ];        

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            DB::transaction(function() use ($request){
          
                $cerveza = Cerveza::find($request['id']);
                if(isset($cerveza))
                {
                    
               
                    $nombre = str_replace ('.','_',$request->file('image')->getClientOriginalName());
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $nombreImage = time().'_'.$nombre.'.'.$extension;
                    $ruta = $request->file('image')->storeAs('imagenes/cervezas',$nombreImage);   
                    $request->file('image')->move(public_path('../public/imagenes/cervezas'),$nombreImage);
                    $cerveza->image = $ruta;
                    $cerveza->nombre = $request['nombre'];
                    $cerveza->descripcion = $request['descripcion'];
                    $cerveza->ventaLimite = $request['limite'];
                    $cerveza->desperdicio = ($request['desperdicio']/100);
                    $cerveza->cantidadStock = $request['stockDisponible'];
                    $cerveza->puntoPedido = $request['puntoPedido'];
                    $cerveza->id_categoria = $request['id_categoria'];
                    $cerveza->update();
                    $this->registrarPrecio($cerveza->id,$request['precio']);
                }
                   
                
                
            });

            return redirect('abmlCervezas')->with('success','Cerveza actualizada con éxito.');
        }
        else{
            return redirect('abmlCervezas')->with('error','Cerveza no encontrada');
        }
      
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

    public function logic_delete($id)
    {
        $cerveza = Cerveza::find($id);
        if($cerveza)
        {
           if(isset($cerveza->deleted_at))
           {
             $cerveza->deleted_at = null;
           }
           else
           {
            $cerveza->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $cerveza->save(); 
           return back()->with('success','Cerveza eliminada con éxito.');
        }
        else
        {
           return back()->with('error','Cerveza no encontrada');
        }    
    }



    public function infoStock()
    {
        $cervezas = Cerveza::all()->where('deleted_at',null);     
        return view('Administrador.infoStock',compact('cervezas'));
    }

    public function updateloteOptimo(Request $request,Cerveza $cerveza)
    {
        if(isset($request['cantidad']))
        {
            if(ctype_digit($request['cantidad']))
            {
                if($request['cantidad']==0)
                {
                    return redirect()->route('infoStock')->with('error','La cantidad minima a pedir es de 1 litro');
                }
                if($request['cantidad']<=2000)
                {
                    $cerveza->loteOptimo=$request['cantidad'];
                    $cerveza->update();
                    return redirect('infoStock')->with('success','Lote Optimo actualizado con éxito.');
                }
                else
                {
                    return redirect()->route('infoStock')->with('error','La cantidad en litros no puede ser mayor a 2000.');
                }
            }
            else
            {
                return redirect()->route('infoStock')->with('error','La cantidad en litros debe ser entera y positiva.'); 
            }
        }
        else
        {
            return redirect()->route('infoStock')->with('error','Ingrese una cantidad de litros a pedir.');
        }
    }

    public function getUltimoPrecio($idCerveza)
    {
        $historico_precio=HistoricoPrecio::where('id_cerveza','=',$idCerveza)->orderBy('fecha_vigencia', 'DESC')->get()->first();
        return $historico_precio->precio;
    }

    public function getPrecioVigente($idCerveza,$fechaPedido)
    {
        $historico_precio=HistoricoPrecio::where('id_cerveza','=',$idCerveza)->where('fecha_vigencia','<=',$fechaPedido)->orderBy('fecha_vigencia', 'DESC')->get()->first();
        return $historico_precio->precio;
    }


    public function cambioPrecios()
    {
        return view('Administrador.cambioPreciosCerveza');
    }

    public function updatePrecios(Request $request)
    {
        $rules = [
            
            'porcentaje' => ['required', 'numeric','min:1','max:200'],
            
           ];   

        $messages = [ 
        'porcentaje.required'=>'Complete el campo requerido.',
        'porcentaje.numeric'=>'El porcentaje debe ser numerico.',
        'porcentaje.min'=>'El porcentaje debe ser positivo.',
        'porcentaje.max'=>'El porcentaje de aumento no debe ser superior a 200%.',
       
        ];

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            $cervezas = Cerveza::all()->where('deleted_at',null);
            if(count($cervezas)>0)
            {
                foreach($cervezas as $cerveza)
                {
                    $this->registrarPrecioPorcentaje($cerveza->id,$request['porcentaje']);      
                }
                return redirect('abmlCervezas')->with('success','Precios actualizados con exito.');
            }   
            else
            {           
                return redirect()->route('abmlCervezas')->with('error','Error al intentar cambiar precios.'); 
            }
        }
    }

    public function registrarPrecioPorcentaje($idCerveza,$porcentaje)
    {
        $historico_precio = new HistoricoPrecio();
        $ultimoprecio= $this->getUltimoPrecio($idCerveza);
        $historico_precio->fecha_vigencia =Carbon::now()->format('Y-m-d H:i:s');
        $historico_precio->precio=number_format(($ultimoprecio + $ultimoprecio* ($porcentaje/100)),1);
        $historico_precio->id_cerveza=$idCerveza;
        $historico_precio->save();
    }

    public function updatePrecioCerveza(Request $request, $idCerveza)
    {
        if(isset($request['precio']))
        {
            if(is_numeric($request['precio'])& ((int)$request['precio']>0))
            {
                if($request['precio']==0)
                {
                    return redirect()->route('abmlCervezas')->with('error','El precio no puede ser igual a cero');
                }
                if($request['precio']<=1000)
                {
                    $this->registrarPrecio($idCerveza,$request['precio']);      
                    return redirect('abmlCervezas')->with('success','Precio de cerveza actualizado con exito.');
                }
                else
                {
                    return redirect()->route('abmlCervezas')->with('error','El precio de la cerveza no puede ser mayor a $1000.');
                }
            }
            else
            {
                return redirect()->route('abmlCervezas')->with('error','El precio de la cerveza debe ser numerico y positivo.'); 
            }
        }
        else
        {
            return redirect()->route('abmlCervezas')->with('error','Ingrese precio de cerveza.');
        }
    
        
    
        
    }

    
}

