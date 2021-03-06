@extends('templates.templateEstilos')

@section('content')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
<body onload="imprimir()">
    

    <div class="jumbotron">
      
        <div class="container">
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
                                
                                @php
                                    use Carbon\Carbon;
                                @endphp           

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
       
    </div>
    
<script type="text/javascript">
function imprimir()
{
    window.print();
}
</script>
</body>
@endsection