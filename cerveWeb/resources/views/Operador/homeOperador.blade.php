@extends('templates.templateOperator')

@section('content')
    <div class="container text-center">

        <div class="page-header mt-5">

            <h1 style="color:goldenrod;"><img src="https://img.icons8.com/dusk/60/000000/list.png"/></i> TIENDA DE CERVECERIA ONLINE - OPERACIONES</h1>
        </div>

        <h2 style="color:goldenrod;">Bienvenido(a) {{Auth::user()->nombre}} al Panel de Operaciones diarias de la tienda Online</h2>
        
        <div class="row mt-5">

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/color/60/000000/purchase-order.png"/>
                    <a href="{{route('listadoPedidosEntrega')}}" class="btn btn-warning btn-block btn-home-admin">ENTREGAS PROXIMAS</a>
                </div>
            </div>


            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/fluent/60/000000/partially-shipped.png"/>
                    <a href="#" class="btn btn-warning btn-block btn-home-admin">LOGISTICA</a>
                </div>
            </div>

        </div>
    </div>
    



@endsection
    
