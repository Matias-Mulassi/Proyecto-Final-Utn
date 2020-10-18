@extends('templates.template')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
@section('content')

    <div class="container text-center">
        <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i>Carrito de Compras</h1>
        </div> 
        <form method="POST" action="{{ route('detallepedido') }}">
        @csrf
        <div class="table-cart">
            @if(count($carrito))
            <p>
                <a href="{{route('vaciarCarrito')}}" class="btn btn-danger">Vaciar Carrito <i class="fa fa-trash"></i></a>
            </p>
            <p>
                <label for="validationDefault03" class="text-left">Fecha Entrega Pedido: </label>
                <input type="date" name="fechaPedido" id="fechaPedido" value="{{ old('fechaPedido') }}" class="form-control @error('fechaPedido') is-invalid @enderror" required>
                @error('fechaPedido')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio final x lt</th>
                            <th>Cantidad en Litros</th>
                            <th>Subtotal</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrito as $item)
                        <p hidden>{{$precioCerveza=$cervezaController->getUltimoPrecio($item->id)}}</p>
                            <tr>
                                <td><img src="{{$item->image}}"></td>
                                <td>{{$item->nombre}}</td>
                                <td>$ {{number_format($precioCerveza,2)}}</td>
                                <td>
                                    <input 
                                        type="number"
                                        min="1"
                                        max="60"
                                        step="1"
                                        pattern="\d*"
                                        value="{{$item->cantidad}}"
                                        id="cerveza_{{$item->id}}"
                                        >
                                        <a 
                                            href="#" class="btn btn-warning btn-update-item"
                                            data-href="{{route('updateItemCarrito',$item->id)}}"
                                            data-id="{{$item->id}}"
                                            >
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                </td>
                                <td>$ {{number_format($precioCerveza * $item->cantidad,2)}}</td>
                                <td>
                                    <a href="{{ route('eliminarItemCarrito',$item->id) }}" class="btn btn-danger">
                                    <i class="fa fa-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table><hr>
                <h3><div class="alert alert-success" role="alert">
                    Total a pagar: ${{number_format($total,2)}}
                </div>
                </h3>
            </div>
            @else
            <h3><span class="label label-warning">No hay cervezas en el carrito</span></h3>
            @endif
            <hr>
            @if(session('error'))
                <div class=" col-md-6 float-left mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{session('error')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            @endif
            <p>
                <a href="{{route('catalogoCervezas')}}" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i>Seguir Comprando</a>

             <button class="btn btn-primary">Continuar <i class="fa fa-chevron-circle-right"></i></button> 
            </p>
        </div>
        </form>
    </div>
@stop