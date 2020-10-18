<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/lumen/bootstrap.min.css" integrity="sha384-VMuWne6iwiifi8iEWNZMw8sDatgb6ntBpBIr67q0rZAyOQwfu/VKpnFntQrjxB5W" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lemonada:wght@500&family=Lobster+Two:ital,wght@1,700&display=swap" rel="stylesheet">
</head>
<body>
@php
    use Carbon\Carbon;
@endphp

<div style="border:2px solid black;">
    
    <table>
            <tbody>
            
                <tr>
                    <td colspan="3">
                        <img style="float:left;" src="{{ public_path('imagenes/logo.png') }}" class="avatar" width="100">
                        <h3 style="font-family: Arial, Helvetica, sans-serif; float:left; margin-top:35px;"><strong> CERVEWEB SA.</strong></h3> <br>
              
                        <p style="font-family: Arial, Helvetica, sans-serif; margin-top:170px; margin-bottom:0px; margin-left:150px;">
                                
                                    <strong>IVA Responsable Inscripto</strong>
                        </p>
                        
                
                    </td>
                    <td><div style="margin-left:170px;"></div></td>
                    <td style="border-left:1px solid black;">
                    
                    <center>
                    <div>
                        <div style="font-family: Arial, Helvetica, sans-serif; margin-left:100px; ">
                            <div class="ml-4">
                            <h3 style="font-family: Arial, Helvetica, sans-serif; margin-top:20px;"><strong> FACTURA </strong><img style="margin-left:20px; margin-top:20px;" src="{{ public_path('imagenes/facturaB.png') }}" width="50px"></h3>
                         
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
                            </div>
                        </div>
                    </div>
                    </center>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="p-2" style="border:1px solid black;">
            <table>

                <tbody>
                    <tr>
                        <td>
                                    <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                                        <strong>Señor(es) : </strong>{{$pedido->usuario->razonSocial}} <br>
                                        <strong>Dirección: </strong> {{$pedido->usuario->direcciónEntrega}} <br>
                                        
                                    </p>
                    
                        </td>
                        <td><div style="margin-left:400px;"></div></td>
                        <td>
                        <div class="text-left " >
                                    <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                                        <strong> Loc.: Rosario - Santa Fe </strong>  <br>
                                        
                                    </p>
                        </div>
                        </td>


                    </tr>
                </tbody>
    
            </table>
        </div>
        <div style="border:1px solid black;">
        <table>
            <tbody>
            
                <tr>
                    <td colspan="3" width="290">
                        
                    <div class="p-2">
                    <p style="float:left;"><strong>Condiciones de venta: Contado <input style="margin-top:5px;" type="checkbox" disabled> Cta. Cte. <input style="margin-top:5px;" type="checkbox" disabled checked></p>
                        

                    </div>
                
                    </td>
                    <td><div style="margin-left:117px;"></div></td>
                    <td style="border-left:1px solid black;">
                    
                    <center>
                    <div>
                        <div style="font-family: Arial, Helvetica, sans-serif;" class="ml-1">
                            <div>
                                <p><strong>C.U.I.T.: </strong> {{$pedido->usuario->cuitcuil}}</p> 
                            </div>
                        </div>
                    </div>
                    </center>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <div style="border:1px solid black;">
        <table>
            <tbody>
            
                <tr>
                    <td colspan="3" width="350">
                        
                    <div class="p-2">
                        @switch($pedido->usuario->condicionIVA)
                            @case('Monotributista')
                                <p><strong>I.V.A.</strong> Exento <input style="margin-top:5px;" type="checkbox" disabled> No Resp. <input style="margin-top:5px;" type="checkbox" disabled>  Cons.Final <input style="margin-top:5px;" type="checkbox" disabled> Resp.Monot. <input style="margin-top:5px;" type="checkbox" disabled checked> </p>
                                @break

                            @case('Exento')
                            <p><strong>I.V.A.   </strong> Exento <input style="margin-top:5px;" type="checkbox" disabled checked> No Resp. <input style="margin-top:5px;" type="checkbox" disabled>  Cons.Final <input style="margin-top:5px;" type="checkbox" disabled> Resp.Monot. <input style="margin-top:5px;" type="checkbox" disabled> </p>
                                @break

                            @case('Consumidor Final')
                            <p><strong>I.V.A.   </strong> Exento <input style="margin-top:5px;" type="checkbox" disabled> No Resp. <input style="margin-top:5px;" type="checkbox" disabled>  Cons.Final <input style="margin-top:5px;" type="checkbox" disabled checked> Resp.Monot. <input style="margin-top:5px;" type="checkbox" disabled> </p>
                                @break
                        @endswitch
                    </div>
                
                    </td>
                    <td><div style="margin-left:37px;"></div></td>
                    <td style="border-left:1px solid black;">
                    
                    <center>
                    <div>
                        <div style="font-family: Arial, Helvetica, sans-serif;" class="ml-1">
                            <div>
                                <p><strong>REMITO N° </strong></p> 
                            </div>
                        </div>
                    </div>
                    </center>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th class="sticky-top bg-secondary text-center" scope="col">Cantidad</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">DESCRIPCION</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">Precio Unitario</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">IMPORTE</th>
                            
                            </tr>
                            </thead>
                            <tbody style="background-color:white; border: 0px solid white;" class="text-right">
                                @foreach($pedido->itemsPedidos as $item)    
                                    <tr>
                                        <td scope="row">{{$item->cantidad}} lts</th>
                                        <td class="text-center">Cerveza {{$item->cerveza->nombre}}</td>
                                        <td>{{$item->cerveza->precio}}</td>
                                        <td class="text-right">{{number_format($item->cerveza->precio * $item->cantidad,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            <table class="table mb-0" style="border-top:2px solid black;">
                                <tbody style="background-color:white; border: 0px solid white;">
                                    <tr>
                                        <td colspan="2">
                                            <img style="margin-top:5px;" src="{{ public_path('imagenes/imagenAfip.png') }}" width="500">
                                        </td>
                                        <td style="border-right: 1px solid black; font-size:25px; padding-top:50px;"> <strong>TOTAL $ </strong></td>
                                        <p hidden>{{$total=0}}</p>
                                            @foreach($pedido->itemsPedidos as $item)
                                                <p hidden>{{$total+= $item->cantidad * $item->cerveza->precio}}</p>
                                            @endforeach
                                        
                                        <td class="text-center" style="padding-top:50px; font-size:25px;" ><div style="border: 1px solid black; border-radius: 15px;"><strong>{{number_format($total,2)}} </strong></div></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
        
    
</div>

</body>
</html>