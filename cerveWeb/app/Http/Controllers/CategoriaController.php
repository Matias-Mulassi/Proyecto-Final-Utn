<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::where('deleted_at', '=',null)->get();
        return view('Administrador.abmlCategorias',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Administrador.altaCategoria');
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
            'descripcion' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\.]+$/', 'max:500'],
          ];
        
        $messages = [ 
          'nombre.regex'=>'Formato de nombre incorrecto',
          'nombre.required'=>'Complete el campo requerido',
          'nombre.max'=>'La longitud del nombre supera el máximo requerido',  
          'descripcion.regex'=>'Formato de descripcion incorrecto',
          'descripcion.required'=>'Complete el campo requerido',
          'descripcion.max'=>'La longitud de la descripción supera el máximo requerido',
        ];  
        
        $validacion = $this->validate($request,$rules,$messages);
     
     if($validacion)
     {
        $categoria = new Categoria();
        $categoria->nombre = $request['nombre'];
        $categoria->descripcion = $request['descripcion'];
        $categoria->save(); 
        return redirect('abmlCategorias')->with('success','Categoria registrada con éxito.');
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
        $categoria = Categoria::find($id);

        if(isset($categoria))
        {
          return view('Administrador.editarCategoria',compact('categoria'));  
        }
        else
        {
          return back()->with('error','Categoria no encontrada.');
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
                'descripcion' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\.]+$/', 'max:500'],
               ];   

      $messages = [ 
                    'nombre.regex'=>'Formato de nombre incorrecto',
                    'nombre.required'=>'Complete el campo requerido',
                    'nombre.max'=>'La longitud del nombre supera el máximo requerido', 
                    'descripcion.regex'=>'Formato de descripcion incorrecto',
                    'descripcion.required'=>'Complete el campo requerido',
                    'descripcion.max'=>'La longitud de la descripción supera el máximo requerido',
                  
                  ];          

     $validacion = $this->validate($request,$rules,$messages);

     if($validacion)
     {
        $categoria = Categoria::find($request['id']);
        if(isset($categoria))
        {
          $categoria->nombre = $request['nombre'];
          $categoria->descripcion = $request['descripcion'];
          $categoria->update();
          return redirect('abmlCategorias')->with('success','Categoria actualizada con éxito.');
        }
        else
        {           
          return redirect('abmlCategorias')->with('error','Categoria no encontrada.'); 
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
        $categoria = Categoria::find($id);
        if($categoria)
        {
           if(isset($categoria->deleted_at))
           {
             $categoria->deleted_at = null;
           }
           else
           {
            $categoria->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $categoria->save(); 
           return back()->with('success','Categoria eliminada con éxito.');
        }
        else
        {
           return back()->with('error','Categoria no encontrado');
        }    
    }
}
