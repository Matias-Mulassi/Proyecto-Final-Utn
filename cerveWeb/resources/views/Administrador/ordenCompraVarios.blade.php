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
    


<div>
        <h1 class="display-4 text-center">Orden de compra</h1>
        <hr>

        <div>
            @php
                use Carbon\Carbon;
            @endphp
            <div style="border: 1px solid black;">
                <p class="text-left" style="font-family: Arial, Helvetica, sans-serif; padding:5px;">
                        
                        <strong>Proveedor:</strong> {{$proveedor->razonSocial}}
                </p>
                <p style="font-family: Arial, Helvetica, sans-serif; padding:5px; float:right;">
                        
                    <strong>Fecha Pedido: {{Carbon::now()->format('d-m-Y')}}
                </p>
                <p class="text-left" style="font-family: Arial, Helvetica, sans-serif; padding:5px;">
                        
                        <strong>Solicitó el pedido el SR.:</strong> {{Auth::user()->apellido}}, {{Auth::user()->nombre}}
                </p>

            </div>
        <div>
            <div style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top: 5px;">
                <div>
                    <center>
                    
                   <p> <strong>Producto Requerido: </strong> Cerveza Artesanal  </p>
                   </center>
                </div>
            </div>
            <div style="border: 1px solid black; margin-top:5px;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table mb-0">
                            <thead>
                            <tr class="table-bordered">
                                <th class="sticky-top bg-secondary text-center" style="border:1px solid black;" scope="col">Cantidad</th>
                                <th class="sticky-top bg-secondary text-center" style="border:1px solid black;" scope="col">Descripción</th>
                                <th class="sticky-top bg-secondary text-center" style="border:1px solid black;" scope="col">Costo Unitario</th>
                                <th class="sticky-top bg-secondary text-center" style="border-bottom:1px solid black; border-top:1px solid black;" scope="col">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody style="background-color:white;" class="text-right">
                                    @foreach($cervezas as $cerveza)    
                                        <tr>
                                            <td scope="row" class="text-right" style="border: 1px solid black;">{{$cerveza->loteOptimo}} lts</th>
                                            <td class="text-center" style="border: 1px solid black;">Cerveza {{$cerveza->nombre}}</td>
                                            <p hidden>{{$costoCerveza=0}}</p>
                                            @foreach($proveedor->productos_cervezas as $cervezaProveedor)
                                            
                                                @if($cervezaProveedor->nombre==$cerveza->nombre)
                                                <p hidden>{{${"costoCerveza_".$cerveza->nombre}=$cervezaProveedor->pivot->costo}}</p>
                                                @endif
                                            @endforeach
                                            <td class="text-right" style="border: 1px solid black;">$ {{number_format(${"costoCerveza_".$cerveza->nombre},2)}}</td>
                                            <td class="text-right" style="border-top: 1px solid black; border-bottom: 1px solid black;">$ {{number_format(${"costoCerveza_".$cerveza->nombre} * $cerveza->loteOptimo,2)}}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
            <div style="border: 1px solid black; margin-top:5px;">
                <div style="font-family: Arial, Helvetica, sans-serif;">
                    <table class="table mb-0">
                        <tbody style="background-color:white; border: 0px solid white;">
                            <tr>
                                <td colspan="2">
                                    <strong>FORMA DE PAGO: </strong> CONTADO
                                </td>
                                <td style="border-right: 1px solid black; font-size:25px; padding-top:50px;"></td>
                                <p hidden>{{$total=0}}</p>
                                @foreach($cervezas as $cerveza)
                                <p hidden>{{$total+=${"costoCerveza_".$cerveza->nombre} * $cerveza->loteOptimo}}</p>
                                @endforeach
                                <td class="text-center"  style="font-size:25px;" ><div><strong><p>TOTAL:</strong></p></div><div style="border: 1px solid black; border-radius: 15px;"> <strong>$ {{number_format($total,2)}} </strong></div></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div  style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top:5px;">
                <div class="col">
               
                <p class="p-2" style="margin-left: 20px;"><strong>Fecha de Entrega: </strong>{{Carbon::now()->modify('+1 day')->format('d-m-Y')}}  </p>
                </div>
            </div>
            
        </div>
       
</div>
</body>
</html>