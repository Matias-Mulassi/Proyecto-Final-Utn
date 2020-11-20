<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rules\FormatoCuit;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(!\Session::has('cuitcuil')) \Session::put('cuitcuil',$data['cuitcuil']);
        return Validator::make($data, [
            'nombre' => ['required','regex:/^[A-Za-zäÄëËïÏöÖüñÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s-_]+$/', 'max:255'],
            'apellido' => ['required','regex:/^[A-Za-zäÄëËïÏöÖüñÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s-_]+$/' , 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_tipo_usuario' => ['required','integer'],
            'cuitcuil' => ['required','regex:/^(20|23|27|30|33)([0-9]{9}|-[0-9]{8}-[0-9]{1})$/',new FormatoCuit(), 'min:13', 'max:13'],
            'razonSocial' => ['required','regex:/^[A-Za-zäÄëËïÏöÖüñÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ\s-_.]+$/', 'max:255'],
            'condicionIVA' => ['required','in:Responsable Inscripto,Monotributista,Exento,Consumidor Final'],
            'direcciónEntrega' => ['required','string'],
            'telefono' => ['required','numeric'],
            
            

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_tipo_usuario'=> $data['id_tipo_usuario'],
            'cuitcuil'=> $data['cuitcuil'],
            'razonSocial'=> $data['razonSocial'],
            'condicionIVA'=> $data['condicionIVA'],
            'direcciónEntrega'=> $data['direcciónEntrega'],
            'telefono'=> $data['telefono'],
        ]);
    }
}
