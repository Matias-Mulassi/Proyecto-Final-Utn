<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoCerveza;
use App\Cerveza;
use App\Proveedor;


class CervezaProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $proveedor= Proveedor::find($id);
        if($proveedor)
        {
            return view('Administrador.abmlCervezasProveedor',compact('proveedor'));
        }
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
        $rules = [
            'id_cerveza' => ['required','integer'],
            'costo' => ['required', 'numeric'],
            
          ];

        $messages = [ 
        'id_cerveza.required'=>'Seleccione una cerveza',
        'costo.required'=>'Complete el campo requerido.',
        'costo.numeric'=>'Formato de costo incorrecto.',
    ];

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            $proveedor= Proveedor::findOrFail($request['idProveedor']);
            $cerveza = Cerveza::find($request['id_cerveza']);
            if(isset($cerveza))
            {   
                $cervezaProductor = ProductoCerveza::where('nombre', '=',$cerveza->nombre)->get()->first();
                if(!$cervezaProductor)
                {
                    $prodCerveza = new ProductoCerveza();
                    $prodCerveza->nombre = $cerveza->nombre; 
                    $prodCerveza->image = $cerveza->image; 
                    $prodCerveza->save();
                    $prodCerveza->proveedores()->attach($proveedor, ['costo' => $request['costo']]);
                }
                else
                {
                    $cervezaProductor->proveedores()->attach($proveedor, ['costo' => $request['costo']]);
                }
                
                return redirect()->route('abmlCervezasProveedores',$proveedor->id)->with('success','Cerveza asignada al productor con éxito');
            }
            else
            {
                return back()->with('error','Cerveza no encontrada.');
            }

           
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
    public function edit($idProveedor,$idCerveza)
    {
        $proveedor = Proveedor::find($idProveedor);
        if(isset($proveedor))
        {
            foreach($proveedor->productos_cervezas as $cervezaProveedor)
            {

                if($cervezaProveedor->id==$idCerveza)
                {
                    $costo=$cervezaProveedor->pivot->costo;
                    return view('Administrador.editarCervezaProveedor',compact('proveedor','costo','idCerveza'));
                     
                }
            }
           
        }
        else
        {
          return back()->with('error','Proveedor no encontrado.');
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
            
            'costo' => ['required', 'numeric'],
            
           ];   

        $messages = [ 
        'costo.required'=>'Complete el campo requerido.',
        'costo.numeric'=>'Formato de costo incorrecto.',
       
        ];

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            $proveedor = Proveedor::find($request['idProveedor']);
            if(isset($proveedor))
                {

                    $proveedor->productos_cervezas()->updateExistingPivot($request['idCerveza'], ['costo' => $request['costo']]);
                    return redirect()->route('abmlCervezasProveedores',$proveedor->id)->with('success','Cerveza del proveedor actualizada con éxito.');
                }
                else
                {           
                    return redirect()->route('abmlCervezasProveedores',$proveedor->id)->with('error','Proveedor no encontrado.'); 
                }     
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idProveedor,$idCerveza)
    {
        $cerveza = ProductoCerveza::find($idCerveza);

        if(isset($cerveza))
        {
          $cerveza->proveedores()->detach($idProveedor);
          return redirect()->route('abmlCervezasProveedores',$idProveedor)->with('success','Cerveza del proveedor eliminada con éxito.');

        }
        else
        {
          return back()->with('error','Cerveza no encontrada.');
        }
    }
}
