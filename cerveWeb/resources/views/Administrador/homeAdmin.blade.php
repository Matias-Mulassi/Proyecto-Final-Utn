@extends('templates.templateAdmin')

@section('content')
    <div class="container text-center">

        <div class="page-header mt-5">

            <h1 style="color:goldenrod;"><img src="https://img.icons8.com/dusk/64/000000/administrative-tools.png"/></i> TIENDA DE CERVECERIA ONLINE - ADMINISTRACIÓN</h1>
        </div>

        <h2 style="color:goldenrod;">Bienvenido(a) {{Auth::user()->nombre}} al Panel de administración de la tienda en linea</h2>
        
        <div class="row mt-5">

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/officel/60/000000/select-users.png"/>
                    <a href="{{route('abmlUsuarios')}}" class="btn btn-warning btn-block btn-home-admin">USUARIOS</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/dusk/60/000000/user-credentials.png"/>
                    <a href="{{route('abmlTiposUsuarios')}}" class="btn btn-warning btn-block btn-home-admin">TIPOS DE USUARIOS</a>
                </div>
            </div>

        </div>
        
        <div class="row mt-5">

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/dotty/60/000000/category.png"/>
                    <a href="{{route('abmlCategorias')}}" class="btn btn-warning btn-block btn-home-admin">CATEGORIAS</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/fluent/60/000000/beer.png"/>
                    <a href="{{route('abmlCervezas')}}" class="btn btn-warning btn-block btn-home-admin">CERVEZAS</a>
                </div>
            </div>

        </div>

        <div class="row mt-5">

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/color/60/000000/purchase-order.png"/>
                    <a href="{{route('blPedidos')}}" class="btn btn-warning btn-block btn-home-admin">PEDIDOS</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel">

                    <img class="home" src="https://img.icons8.com/dusk/60/000000/supplier.png"/>
                    <a href="{{route('abmlProveedores')}}" class="btn btn-warning btn-block btn-home-admin">PROVEEDORES</a>
                </div>
            </div>

        </div>

    </div>
    



@endsection
    
