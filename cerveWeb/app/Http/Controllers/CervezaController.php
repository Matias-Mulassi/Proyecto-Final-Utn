<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;
use App\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Cookie;
use Illuminate\Database\QueryException;

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
            $cerveza->descripcion = $request['descripcion'];
            $cerveza->precio = $request['precio'];
            $cerveza->cantidadStock = $request['stockDisponible'];
            $cerveza->puntoPedido = $request['puntoPedido'];
            $cerveza->image = $ruta;
            $cerveza->id_categoria = $request['id_categoria'];
            $cerveza->save(); 
            
        });
        return redirect('abmlCervezas')->with('success','Cerveza registrada con éxito.');
     }          
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
                    $cerveza->precio = $request['precio'];
                    $cerveza->cantidadStock = $request['stockDisponible'];
                    $cerveza->puntoPedido = $request['puntoPedido'];
                    $cerveza->id_categoria = $request['id_categoria'];
                    $cerveza->update();
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




}

