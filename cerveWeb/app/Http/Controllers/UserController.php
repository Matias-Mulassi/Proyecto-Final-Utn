<?php

namespace App\Http\Controllers;

use App\User;
use App\TiposUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\FormatoCuit;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::where('users.id', '!=', Auth::id())->get();
        return view('Administrador.abmlUsuarios',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tiposUsuarios = TiposUsuarios::all()->where('deleted_at',null);
        return view('Administrador.altaUsuario',compact('tiposUsuarios'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required','regex:/^[A-Za-z\s-_]+$/', 'max:255'],
            'apellido' => ['required','regex:/^[A-Za-z\s-_]+$/' , 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_tipo_usuario' => ['required','integer'],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(!\Session::has('cuitcuil')) \Session::put('cuitcuil',$request['cuitcuil']);
      
      
 
        $rules = [
          'nombre' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
          'apellido' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/' , 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
          'id_tipo_usuario' => ['required','integer'],
          'cuitcuil' => ['nullable','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/',new FormatoCuit(), 'min:13','max:13'],
          'razonSocial' => ['nullable','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
          'condicionIVA' => ['nullable','in:Responsable Inscripto,Monotributista,Exento,Consumidor Final'],
          'direcciónEntrega' => ['nullable','string'],
          'telefono' => ['nullable','numeric'],
        ];   

        $messages = [ 'nombre.regex'=>'Formato de nombre incorrecto',
                'nombre.required'=>'Complete el campo requerido',
                'nombre.max'=>'La longitud del nombre supera el máximo requerido',
                'apellido.regex'=>'Formato de apellido incorrecto',
                'apellido.required'=>'Complete el campo requerido',
                'apellido.max'=>'La longitud del nombre supera el máximo requerido',
                'email.required'=>'Complete el campo requerido',
                'email.max'=>'La longitud del email supera el maximo requerido',
                'email.string'=>'Formato de email incorrecto',
                'email.email'=>'Formato de email incorrecto',
                'email.unique'=>'El email ingresado ya está en uso',
                'password.min'=>'La contraseña debe tener almenos 8 caracteres',
                'password.required'=>'Complete el campo requerido',
                'password.confirmed'=>'Las contraseñas no coinciden',
                'id_tipo_usuario.required'=>'Seleccione un tipo de usuario',
                'cuitcuil.regex'=>'Formato de cuit/cuil incorrecto',
                'cuitcuil.max'=>'La longitud del cuit/cuil supera el maximo requerido',
                'cuitcuil.min'=>'La longitud del cuit/cuil no supera el minimo requerido',
                'razonSocial.regex'=>'Formato de razon Social incorrecto',
                'razonSocial.max'=>'La longitud de la Razon Social supera el máximo requerido',
                'condicionIVA.in'=>'Valor Incorrecto, Vuelta a intentarlo',
                'telefono.numeric'=>'El telefono debe ser numerico',

                


              ];          
        $validacion = $this->validate($request,$rules,$messages);

        if($validacion)
        {
          $us = new User();
          $us->nombre = $request['nombre']; 
          $us->apellido = $request['apellido'];
          $us->email = $request['email'];
          $us->password = Hash::make($request['password']);
          $us->id_tipo_usuario= $request['id_tipo_usuario'];
          $us->razonSocial= $request['razonSocial'];
          $us->condicionIVA= $request['condicionIVA'];
          $us->direcciónEntrega= $request['direcciónEntrega'];
          $us->telefono= $request['telefono'];
          $us->cuitcuil= $request['cuitcuil'];
          $us->save(); 
          return redirect('abmlUsuarios')->with('success','Usuario registrado con éxito');
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
        $us = User::find($id);
        
        $tiposUsuarios = TiposUsuarios::all()->where('deleted_at',null);

        if($us && $tiposUsuarios)
        {
          return view('Administrador.editarUsuario',compact('us','tiposUsuarios'));  
        }
        else
        {
          return back()->with('error','Usuario no encontrado.');
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
      if(!\Session::has('cuitcuil')) \Session::put('cuitcuil',$request['cuitcuil']);
      $usuarios = User::where('id','=',$request['id'])->where('email','=',$request['email'])->get();
      if(count($usuarios)>0)
      {
        $ruleMail = [];
      }
      else
      {
        $ruleMail = ['string', 'email', 'max:255', 'unique:users'];
      } 
      $rules = [
            'nombre' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
            'apellido' => ['required','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/' , 'max:255'],
            'email' => $ruleMail,
            'id_tipo_usuario' => ['required','integer'],
            'cuitcuil' => ['nullable','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/',new FormatoCuit(),'min:13','max:13'],
            'razonSocial' => ['nullable','regex:/^[A-Za-z\s-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ]+$/', 'max:255'],
            'condicionIVA' => ['nullable','in:Responsable Inscripto,Monotributista,Exento,Consumidor Final'],
            'direcciónEntrega' => ['nullable','string'],
            'telefono' => ['nullable','numeric'],
               ];   

      $messages = [ 
                  'nombre.regex'=>'Formato de nombre incorrecto',
                  'nombre.required'=>'Complete el campo requerido',
                  'nombre.max'=>'La longitud del nombre supera el máximo requerido',
                  'apellido.regex'=>'Formato de apellido incorrecto',
                  'apellido.required'=>'Complete el campo requerido',
                  'apellido.max'=>'La longitud del nombre supera el máximo requerido',
                  'email.required'=>'Complete el campo requerido',
                  'email.max'=>'La longitud del email supera el maximo requerido',
                  'email.string'=>'Formato de email incorrecto',
                  'email.email'=>'Formato de email incorrecto',
                  'email.unique'=>'El email ingresado ya se encuentra en uso',
                  'id_tipo_usuario.required'=>'Seleccione un tipo de usuario',
                  'cuitcuil.regex'=>'Formato de cuit/cuil incorrecto',
                  'razonSocial.regex'=>'Formato de razon Social incorrecto',
                  'razonSocial.max'=>'La longitud de la Razon Social supera el máximo requerido',
                  'condicionIVA.in'=>'Valor Incorrecto, Vuelta a intentarlo',
          
                  'telefono.numeric'=>'El telefono debe ser numerico',
                  ];          

     $validacion = $this->validate($request,$rules,$messages);

     if($validacion)
     {
        $usuario = User::find($request['id']);
        if(isset($usuario))
        {
            $usuario->update($request->all());
            return redirect('abmlUsuarios')->with('success','Usuario actualizado con éxito');
        }
        else
        {
            return back()->with('error','Usuario no encontrado.');
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
        $us = User::find($id);
        if($us)
        {
           if(isset($us->deleted_at))
           {
             $us->deleted_at = null;
           }
           else
           {
            $us->deleted_at =  date('Y-m-d H:i:s');
           }
           
           $us->save(); 
           return back()->with('success','Estado de usuario modificado con éxito.');
        }
        else
        {
           return back()->with('error','Usuario no encontrado');
        }    
    }


    public function editarContraseña()
    {
      switch (Auth::user()->id_tipo_usuario) 
      {
        case 1:
            return view('auth.passwords.change');
            break;
        case 2:
            return view('auth.passwords.changeAdmin');
            break;
        case 3:
            return view('auth.passwords.changeOperator');
            break;
      }
      
      
    }

    public function actualizarContraseña(Request $request)
    {
      $rules = [
        'password' => ['required', 'string', 'min:8', 'confirmed'],
      ];   

      $messages = [ 
              'password.min'=>'La contraseña debe tener almenos 8 caracteres',
              'password.required'=>'Complete el campo requerido',
              'password.confirmed'=>'Las contraseñas no coinciden',
            ];

    
      $validacion = $this->validate($request,$rules,$messages);

      if($validacion)
      {
        $us = User::find(Auth::id());
        if($us)
        {
          $us->password = Hash::make($request['password']);
          $us->update();
          switch (Auth::user()->id_tipo_usuario) 
          {
            case 1:
                return redirect('catalogoCervezas')->with('message','Contraseña Cambiada con exito');
                break;
            case 2:
                return redirect('home')->with('message','Contraseña Cambiada con exito');
                break;
            case 3:
                return redirect('home')->with('message','Contraseña Cambiada con exito');
                break;
          }
        }
        else
        {
          return back()->with('messageError','Usuario no encontrado.');
        }
          
         
          
          
          
      }
    }
}
