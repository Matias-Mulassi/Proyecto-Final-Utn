@extends('templates.templateAdmin')

@section('content')

<div class="jumbotron">
        <h1 class="display-4 text-center">Orden de compra</h1>
        <hr class="my-4">
        <div class="container">
            <div class="row" style="border: 1px solid black;">
                <div class="col" style="border: 1px solid black;">
                    <p class="text-left" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:0px;">
                           
                            <strong>Proveedor:</strong> {{$proveedor->razonSocial}}
                    </p>
                    <p class="text-left" style="font-family: Arial, Helvetica, sans-serif; margin-bottom:0px;">
                           
                           <strong>Solicitó el pedido el SR.:</strong> {{Auth::user()->apellido}}, {{Auth::user()->nombre}}
                   </p>

                </div>
                <div class="col text-center" style="border: 1px solid black;">
                        
                        <center>
                            <table style="font-family: Arial, Helvetica, sans-serif; border: 1px solid black; margin:10px;">
                                
                                @php
                                    use Carbon\Carbon;
                                @endphp           

                                <tr>
                                    <td colspan="3" class="text-center" style="border: 1px solid black;"><strong> FECHA PEDIDO </strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::now()->day}}</strong></td>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::now()->month}}</strong></td>
                                    <td class="text-center" style="border: 1px solid black;"><strong>{{Carbon::now()->year}}</strong></td>
                                </tr>
                            </table>
                        </center>
                        </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top: 5px;">
                <div class="col p-2">
                   <p style="float:left;"> <strong>Producto Requerido: </strong> Cerveza Artesanal  </p>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; margin-top:5px;">
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
                                        <tr>
                                            <td scope="row" class="text-right" style="border: 1px solid black;">{{$cerveza->loteOptimo}} lts</th>
                                            <td class="text-center" style="border: 1px solid black;">Cerveza {{$cerveza->nombre}}</td>
                                            <p hidden>{{$costoCerveza=0}}</p>
                                            @foreach($proveedor->productos_cervezas as $cervezaProveedor)
                                            
                                                @if($cervezaProveedor->nombre==$cerveza->nombre)
                                                <p hidden>{{$costoCerveza=$cervezaProveedor->pivot->costo}}</p>
                                                @endif
                                            @endforeach
                                            <td class="text-right" style="border: 1px solid black;">$ {{number_format($costoCerveza,2)}}</td>
                                            <td class="text-right" style="border-top: 1px solid black; border-bottom: 1px solid black;">$ {{number_format($costoCerveza * $cerveza->loteOptimo,2)}}</td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
            <div class="row" style="border: 1px solid black;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
                    <table class="table mb-0">
                        <tbody style="background-color:white; border: 0px solid white;">
                            <tr>
                                <td colspan="2">
                                    <strong>FORMA DE PAGO: </strong> CONTADO
                                </td>
                                <td style="border-right: 1px solid black; font-size:25px; padding-top:50px;"> <strong>TOTAL $ </strong></td>
                                
                                <td class="text-center" style="padding-top:50px; font-size:25px;" ><div style="border: 1px solid black; border-radius: 15px;"><strong>$ {{number_format($costoCerveza * $cerveza->loteOptimo,2)}} </strong></div></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col">
                <p class="p-2" style="margin-left: 20px;"><strong>Fecha de Entrega: </strong>{{Carbon::now()->modify('+1 day')->format('d-m-Y')}}  </p>
                </div>
            </div>
            
        </div>
       
    </div>

    <p>

        <a href="{{route('home')}}" class="btn btn-warning btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Volver</a>

    </p>

@endsection