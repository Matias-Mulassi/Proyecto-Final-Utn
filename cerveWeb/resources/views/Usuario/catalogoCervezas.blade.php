@extends('templates.template')
@section('content')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
@include('partials.slider')  

<div class="container text-center">
    <div id="cervezas">
        @foreach($cervezas as $cerveza)
            <div class="cerveza white-panel">
                <h3>{{$cerveza->nombre}}</h3><hr>
                <img src="{{$cerveza->image}}" width="250">
                <div class="cerveza-info panel">
                    <p> Precio x litro: ${{number_format($cervezaController->getUltimoPrecio($cerveza->id),2)}}</p>
                    <p>
                        <a class="btn btn-warning" href="{{ route('agregarItemCarrito',$cerveza->id) }}"><i class="fa fa-cart-plus"></i> Adquirir</a>
                        <a class="btn btn-primary" href="{{ route('cerveza-detalle',$cerveza->id) }}"><i class="fa fa-chevron-circle-right"></i> Ver Mas Info</a>

                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop