<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cerveza;

class InformesController extends Controller
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

    public function showMain()
    {
        return view('Administrador.informesMain');
    }


    public function showVentasMenu()
    {
        return view('Administrador.informesVentasMain');
    }

    public function showVentasClientes(Request $request)
    {
        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de ventas a clientes.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas a clientes.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta'];
            $clientes= User::all()->where('deleted_at',null)->where('id_tipo_usuario',1);  
            return view('Administrador.informeVentasClientes',compact('clientes','fechaDesde','fechaHasta'));
        }
        
        
    }

    public function showVentasCervezas(Request $request)
    {
        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de ventas de cervezas.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas de cervezas.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta'];
            $cervezas= Cerveza::all()->where('deleted_at',null);  
            return view('Administrador.informeVentasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
        }

         
        
        
    }



    public function buscarCliente(Request $request)
    {
        $fechaDesde = $request['fechaDesde'];
        $fechaHasta = $request['fechaHasta'];
        $razonSocial= $request['razonSocial'];
        $clientes= User::where('deleted_at',null)->where('id_tipo_usuario',1)->where('razonSocial','like',"%$razonSocial%")->get();
        return view('Administrador.informeVentasClientes',compact('clientes','fechaDesde','fechaHasta'));
    }

    public function buscarCerveza(Request $request)
    {
        $fechaDesde = $request['fechaDesde'];
        $fechaHasta = $request['fechaHasta'];
        $cerveza= $request['cerveza'];
        $cervezas= Cerveza::where('deleted_at',null)->where('nombre','like',"%$cerveza%")->get();
        return view('Administrador.informeVentasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
    }


    public function showVentasClientesSelect(Request $request)
    {
        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
            'cliente' => ['nullable'],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de ventas a clientes.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas a clientes.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $cliente= $request['cliente'];
            $clientes= User::where('deleted_at',null)->where('id_tipo_usuario',1)->where('razonSocial','like',"%$cliente%")->get();
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta']; 
            return view('Administrador.informeVentasClientes',compact('clientes','fechaDesde','fechaHasta'));
        }
        
        
    }

    public function showVentasCervezasSelect(Request $request)
    {
        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
            'cerveza' => ['nullable'],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de ventas a clientes.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas a clientes.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $cerveza= $request['cerveza'];
            $cervezas= Cerveza::where('deleted_at',null)->where('nombre','like',"%$cerveza%")->get();
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta']; 
            return view('Administrador.informeVentasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
        }
        
        
    }

}
