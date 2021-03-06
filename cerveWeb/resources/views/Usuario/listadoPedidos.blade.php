@extends('templates.template')

@section('content')


@section('content')
 <center>
      <div class="col-md-10 mt-4">
                <div class="card">
                  <div class="card-header">
                        Pedidos de: {{$usuario->apellido}} {{$usuario->nombre}}
                    </div>
                    <div class="card-body">
                            @if(!($pedidos->isEmpty()))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Nro Pedido</th>
                                            <th class="sticky-top bg-light" scope="col">Estado</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha de entrega</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($pedidos as $pedido)    
                                        <tr>
                                            <th scope="row">{{$pedido->id}}</th>
                                            <td>{{$pedido->estado}}</td>
                                            <td>{{$pedido->fecha_entrega}}</td>
                                            <td scope="col">
                                                <center>
                                                    @if($pedido->estado == "pendiente")
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$pedido->id}}">
                                                    Eliminar
                                                    </button>
                                                    @endif
                                                    <button type="button"  class="btn btn-outline-info" data-toggle="modal" data-target="#__{{$pedido->id}}">
                                                    Ver Más
                                                    </button>
                                                </center>                                      
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            @else
                                <h3><div class="col alert alert-info alert-dismissible fade show" role="alert"> <i class="fa fa-info-circle"></i> No hay pedidos realizados</div></h3>
                            @endif
                            </div>
                        </div>    
                    </div>                         
                    </div>
                    <a href="{{route('catalogoCervezas')}}" class="float-center mt-4 btn btn-success">       Agregar
                    </a>
                    @if(session('success'))
                    <div class=" col-md-6 float-left mt-2 alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{session('success')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    @elseif(session('error'))
                    <div class=" col-md-6 float-left mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>{{session('error')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                    @endif
                </div>        
        </center>         
         @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$pedido->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Pedido</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                            <center>
                                Desea Eliminar el pedido? <br>
                                <p hidden>{{$total=0}}</p>
                                <strong>Nro: </strong>{{$pedido->id}}<br>
                                @foreach($pedido->itemsPedidos as $item)
                                    <strong> Cerveza: </strong>{{$item->cerveza->nombre}}<br>
                                    <strong>Cantidad Litros: </strong>{{$item->cantidad}}<br>
                                    <p hidden>{{$total+= $item->cantidad * $item->cerveza->precio}} </p>
                                @endforeach      
                                <strong> Total a abonar: $ </strong>{{number_format($total,2)}}<br>    
                            </center>           
                       </div>

                       <div class="modal-footer">
                           <a href="{{route('deletePedidos',$pedido->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach

         @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="__{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="__{{$pedido->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Datos del Pedido:</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                         <center>
                            <strong>Nro: </strong>{{$pedido->id}}<br> <br>
                            <p hidden>{{$total=0}}</p>
                            @foreach($pedido->itemsPedidos as $item)
                                <br>
                                <strong> Cerveza: </strong>{{$item->cerveza->nombre}}<br> <br>
                                <img style= "height:100px; width:100px" src="{{ $item->cerveza->image }}"> <br> <br>
                                <strong>Cantidad : </strong>{{$item->cantidad}} litros<br>
                                <p hidden>{{$total+= $item->cantidad * $item->cerveza->precio}} </p>
                            @endforeach
                            <hr>
                            
                            <h3>
                            <div class="alert alert-warning" role="alert">
                                <strong> Total a abonar: $ </strong>{{number_format($total,2)}}<br>  
                            </div>                            
                         </center>
                        </div>

                       <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                                                                      
@endsection

@stop