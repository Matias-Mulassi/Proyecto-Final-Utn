@extends('templates.templateEstilos')

@section('content')
<body onload="imprimir()">
@php
use App\Http\Controllers\CervezaController;
use Carbon\Carbon;
$cervezaController = new CervezaController();
@endphp
    @foreach($pedidos as $pedido)
    <div class="jumbotron">
        
        @if($pedido->usuario->condicionIVA=='Responsable Inscripto')
        <div class="container new-page">
            <div class="row" style="border: 1px solid black;">
                <div class="col text-center" style="border: 1px solid black;">
                    <h5 class="mt-2" style="font-family: Arial, Helvetica, sans-serif;"><strong> ORIGINAL</strong></h4>
                </div>
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="col" style="border: 1px solid black;">
                    <img style="float:left;" src="{{ asset('imagenes/logo.png') }}" class="avatar" width="100">
                    <h3 style="font-family: Arial, Helvetica, sans-serif; float:left; margin-top:35px;"><strong> CERVEWEB SA.</strong></h3> <br>
                    <p style="font-family: Arial, Helvetica, sans-serif; margin-top:80px;">
                            <strong>Razon Social:</strong> CerveWeb S A. <br>
                            <strong>Domicilio Comercial:</strong> Pellegrini 1750 - Rosario, Santa Fe <br> <br>
                            <strong>Condición frente al IVA: IVA Responsable Inscripto</strong>
                    </p>

                </div>
                <div class="col" style="border: 1px solid black;">
                    <div class="row" style="font-family: Arial, Helvetica, sans-serif;">
                        <div class="col text-left ml-4">
                        <h3 style="font-family: Arial, Helvetica, sans-serif; margin-top:20px; float:left;"><strong> FACTURA</strong></h3> 
                        <img style="border: 1px solid black; float:left; margin-left:20px; margin-top:10px;" src="{{ asset('imagenes/facturaA.png') }}"> <br> <br>
                        <p style="margin-top:30px;">
                            <strong> Nro.Comprobante=0001-000000075</strong> <br>
                            <strong>Fecha de Emisión: {{Carbon::parse($pedido->fecha_facturacion)->format('d-m-Y')}} </strong> <br> <br>
                            <strong>CUIT :</strong> 30-76545678-7 <br>
                            <strong>Ingresos Brutos:</strong> 30-76545678-7 <br>
                            <strong>Fecha de inicio de actividades:</strong> 05/09/2020
                        </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="col-md-6 text-left" style="border-left: 1px solid black;">
                    <h5 class="mt-2" style="font-family: Arial, Helvetica, sans-serif;"><strong> Periodo Facturado Desde: </strong>{{$fechaActual}}</h5>
                </div>
                <div class="col-md-6 text-center">
                    <h5 class="mt-2" style="font-family: Arial, Helvetica, sans-serif;"><strong> Hasta: </strong>{{$fechaActual}}</h5>
                </div>
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="col-md-12 text-left" style="border-right: 1px solid black;">
                    <h5 class="mt-2" style="font-family: Arial, Helvetica, sans-serif; margin-right:30px;">
                        <strong> Fecha de Vto. para el pago: </strong> {{$fechaPago}}
                    </h5>
                </div>
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="col-md 4 text-left">
                    <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                        <strong>CUIT : </strong>{{$pedido->usuario->cuitcuil}} <br>
                        <strong>Condición frente al IVA : </strong> {{$pedido->usuario->condicionIVA}} <br>
                        <strong>Condición de venta</strong> Cta. Cte. <br>
                    </p>
                </div>
                <div class="col-6 text-left " >
                    <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                        <strong> Apellido y Nombre / Razón Social: </strong> {{$pedido->usuario->razonSocial}} <br>
                        <strong> Domicilio comercial </strong> {{$pedido->usuario->direcciónEntrega}} - Rosario, Santa Fe
                    </p>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; margin-top:5px;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
                  
                        <table class="table mb-0">
                            <thead>
                            <tr class="table-bordered">
                                <th class="sticky-top bg-secondary" scope="col">Codigo</th>
                                <th class="sticky-top bg-secondary" scope="col">Producto/Servicio</th>
                                <th class="sticky-top bg-secondary" scope="col">Cantidad</th>
                                <th class="sticky-top bg-secondary" scope="col">U.medida</th>
                                <th class="sticky-top bg-secondary" scope="col">Precio Unitario</th>
                                <th class="sticky-top bg-secondary" scope="col">% Bonif</th>
                                <th class="sticky-top bg-secondary" scope="col">Subtotal</th>
                                <th class="sticky-top bg-secondary" scope="col">Alicuota IVA</th>
                                <th class="sticky-top bg-secondary" scope="col">Subtotal c/IVA</th>
                            
                            </tr>
                            </thead>
                            <tbody style="background-color:white; border: 0px solid white;" class="text-right">
                                @foreach($pedido->itemsPedidos as $item) 
                                <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>
                                    <tr>
                                        <th scope="row">{{$item->cerveza->id}}</th>
                                        <td class="text-left">{{$item->cerveza->nombre}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td class="text-left">litros</td>
                                        <td>{{number_format($precioCerveza /1.21,2)}}</td>
                                        <td>0.00</td>
                                        <td>{{number_format(($precioCerveza /1.21) * $item->cantidad,2)}}</td>
                                        <td>21%</td>
                                        <td>{{number_format(($precioCerveza * $item->cantidad),2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
               
                </div>    
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col-md-8">
                    <strong>Otros Tributos</strong>
                    <table class="table mb-0">
                        <thead>
                        <tr class="table-bordered">
                            <th class="sticky-top bg-secondary" scope="col">Descripción</th>
                            <th class="sticky-top bg-secondary" scope="col">Detalle</th>
                            <th class="sticky-top bg-secondary" scope="col">Alic %</th>
                            <th class="sticky-top bg-secondary" scope="col">Importe</th>
                        </tr>
                        </thead>
                        <tbody style="background-color:white; border: 0px solid white;" class="text-right">
                                <tr>
                                    <td class="text-left">Per./Ret de Impuesto a las Ganancias</td>
                                    <td class="text-left"></td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Per./Ret de IVA</td>
                                    <td class="text-left"></td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Per./Ret Ingresos Brutos</td>
                                    <td class="text-left"></td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Per./Ret Impuestos Internos</td>
                                    <td class="text-left"></td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Per./Ret Impuestos Municipales</td>
                                    <td class="text-left"></td>
                                    <td></td>
                                    <td>0.00</td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">Importe Otros Tributos:$</td>
                                    <td>0.00</td>
                                </tr>
                            </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <table  style="margin-top:100px; margin-left:100px;">
                        <tr>
                            <p hidden>{{$total=0}}</p>
                            @foreach($pedido->itemsPedidos as $item)
                            <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>
                                <p hidden>{{$total+= $item->cantidad * $precioCerveza}}</p>
                            @endforeach 
                            <p hidden>{{$discriminado=$total/1.21}}</p>
                            <td><strong>Importe Neto Gravado : $</strong></td>
                            
                            <td style="float:right;" class="text-right"><strong>{{number_format($discriminado,2)}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 27%: $</strong></td>
                            <td style="float:right"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 21%: $</strong></td>
                            <td style="float:right">
                                <p hidden>
                                    {{$totalIVA=$total-$discriminado}}
                                </p>
                                <strong>{{number_format($totalIVA,2)}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 10.5%: $</strong></td>
                            <td style="float:right"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 5%: $</strong></td>
                            <td style="float:right"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 2.5%: $</strong></td>
                            <td style="float:right"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 0%: $</strong></td>
                            <td style="float:right"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Importe Otros Tributos: $ </strong></td>
                            <td style="float:right"><strong> 0.00 </strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Importe Total: $</strong></td>
                            <td class="text-right" style="float:right"><strong><strong>{{number_format($total,2)}}</strong></strong></td>
                        </tr>
                    </table>
                </div>
            
            
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top:2px;">
            <div class="col">
                <center>
                    "I. V. A. RESPONSABLE INSCRIPTO"
                </center>
            </div>
        </div>
        <div class="row">
            <img src="{{ asset('imagenes/imagenAfip.png') }}" width="500">
        </div>
        </div>
        @else
        <div class="container new-page">
        <div class="row" style="border: 1px solid black;">
                <div class="col" style="border: 1px solid black;">
                    <img style="float:left;" src="{{ asset('imagenes/logo.png') }}" class="avatar" width="100">
                    <h3 style="font-family: Arial, Helvetica, sans-serif; float:left; margin-top:35px;"><strong> CERVEWEB SA.</strong></h3> <br>
                    <p class="text-center" style="font-family: Arial, Helvetica, sans-serif; margin-top:170px; margin-bottom:0px;">
                           
                            <strong>I.V.A.  Responsable Inscripto</strong>
                    </p>

                </div>
                <div class="col" style="border: 1px solid black;">
                    <div class="row" style="font-family: Arial, Helvetica, sans-serif;">
                        <div class="col text-center">
                        <h3 style="font-family: Arial, Helvetica, sans-serif; margin-top:20px;"><strong> FACTURA </strong><img style="margin-left:20px;" src="{{ asset('imagenes/facturaB.png') }}" width="50px"></h3>
                       
                        <center>
                            <table style="font-family: Arial, Helvetica, sans-serif; border: 1px solid black; margin-bottom: 10px;">
                                
                                           

                                <tr>
                                    <td style="border: 1px solid black;"><strong>FECHA</strong></td>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::parse($pedido->fecha_facturacion)->day}}</strong></td>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::parse($pedido->fecha_facturacion)->month}}</strong></td>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::parse($pedido->fecha_facturacion)->year}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan=4>
                                        <p>
                                            CUIT: 30-76545678-7 <br>
                                            Ingresos Brutos: 30-76545678-7 <br>
                                            INICIO DE ACTIVIDADES: 05/09/2020
                                        </p>
                                    
                                    </td>
                                
                                </tr>
                            </table>
                        </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top: 5px; ">
                <div class="col-md-4 text-left">
                    <p>
                        Señor(es): {{$pedido->usuario->razonSocial}}
                    </p>
                </div>
            </div>
            <div class="row" style="border-bottom: 1px solid black; border-left: 1px solid black;border-right: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col-md-4 text-left">
                    <p>
                        Dirección: {{$pedido->usuario->direcciónEntrega}}
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    <p>
                        Loc.: Rosario - Santa Fe
                    </p>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top: 5px;">
                <div class="col p-2" style="border-right: 1px solid black;">
                   <p style="float:left;"> <strong>Condiciones de venta: </strong> </p>
                   <p> Contado <input type="checkbox" disabled> Cta. Cte. <input type="checkbox" disabled checked></p>

                </div>
                <div class="col p-2" >
                    <p><strong>C.U.I.T.: </strong> {{$pedido->usuario->cuitcuil}}</p>             
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col p-2" style="border-right: 1px solid black;" >
                    @switch($pedido->usuario->condicionIVA)
                        @case('Monotributista')
                            <p><strong>I.V.A.</strong> Exento <input type="checkbox" disabled> No Resp. <input type="checkbox" disabled>  Cons.Final <input type="checkbox" disabled> Resp.Monot. <input type="checkbox" disabled checked> </p>
                            @break

                        @case('Exento')
                        <p><strong>I.V.A.   </strong> Exento <input type="checkbox" disabled checked> No Resp. <input type="checkbox" disabled>  Cons.Final <input type="checkbox" disabled> Resp.Monot. <input type="checkbox" disabled> </p>
                            @break

                        @case('Consumidor Final')
                        <p><strong>I.V.A.   </strong> Exento <input type="checkbox" disabled> No Resp. <input type="checkbox" disabled>  Cons.Final <input type="checkbox" disabled checked> Resp.Monot. <input type="checkbox" disabled> </p>
                            @break
                    @endswitch
                    
                </div>
                <div class="col p-2">
                    <strong> REMITO N° </strong>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; margin-top:5px;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
              
                        <table class="table mb-0">
                            <thead>
                            <tr class="table-bordered">
                                <th class="sticky-top bg-secondary text-center" scope="col">Cantidad</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">DESCRIPCION</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">Precio Unitario</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">IMPORTE</th>
                            
                            </tr>
                            </thead>
                            <tbody style="background-color:white; border: 0px solid white;" class="text-right">
                                @foreach($pedido->itemsPedidos as $item)  
                                <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>  
                                    <tr>
                                        <td scope="row">{{$item->cantidad}} lts</th>
                                        <td class="text-center">Cerveza {{$item->cerveza->nombre}}</td>
                                        <td>{{number_format($precioCerveza,2)}}</td>
                                        <td class="text-right">{{number_format($precioCerveza * $item->cantidad,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
             
                </div>    
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
                    <table class="table mb-0">
                        <tbody style="background-color:white; border: 0px solid white;">
                            <tr>
                                <td colspan="2">
                                    <img src="{{ asset('imagenes/imagenAfip.png') }}" width="500">
                                </td>
                                <td style="border-right: 1px solid black; font-size:25px; padding-top:50px;"> <strong>TOTAL $ </strong></td>
                                <p hidden>{{$total=0}}</p>
                                    @foreach($pedido->itemsPedidos as $item)
                                    <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>  
                                        <p hidden>{{$total+= $item->cantidad * $precioCerveza}}</p>
                                    @endforeach
                                
                                <td class="text-center" style="padding-top:50px; font-size:25px;" ><div style="border: 1px solid black; border-radius: 15px;"><strong>{{number_format($total,2)}} </strong></div></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
    </div>

@endforeach

<script type="text/javascript">
    function imprimir()
    {
        window.print();
    }
</script>

</body>
@endsection