<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::all()->where('deleted_at',null);     
        return view('Administrador.abmlProveedores',compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Administrador.altaProveedor');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','unique:proveedores'],
            'cuit' => ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/','unique:proveedores'],
            'razonSocial' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255','unique:proveedores','unique:users'],
            'telefono' => ['required','numeric'],
          ];

        $messages = [ 
            'cuit.regex'=>'Formato de cuit incorrecto',
            'cuit.required'=>'Complete el campo requerido',
            'cuit.unique'=>'El cuit ingresado ya se encuentra registrado, intente con otro',
            'email.required'=>'Complete el campo requerido',
            'email.max'=>'La longitud del email supera el maximo requerido',
            'email.string'=>'Formato de email incorrecto',
            'email.email'=>'Formato de email incorrecto',
            'email.unique'=>'El email ingresado ya existe',
            'razonSocial.required'=>'Complete el campo requerido',
            'razonSocial.regex'=>'Formato de razon Social incorrecto',
            'razonSocial.max'=>'La longitud de la Razon Social supera el máximo requerido',
            'razonSocial.unique'=>'La razon Social ingresada ya se encuentra registrada, intente con otra',
            'telefono.required'=>'Complete el campo requerido',
            'telefono.numeric'=>'El telefono debe ser numerico',
        ];
        
        $validacion = $this->validate($request,$rules,$messages);
        
        if($validacion)
        {
            $prov = new Proveedor();   
            $prov->email = $request['email']; 
            $prov->razonSocial= $request['razonSocial'];
            $prov->telefono= $request['telefono'];
            $prov->cuit= $request['cuit'];
            $prov->save(); 
            return redirect('abmlProveedores')->with('success','Proveedor registrado con éxito');
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
        $prov = Proveedor::find($id);
        
        if($prov)
        {
          return view('Administrador.editarProveedor',compact('prov'));  
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
        $proveedores = Proveedor::where('id','=',$request['id'])->where('email','=',$request['email'])->where('cuit','=',$request['cuit'])->where('razonSocial','=',$request['razonSocial'])->get();
        if(count($proveedores)>0)
        {
            $ruleMail = [];
            $ruleCuit = [];
            $ruleRazonSocial = [];
        }
        else
        {
            $proveedores = Proveedor::where('id','=',$request['id'])->where('email','=',$request['email'])->where('cuit','=',$request['cuit'])->get();

            if(count($proveedores)>0)
            {
                $ruleMail = [];
                $ruleCuit = [];
                $ruleRazonSocial = ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255','unique:proveedores','unique:users'];
            }
            else
            {   
                $proveedores = Proveedor::where('id','=',$request['id'])->where('email','=',$request['email'])->where('razonSocial','=',$request['razonSocial'])->get();
                if(count($proveedores)>0)
                {
                    $ruleMail = [];
                    $ruleCuit = ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/','unique:proveedores'];
                    $ruleRazonSocial = [];
                }
                else
                {
                    $proveedores = Proveedor::where('id','=',$request['id'])->where('cuit','=',$request['cuit'])->where('razonSocial','=',$request['razonSocial'])->get();
                    if(count($proveedores)>0)
                    {
                        $ruleMail = ['required', 'string', 'email', 'max:255', 'unique:users','unique:proveedores'];
                        $ruleCuit = [];
                        $ruleRazonSocial = [];
                    }
                    else
                    {
                        $proveedores = Proveedor::where('id','=',$request['id'])->where('email','=',$request['email'])->get();
                        if(count($proveedores)>0)
                        {
                            $ruleMail = [];
                            $ruleCuit = ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/','unique:proveedores'];
                            $ruleRazonSocial = ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255','unique:proveedores','unique:users'];
                        }
                        else
                        {
                            $proveedores = Proveedor::where('id','=',$request['id'])->where('cuit','=',$request['cuit'])->get();
                            if(count($proveedores)>0)
                            {
                                $ruleMail = ['required', 'string', 'email', 'max:255', 'unique:users','unique:proveedores'];
                                $ruleCuit = [];
                                $ruleRazonSocial = ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255','unique:proveedores','unique:users'];
                            }
                            else
                            {
                                $proveedores = Proveedor::where('id','=',$request['id'])->where('razonSocial','=',$request['razonSocial'])->get();
                                if(count($proveedores)>0)
                                {
                                    $ruleMail = ['required', 'string', 'email', 'max:255', 'unique:users','unique:proveedores'];
                                    $ruleCuit = ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/','unique:proveedores'];
                                    $ruleRazonSocial = [];
                                }
                                else
                                {
                                    $ruleMail = ['required', 'string', 'email', 'max:255', 'unique:users','unique:proveedores'];
                                    $ruleCuit = ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/','unique:proveedores'];
                                    $ruleRazonSocial = ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255','unique:proveedores','unique:users'];
                                }
                            }


                        }
                    
                    }

                }

            
            }



            
        }
        $rules = [
            'email' => $ruleMail,
            'cuit' => $ruleCuit,
            'razonSocial' => $ruleRazonSocial,
            'telefono' => ['required','numeric'],
           ];   

        $messages = [ 
            'email.required'=>'Complete el campo requerido',
            'email.max'=>'La longitud del email supera el maximo requerido',
            'email.string'=>'Formato de email incorrecto',
            'email.email'=>'Formato de email incorrecto',
            'email.unique'=>'El email ingresado ya existe',
            'cuit.regex'=>'Formato de cuit incorrecto',
            'cuit.required'=>'Complete el campo requerido',
            'cuit.unique'=>'El cuit ingresado ya se encuentra registrado, intente con otro',
            'razonSocial.required'=>'Complete el campo requerido',
            'razonSocial.regex'=>'Formato de razon Social incorrecto',
            'razonSocial.max'=>'La longitud de la Razon Social supera el máximo requerido',
            'razonSocial.unique'=>'La razon Social ingresada ya se encuentra registrada, intente con otra',
            'telefono.required'=>'Complete el campo requerido',
            'telefono.numeric'=>'El telefono debe ser numerico',
                    
                    ];          

        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
            $prov = Proveedor::find($request['id']);
            if(isset($prov))
            {
                $prov->email = $request['email']; 
                $prov->razonSocial= $request['razonSocial'];
                $prov->telefono= $request['telefono'];
                $prov->cuit= $request['cuit'];
                $prov->update();
                return redirect('abmlProveedores')->with('success','Proveedor actualizado con éxito.');
            }
            else
            {           
            return redirect('abmlProveedores')->with('error','Proveedor no encontrado.'); 
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
        $prov = Proveedor::find($id);
        if($prov)
        {
           if(isset($prov->deleted_at))
           {
             $prov->deleted_at = null;
           }
           else
           {
            $prov->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $prov->save(); 
           return back()->with('success','Proveedor eliminado con éxito.');
        }
        else
        {
           return back()->with('error','Proveedor no encontrado');
        }    
    }

}
