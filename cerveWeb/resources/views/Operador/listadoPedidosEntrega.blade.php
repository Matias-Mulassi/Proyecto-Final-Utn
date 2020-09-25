@extends('templates.templateOperator')

@section('content')
    <center>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
                <h1 style="color:goldenrod;" class="h3 mt-5 font-weight-normal">Pedidos con fecha de entrega {{$nombreDia}}, {{$fechaMañana}} <i class='fas fa-clipboard-list'></i></h1>
                     

        
        @if(count($pedidos)>0)
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <strong>¿Procesar pedidos de acuerdo al orden explicitado en la lista siguiente?</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span> </button>
                    <p class="text-right">
                    <button type="button" class="btn btn-outline-danger btn mr-2" data-dismiss="alert" arial-label="Close"><span aria-hidden="true"></span><i class="fa fa-times"></i></button>
                    <a href="{{ route('procesarTodosPedidos') }}" class="btn btn-outline-success btn" data-dismiss="modal"><i class="fa fa-check"></i></a>
                    </p>
        </div>
        @endif
        <br>
        @if(session('error'))
            <div class=" col-md-6 mt-2 mb-3 alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{session('error')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-md-10 mt-4">
            <div class="card text-center mt-5">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('listadoPedidosEntrega')}}">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('mostrarCamion')}}">Camión</a>
                </li>
                </ul>
            </div>
            <div class="card-body">
                @if(count($pedidos)>0)
                <div class="row">
                    <div class="col-4">
                        <div class="list-group" id="list-tab" role="tablist">
                        <p hidden>{{$c=0}}</p>
                        @foreach($pedidos as $pedido)
                            @if($c==0)
                            <a class="list-group-item list-group-item-action active" id="list-first-list" data-toggle="list" href="#_{{$pedido->id}}" role="tab" aria-controls="{{$pedido->id}}">Pedido {{$pedido->id}}</a>
                            <p hidden>{{$c=$c+1}}</p>
                            @else
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#__{{$pedido->id}}" role="tab" aria-controls="list-messages-list">Pedido {{$pedido->id}}</a>
                           
                            @endif
                        @endforeach
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="tab-content" id="nav-tabContent">
                        <p hidden>{{$c=0}}</p>
                        @foreach($pedidos as $pedido)
                            @if($c==0)
                            <div class="tab-pane fade show active" id="_{{$pedido->id}}" role="tabpanel" aria-labelledby="list-first-list">
                            
                            
                            <div class="jumbotron">
                                <h1 class="display-4">Información Pedido {{$pedido->id}}</h1>
                                <p class="lead">Pedido realizado por {{$pedido->usuario->apellido}} {{$pedido->usuario->nombre}}.</p>
                                <hr class="my-4">
                                    <div class="card-group">
                                    <div class="col-md-12">
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                            @foreach($pedido->itemsPedidos as $item)
                                                <div class="card">
                                                    <center>
                                                    <img src="{{$item->cerveza->image}}" width="200">
                                                    </center>
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{$item->cerveza->nombre}}</h5>
                                                        <p class="card-text">Cantidad Solicitada: {{$item->cantidad}} Lts</p>
                                                        <p class="card-text"><small class="text-muted"> <strong style="color:red;"> Stock Disponible: </strong> <strong style="color:green;"> {{$item->cerveza->cantidadStock}}</strong> </small></p>
                                                    </div>
                                                </div>                        
                                            @endforeach
                                        </div>
                                    </div>
                                    </div>

                            </div>
                            <a class="btn btn-warning btn-lg mt-5 float-right" href="{{route('controlStock',$pedido->id)}}" role="button">Procesar Pedido</a>                            
                            
                            </div>
                            <p hidden>{{$c=$c+1}}</p>
                            @else
                            <div class="tab-pane fade" id="__{{$pedido->id}}" role="tabpanel" aria-labelledby="list-messages-list">
                                
                            <div class="jumbotron">
                                <h1 class="display-4">Información Pedido {{$pedido->id}}</h1>
                                <p class="lead">Pedido realizado por {{$pedido->usuario->apellido}} {{$pedido->usuario->nombre}}.</p>
                                <hr class="my-4">
                                    <div class="card-group">
                                    <div class="col-md-12">
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                            @foreach($pedido->itemsPedidos as $item)
                                                <div class="card">
                                                    <center>
                                                    <img src="{{$item->cerveza->image}}" width="200">
                                                    </center>
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{$item->cerveza->nombre}}</h5>
                                                        <p class="card-text">Cantidad Solicitada: {{$item->cantidad}} Lts</p>
                                                        <p class="card-text"><small class="text-muted"> <strong style="color:red;"> Stock Disponible: </strong> <strong style="color:green;"> {{$item->cerveza->cantidadStock}}</strong> </small></p>
                                                    </div>
                                                </div>                        
                                            @endforeach
                                        </div>
                                    </div>
                                    </div>
                                
                            </div>
                            <a class="btn btn-warning btn-lg mt-5 float-right" href="{{route('controlStock',$pedido->id)}}" role="button">Procesar Pedido</a>
                            </div>
                           
                            @endif
                       @endforeach
                        </div>
                    </div>
                </div>
                @if(session('success'))
                    <div class=" col-md-6 float-left mt-2 alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{session('success')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                @endif
            @else
            <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-info-circle"></i></strong> No hay pedidos pendientes de entrega por el momento!
                            
            </div>
            @endif
            </div>
            </div>
        </div>
    </center>

    <p>
 

        <a href="{{route('home')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Menu Principal</a>

    </p>







@endsection