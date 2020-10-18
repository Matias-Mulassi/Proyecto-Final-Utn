@extends('templates.template')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
@section('content')
<div class="container text-center">
    <div class="page-header">
    <h1><i class="fa fa-shopping-cart"></i>Detalle de la cerveza</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="cerveza-bloque">
                <img src="../{{$cerveza->image}} ">
            </div>
        </div>
        <div class="col-md-6">
            <div class="cerveza-bloque">
                <h3>{{$cerveza->nombre}}</h3><hr>
                <div class="cerveza-info panel">
                    <p>{{$cerveza->descripcion}}</p>
                    <h3>
                        <span class="span label-success">Precio: $ {{number_format($cervezaController->getUltimoPrecio($cerveza->id),2)}}</span>
                     </h3>
                    <p>
                        <a class="btn btn-warning btn-block" href="{{ route('agregarItemCarrito',$cerveza->id) }}">Añadir al carrito <i class="fa fa-cart-plus fa-2x"></i></a>
                    </p>

                </div>
            
            </div>
        </div>
    </div>
    <hr>
    <p>
        <a class="btn btn-primary" style="margin-bottom: 30px;" href="{{ route('catalogoCervezas') }}"><i class="fa fa-chevron-circle-left"></i> Regresar</a>
    </p>
</div>
@stop