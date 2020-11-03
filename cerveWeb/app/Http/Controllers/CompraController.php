<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Cerveza;
use App\Proveedor;
use Carbon\Carbon;

class CompraController extends Controller
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


    public function registrarCompra(Cerveza $cerveza,Proveedor $proveedor)
    {
        $compra = new Compra();
        $compra->fecha= Carbon::now()->format('Y-m-d');
        $compra->cantidad= $cerveza->loteOptimo;
        $compra->id_proveedor=$proveedor->id;
        $compra->id_cerveza=$cerveza->id;
        $compra->efectiva=false;
        foreach($proveedor->productos_cervezas as $cervezaProveedor)
        {
            if($cervezaProveedor->nombre===$cerveza->nombre)
            {
                $compra->total= $cervezaProveedor->pivot->costo * $cerveza->loteOptimo;
                break;
            }
        }
        $compra->save();
    }

    public function recepcionMercaderia()
    {
        $compras = Compra::where('efectiva',false)->get();
        return view('Administrador.recepcionMercaderia',compact('compras'));
    }


    public function buscarCompraProveedor(Request $request)
    {
        $razonSocial= $request['razonSocial'];
        $proveedor= Proveedor::where('razonSocial','like',"%$razonSocial%")->get()->first();
        if(isset($proveedor))
        {
            $compras= Compra::where('id_proveedor',$proveedor->id)->where('efectiva',false)->get();
            return view('Administrador.recepcionMercaderia',compact('compras'));
        }
        else
        {
            return back()->with('messageError','Proveedor no encontrado.');
        }
        
    }
    

}
