@extends('templates.templateOperator')

@section('content')

    <div class="jumbotron">
        <h1 class="display-4 text-center">Remito</h1>
        <hr class="my-4">
        <div class="container">
            <div class="row" style="border: 1px solid black;">
                <div class="col" style="border: 1px solid black;">
                    <img style="float:left;" src="{{ asset('imagenes/logo.png') }}" class="avatar" width="100">
                    <h3 style="font-family: Arial, Helvetica, sans-serif; float:left; margin-top:35px;"><strong> CERVEWEB SA.</strong></h3> <br>
                    <p class="text-center" style="font-family: Arial, Helvetica, sans-serif; margin-top:160px; margin-bottom:0px;">
                           
                            <strong>I.V.A.  Responsable Inscripto</strong>
                    </p>

                </div>
                <div class="col" style="border: 1px solid black;">
                    <div class="row" style="font-family: Arial, Helvetica, sans-serif;">
                            @php
                                use Carbon\Carbon;
                            @endphp
                        <div class="col text-left">
                        <h3 style="font-family: Arial, Helvetica, sans-serif; margin-top:20px;"><strong> REMITO: </strong></h3>
                        <p>
                            <Strong>Fecha:</Strong> {{Carbon::parse($pedido->fecha_facturacion)->format('d-m-Y')}} <br>
                            <Strong>CUIT :</Strong> 30-76545678-7<br>
                            <Strong>Ing. Brutos: </Strong>30-76545678-7 <br>

                        </p>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col p-2" style="border-right: 1px solid black;">
                   <p style="float:left;"> <strong>Señor(es): </strong> {{$pedido->usuario->razonSocial}} </p>
                </div>
                <div class="col p-2" >
                    <p><strong>Domicilio: </strong> {{$pedido->usuario->direcciónEntrega}}, Rosario - Santa Fe</p>             
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif; margin-top: 5px;">
                <div class="col-md-1 p-2" style="border-right: 1px solid black;">
                   <p style="float:left;"> <strong>I V A </strong> </p>
                </div>
                <div class="col-md-6 p-2" style="border-right: 1px solid black;">
                @if($pedido->usuario->condicionIVA=="Responsable Inscripto")
                   <p style="float:left; margin-left:20px;"> <strong> Resp. Inscrip. </strong></p>
                   <s><p style="float:right; margin-right:30px;"><strong> Resp. No Inscrip. </strong></s>
                @else
                <s><p style="float:left; margin-left:20px;"> <strong> Resp. Inscrip. </strong></s>
                <p style="float:right; margin-right:30px;"><strong> Resp. No Inscrip. </strong>
                @endif
                </div>
                
                <div class="col p-2" >
                    <p><strong>C.U.I.T.: </strong> {{$pedido->usuario->cuitcuil}}</p>             
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col">
                    <p class="p-2"><strong>Documento no válido como factura</strong> </p>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; margin-top:5px;">
                <div class="table-responsive" style="font-family: Arial, Helvetica, sans-serif;">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table mb-0">
                            <thead>
                            <tr class="table-bordered">
                                <th class="sticky-top bg-secondary text-center" scope="col">Cantidad</th>
                                <th class="sticky-top bg-secondary text-center" scope="col">Detalle</th>
                            </tr>
                            </thead>
                            <tbody style="background-color:white; border: 0px solid white;" class="text-right">
                                @foreach($pedido->itemsPedidos as $item)    
                                    <tr>
                                        <td scope="row">{{$item->cantidad}} lts</th>
                                        <td class="text-center">Cerveza {{$item->cerveza->nombre}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col">
                <p class="p-2" style="margin-left: 20px;"><strong>RECIBÍ CONFORME: </strong> </p>
                </div>
            </div>
            <div class="row" style="border: 1px solid black; font-family: Arial, Helvetica, sans-serif;">
                <div class="col">
                <p class="p-2" style="margin-left: 20px;"><strong>Fecha de entrega:   </strong>  {{Carbon::parse($pedido->fecha_entrega)->format('d-m-Y')}}</p>
                </div>
            </div>
            
        </div>
       
    </div>

    <p>

        <a href="{{route('expedicionCamion')}}" class="btn btn-warning btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Volver</a>

    </p>

@endsection