@extends('templates.template')

@section('content')

    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fa fa-shopping-cart"></i> Detalle del Pedido</h1><hr>
        </div>

        <div class="page" style="background: #fff;">
            <div class="table-responsive">
                <h3 style="color: goldenrod;">Datos del Usuario</h3>
                <table class="table table-striped table-hover table-bordered">
                    <tr><td>Nombre</td><td>{{Auth::user()->nombre . " ".Auth::user()->apellido}}</td></tr>
                    <tr><td>E-mail</td><td>{{Auth::user()->email}}</td></tr>
                    <tr><td>Cuit/Cuil</td><td>{{Auth::user()->cuitcuil}}</td></tr>
                    <tr><td>Razon Social: </td><td>{{Auth::user()->razonSocial}}</td></tr>
                    <tr><td>Condición IVA: </td><td>{{Auth::user()->condicionIVA}}</td></tr>
                    <tr><td>Dirección Entrega: </td><td>{{Auth::user()->direcciónEntrega}}</td></tr>

                </table>
            </div>
            <div class="table-responsive mb-3">
                <h3 style="color: goldenrod;">Datos del Pedido</h3>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>Producto</th>
                        <th>Precio x lt</th>
                        <th>Cantidad</th>
                        <th>SubTotal</th>
                    </tr>
                    @foreach($carrito as $item)
                        <tr>
                            <td>{{$item->nombre}}</td>
                            <td>${{number_format($item->precio,2)}}</td>
                            <td>{{$item->cantidad}}</td>
                            <td>${{number_format($item->precio * $item->cantidad,2)}}</td>
                        </tr>
                    @endforeach
                </table><hr>

                <h3>
                    <div class="alert alert-success" role="alert">
                        Total: ${{number_format($total,2)}}
                    </div>
                </h3><hr>

                <h3>
                    <div class="alert alert-info" role="alert">
                        @php
                        use Carbon\Carbon;
                        @endphp
                        Fecha Entrega Pedido: {{Carbon::parse($fechaEntrega)->format('d-m-Y')}}
                    </div>
                </h3><hr>

                <p>
                    <a href="{{route('mostrarCarrito')}}" class="btn btn-primary"> <i class="fa fa-chevron-circle-left"></i> Regresar</a>

                    <a href="{{route('pago')}}" class="btn btn-warning"> Pagar con <i class="fa fa-paypal fa-2x"></i></a> 

                    <a href="{{route('registroSinPago',$fechaEntrega)}}" class="btn btn-warning"> Realizar Pedido sin Abonar </a>                  
                </p>
            </div>
        </div>

    </div>

@stop