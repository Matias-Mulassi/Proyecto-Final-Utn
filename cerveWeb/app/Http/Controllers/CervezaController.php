<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cerveza;
use App\Categoria;

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
            'precio' => ['required', 'numeric'],
            'id_categoria' => ['required','integer'],
          ];
        
        $messages = [ 'nombre.regex'=>'Formato de nombre incorrecto',
          'nombre.required'=>'Complete el campo requerido',
          'nombre.max'=>'La longitud del nombre supera el máximo requerido',
          'descripcion.required'=>'Complete el campo requerido.',
          'precio.required'=>'Complete el campo requerido.',
          'precio.numeric'=>'Formato de precio incorrecto.',
          'id_categoria.required'=>'Seleccione un tipo de usuario',
        ];  
        
        $validacion = $this->validate($request,$rules,$messages);
     
     if($validacion)
     {
        $cerveza = new Cerveza();
        $cerveza->nombre = $request['nombre'];
        $cerveza->descripcion = $request['descripcion'];
        $cerveza->precio = $request['precio'];
        $cerveza->id_categoria = $request['id_categoria'];
        $cerveza->save(); 
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

        if(isset($cerveza))
        {
          return view('Administrador.editarCerveza',compact('cerveza'));  
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
            'precio' => ['required', 'numeric'],
           ];   

        $messages = [ 'nombre.regex'=>'Formato de nombre incorrecto',
        'nombre.required'=>'Complete el campo requerido',
        'nombre.max'=>'La longitud del nombre supera el máximo requerido',
        'descripcion.required'=>'Complete el campo requerido.',
        'precio.required'=>'Complete el campo requerido.',
        'precio.numeric'=>'Formato de precio incorrecto.',
        ];        

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            $cerveza = Cerveza::find($request['id']);
            if(isset($cerveza)){
                $cerveza->nombre = $request['nombre'];
                $cerveza->descripcion = $request['descripcion'];
                $cerveza->precio = $request['precio'];

            $cerveza->update();
            return redirect('abmlCervezas')->with('success','Cerveza actualizada con éxito.');
            }
            else{
                return redirect('abmlCervezas')->with('error','Cerveza no encontrada');
            }
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

