@extends('templates.template')
@section('content')

    <div class="container text-center">
        <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i>Carrito de Compras</h1>
        </div> 
        <div class="table-cart">
            @if(count($carrito))
            <p>
                <a href="{{route('vaciarCarrito')}}" class="btn btn-danger">Vaciar Carrito <i class="fa fa-trash"></i></a>
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad en Litros</th>
                            <th>Subtotal</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrito as $item)
                            <tr>
                                <td><img src="{{$item->image}}"></td>
                                <td>{{$item->nombre}}</td>
                                <td>$ {{number_format($item->precio,2)}}</td>
                                <td>
                                    <input 
                                        type="number"
                                        min="1"
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
                                <td>$ {{number_format($item->precio * $item->cantidad,2)}}</td>
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
                    Total: ${{number_format($total,2)}}
                </div>
                </h3>
            </div>
            @else
            <h3><span class="label label-warning">No hay cervezas en el carrito</span></h3>
            @endif
            <hr>
            <p>
                <a href="{{route('catalogoCervezas')}}" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i>Seguir Comprando</a>

                <a href="#" class="btn btn-primary">Continuar <i class="fa fa-chevron-circle-right"></i></a>
            </p>
        </div>
    </div>
@stop