<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Cerveza;
use App\Mensaje;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;

class PDFController extends Controller
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

    public function enviarEmail(Cerveza $cerveza, Proveedor $proveedor, Mensaje $mensaje)
    {
        
        $ordenCompra =   PDF :: loadView ('Administrador.ordenCompra' , [ 'cerveza' => $cerveza , 'proveedor' => $proveedor ])->setPaper('a4', 'landscape')->setWarnings(false);
        Mail::to($proveedor->email)->send(new MessageReceived($ordenCompra->output(),$proveedor));
        $message = 'Solicitud de abastecimiento enviada al proveedor '.$proveedor->razonSocial;
        $mensaje->delete();
        return \Redirect::route('home')->with('message', $message);
    }

}
