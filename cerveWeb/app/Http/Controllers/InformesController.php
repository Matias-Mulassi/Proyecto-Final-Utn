<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Compra;
use App\Cerveza;
use App\Proveedor;

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

    public function showComprasMenu()
    {
        return view('Administrador.informesComprasMain');
    }

    public function showVentasMenu()
    {
        return view('Administrador.informesVentasMain');
    }

    public function showComprasProveedores(Request $request)
    {
       
        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeCompras')->with('messageError', $message);
        }


        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de compras a proveedores.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de compras a proveedores.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);


        if($validacion)
        {
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta'];
            $proveedores= Proveedor::all()->where('deleted_at',null); 
            return view('Administrador.informeComprasProveedores',compact('proveedores','fechaDesde','fechaHasta'));
        }
        
        
    }

    public function showVentasClientes(Request $request)
    {
       
        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeVentas')->with('messageError', $message);
        }


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

    public function showComprasCervezas(Request $request)
    {

        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de compras de cervezas.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de compras de cervezas.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta'];
            $cervezas= Cerveza::all()->where('deleted_at',null);  
            return view('Administrador.informesComprasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
        }

        
    }


    public function showVentasCervezas(Request $request)
    {

        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeVentas')->with('messageError', $message);
        }

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

    public function buscarProveedor(Request $request)
    {
        $fechaDesde = $request['fechaDesde'];
        $fechaHasta = $request['fechaHasta'];
        $razonSocial= $request['razonSocial'];
        $proveedores= Proveedor::where('deleted_at',null)->where('razonSocial','like',"%$razonSocial%")->get();
        return view('Administrador.informeComprasProveedores',compact('proveedores','fechaDesde','fechaHasta'));
    }

    public function buscarCerveza(Request $request)
    {
        $fechaDesde = $request['fechaDesde'];
        $fechaHasta = $request['fechaHasta'];
        $cerveza= $request['cerveza'];
        $cervezas= Cerveza::where('deleted_at',null)->where('nombre','like',"%$cerveza%")->get();
        return view('Administrador.informeVentasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
    }

    public function buscarCompraCerveza(Request $request)
    {
        $fechaDesde = $request['fechaDesde'];
        $fechaHasta = $request['fechaHasta'];
        $cerveza= $request['cerveza'];
        $cervezas= Cerveza::where('deleted_at',null)->where('nombre','like',"%$cerveza%")->get();
        return view('Administrador.informesComprasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
    }


    public function showComprasProveedoresSelect(Request $request)
    {
        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
            'proveedor' => ['nullable'],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de compras a proveedores.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de compras a proveedores.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $proveedor= $request['proveedor'];
            $proveedores= Proveedor::where('deleted_at',null)->where('razonSocial','like',"%$proveedor%")->get();
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta']; 
            return view('Administrador.informeComprasProveedores',compact('proveedores','fechaDesde','fechaHasta'));
        }
       
        
        
    }

    public function showVentasClientesSelect(Request $request)
    {
        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeVentas')->with('messageError', $message);
        }

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

        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeVentas')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeVentas')->with('messageError', $message);
        }

        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
            'cerveza' => ['nullable'],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de ventas de cervezas.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas a cervezas.',
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


    public function showComprasCervezasSelect(Request $request)
    {

        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informeCompras')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informeCompras')->with('messageError', $message);
        }

        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
            'cerveza' => ['nullable'],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis de compras de cervezas.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis de ventas de cervezas.',
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
            return view('Administrador.informesComprasCervezas',compact('cervezas','fechaDesde','fechaHasta'));
        }
        
        
    }

    public function showInformeGerencial(Request $request)
    
    {


        if(!($request['fechaDesde']))
        {
            $message = 'Error: Por favor ingrese fecha Desde para el informe.';
			return redirect('informes')->with('messageError', $message);
        }

        if(!($request['fechaHasta']))
        {
            $message = 'Error: Por favor ingrese fecha Hasta para el informe.';
			return redirect('informes')->with('messageError', $message);
        }
        

        if($request['fechaDesde'] > $request['fechaHasta'])
        {
            $message = 'Error: La fecha desde debe ser menor o igual a la fecha hasta.';
			return redirect('informes')->with('messageError', $message);
        }

        $rules = [
                
            'fechaDesde' => ['required','date','before_or_equal:'.$request['fechaHasta']],            
            'fechaHasta' => ['required','date','after_or_equal:'.$request['fechaDesde']],
        ];   

        $messages = [
                'fechaDesde.required'=>'Seleccione desde dónde comenzar el analisis del informe General.',
                'fechaHasta.required'=>'Seleccione desde dónde terminar el analisis del informe General.',
                'fechaDesde.before_or_equal'=>'La fecha desde debe ser menor o igual a la fecha hasta.',
                'fechaHasta.after_or_equal'=>'La fecha hasta debe ser mayor o igual a la fecha desde.',
            ];

        $validacion = $this->validate($request,$rules,$messages);
        if($validacion)
        {
            $fechaDesde=$request['fechaDesde'];
            $fechaHasta=$request['fechaHasta'];
            $proveedores= Proveedor::all()->where('deleted_at',null);
            $clientes = User::all()->where('deleted_at',null)->where('id_tipo_usuario',1);
            $cervezas= Cerveza::all()->where('deleted_at',null);
            return view('Administrador.informeGeneral',compact('proveedores','clientes','cervezas','fechaDesde','fechaHasta'));
        }


    }

    
}
