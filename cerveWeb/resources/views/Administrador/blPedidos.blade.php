@extends('templates.templateAdmin')

@section('content')
 <center>
      <div class="col-md-10 mt-4">
                <div class="card">
                  <div class="card-header">
                  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
                        Pedidos <i class='fas fa-clipboard-list'></i>
                    </div>
                    <div class="card-body">
                        @if(count($pedidos))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha Solicitado</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha Entrega</th>
                                            <th class="sticky-top bg-light" scope="col">Estado</th>
                                            <th class="sticky-top bg-light" scope="col">Usuario</th>
                                            <th class="sticky-top bg-light" scope="col">Total</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                           @foreach($pedidos as $pedido)
                                           <p hidden>{{$total=0}}</p>
                                        <tr>
                                            <th scope="row">{{$pedido->id}}</th>
                                            <td>{{$pedido->created_at->format('d-m-Y H:m:s')}}</td>
                                            <td>{{$pedido->fecha_entrega}}</td>
                                            <td>{{$pedido->estado}}</td>                                                                              
                                            <td>{{$pedido->usuario->nombre}} , {{$pedido->usuario->apellido}} </td>
                                            @foreach($pedido->itemsPedidos as $item)
                                                <p hidden>{{$total+=$item->cantidad * $item->cerveza->precio}}</p>
                                            @endforeach
                                            <td>$ {{number_format($total,2)}}</td>
                                            <td scope="col">
                                            <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$pedido->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </td>
                                            </center>
                                            <td scope="col">
                                              <button type="button"  class="btn btn-outline-info" data-toggle="modal" data-target="#__{{$pedido->id}}">
                                                <i class="fa fa-info-circle" style="font-size:15px"></i>
                                              </button>                                     
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay pedidos en toda CerveWeb!
									
                        </div>
                        
                    </div>                         
                    </div>
                    @endif
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
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Pedido :</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                        <center>
                        <span >Desea eliminar el pedido nro. {{$pedido->id}} registrado a nombre de
                        {{$pedido->usuario->nombre}} {{$pedido->usuario->apellido}}, con estado <strong>{{$pedido->estado}}</strong>?    
                        </span> <br> <br>
                        <strong>
                                <span class="text-danger">La acción no podrá revertirse.</span>
                            </strong>
                        </div>
                       </center>
                       <div class="modal-footer">
                           <a href="{{route('deletePedidos2',$pedido->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach
         </center>
         @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="__{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="__{{$pedido->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle Pedido :</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                            <center>
                                <p hidden>{{$total=0}}</p>
                                <strong>Nro: </strong>{{$pedido->id}}<br> <hr>
                                <div class="table-responsive">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th class="sticky-top bg-light" scope="col">Imagen</th>
                                                <th class="sticky-top bg-light" scope="col">Cerveza</th>
                                                <th class="sticky-top bg-light" scope="col">Cantidad lts</th>
                                                <th class="sticky-top bg-light" scope="col">Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pedido->itemsPedidos as $item)
                                                <tr>
                                                    <th scope="row"><img style= "height:100px; width:100px" src="{{ $item->cerveza->image }}"></th>
                                                    <td>{{$item->cerveza->nombre}}</td>
                                                    <td>{{$item->cantidad}} litros</td>
                                                    <td>${{number_format($item->cerveza->precio * $item->cantidad,2)}}</td>
                                                    <p hidden>{{$total+=$item->cantidad * $item->cerveza->precio}}</p>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                
                                <h3>
                                <div class="alert alert-warning" role="alert">
                                    <strong> Total a abonar: $ </strong>{{number_format($total,2)}} 
                                </div>
                                <h3>
                                <div class="alert alert-info" role="alert">
                                    <strong> Dirección de entrega: </strong>{{$pedido->usuario->direcciónEntrega}} 
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
         </center>                          
@endsection