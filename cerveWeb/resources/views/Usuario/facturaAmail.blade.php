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
    use App\Http\Controllers\CervezaController;
    $cervezaController = new CervezaController();
@endphp

<div style="border:2px solid black;">
    <center>
        <div style="border: 1px solid black;">
            <h5 class="mt-2" style="font-family: Arial, Helvetica, sans-serif;"><strong> ORIGINAL</strong></h4>
        </div>
    </center>
    <table>
            <tbody>
            
                <tr>
                    <td colspan="3">
                        <img style="float:left;" src="{{ public_path('imagenes/logo.png') }}" class="avatar" width="100">
                        <h3 style="font-family: Arial, Helvetica, sans-serif; float:left; margin-top:35px;"><strong> CERVEWEB SA.</strong></h3> <br>
                        <p style="font-family: Arial, Helvetica, sans-serif; margin-top:90px; margin-left:10px;">
                                <strong>Razon Social:</strong> CerveWeb S A. <br> <br>
                                <strong>Domicilio Comercial:</strong> Pellegrini 1750 - Rosario, Santa Fe <br> <br>
                                <strong>Condición frente al IVA: IVA Responsable Inscripto</strong>
                        </p>

                
                    </td>
                    <td><div style="margin-left:125px;"></div></td>
                    <td style="border-left:1px solid black;">
                    
                    <div>
                        <div style="font-family: Arial, Helvetica, sans-serif;">
                            <div class="ml-4">
                            <h3 style="font-family: Arial, Helvetica, sans-serif; margin-top:20px; float:left;"><strong> FACTURA</strong></h3>
                            <img style="border: 1px solid black; float:left; margin-left:20px; margin-top:10px;" src="{{ public_path('imagenes/facturaA.png') }}"> <br> <br> 
                         
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
                    </td>
                </tr>
            </tbody>
        </table>
    <div style="border: 1px solid black;">
                
                        
                <h3 style="font-family: Arial, Helvetica, sans-serif; padding:5px; float:left;" class="mt-2"><strong> Periodo Facturado Desde: </strong>{{Carbon::parse($pedido->fecha_facturacion)->format('d-m-Y')}}</h3>
                <h3 class="mt-2" style="font-family: Arial, Helvetica,sans-serif; padding:5px; float:right; margin-right:10px;"><strong> Hasta: {{Carbon::parse($pedido->fecha_facturacion)->format('d-m-Y')}}</strong></h3>
               
        </div>
        <br>
        <br>
        <br>
        <div style="border: 1px solid black;">
            <div class="text-left" style="border-right: 1px solid black;">
                <h3 class="mt-2 ml-1" style="font-family: Arial, Helvetica, sans-serif;">
                    <strong> Fecha de Vto. para el pago: </strong> {{Carbon::parse($pedido->fecha_facturacion)->addDays(15)->format('d-m-Y')}}
                </h3>
            </div>
    </div>
    <table>
        <tbody>
        <tr>
            <td>
              
                    <div class="text-left ml-5">
                        <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                            <strong>CUIT : </strong>{{$pedido->usuario->cuitcuil}} <br>
                            <strong>Condición frente al IVA : </strong> {{$pedido->usuario->condicionIVA}} <br>
                            <strong>Condición de venta</strong> Cta. Cte. <br>
                        </p>
         
            </td>
            <td><div style="margin-left:200px;"></div></td>
            <td>
            <div class="text-left " >
                        <p style="font-family: Arial, Helvetica, sans-serif;"> <br>
                            <strong> Apellido y Nombre / Razón Social: </strong> {{$pedido->usuario->razonSocial}} <br>
                            <strong> Domicilio comercial </strong> {{$pedido->usuario->direcciónEntrega}} - Rosario, Santa Fe
                        </p>
            </div>
            </td>


        </tr>
        </tbody>
        
        </table>
        <div style="border: 1px solid black;">
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
                        <tbody style="background-color:white;" class="text-right">
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
        <div  style="font-family: Arial, Helvetica, sans-serif;">
                <div style="float:left; width:650px; margin-left:15px;">
                    <strong class="ml-2">Otros Tributos</strong>
                    <div class="ml-1" style="margin-top:10px;">
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
                </div>
                <div style="float:right; margin-right:50px;">
                    
                    <table  style="margin-top:100px; margin-left:80px;">
                        <tr>
                            <p hidden>{{$total=0}}</p>
                            
                            @foreach($pedido->itemsPedidos as $item)
                            <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>
                                <p hidden>{{$total+= $item->cantidad * $precioCerveza}}</p>
                            @endforeach
                            <p hidden>{{$discriminado=$total/1.21}}</p>
                            <td class="text-right"><strong>Importe Neto Gravado : $</strong></td>
                            <td style="float:right;"><strong>{{number_format($discriminado,2)}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 27%: $</strong></td>
                            <td style="float:right;"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 21%: $</strong></td>
                            <td style="float:right;">
                                <p hidden>
                                    {{$totalIVA=$total-$discriminado}}
                                </p>
                                <strong>{{number_format($totalIVA,2)}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 10.5%: $</strong></td>
                            <td style="float:right;"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 5%: $</strong></td>
                            <td style="float:right;"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 2.5%: $</strong></td>
                            <td style="float:right;"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>IVA 0%: $</strong></td>
                            <td style="float:right;"><strong>0.00</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Importe Otros Tributos: $ </strong></td>
                            <td style="float:right;"><strong> 0.00 </strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Importe Total: $</strong></td>
                            <td style="float:right; font-size:20px;"><strong><strong>{{number_format($total,2)}}</strong></strong></td>
                        </tr>
                    </table>
                </div>
              
        </div>
        <br>
        <div style="margin-top:350px; border:1px solid black;">
            <center>
                "I. V. A. RESPONSABLE INSCRIPTO"
            </center>
        </div>
</div>
<div class="mt-3">
            <img src="{{ public_path('imagenes/imagenAfip.png') }}" width="500">
</div>

</body>
</html>