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

    public function showVentasClientes()
    {
        $clientes= User::all()->where('deleted_at',null)->where('id_tipo_usuario',1);  
        return view('Administrador.informeVentasClientes',compact('clientes'));
        
    }

    public function showVentasCervezas()
    {
        $cervezas= Cerveza::all()->where('deleted_at',null);  
        return view('Administrador.informeVentasCervezas',compact('cervezas'));
        
    }


}
