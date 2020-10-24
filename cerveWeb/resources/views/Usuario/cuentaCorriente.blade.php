@extends('templates.template')

@section('content')


<center>
       <div class="col-md-12 mt-4">
       @php
        use Carbon\Carbon;
        @endphp
                <div class="card">
                    <div class="card-header">
                        Cuenta corriente del usuario {{Auth::user()->apellido}} , {{Auth::user()->nombre}}
                    </div>
                    <div class="card-body">
                        @if(!($pedidos->isEmpty()))
                        <div class="alert alert-info col-md-3" role="alert">
                                    <strong> Total deuda: $ </strong>{{number_format($totalAbonar,2)}}<br>  
                        </div>
                        
                            <div class="table-responsive">
                            
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Nro Pedido</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha de entrega</th>
                                            <th class="sticky-top bg-light" scope="col">Monto a abonar</th>
                                            <th colspan="3" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pedidos as $pedido)
                                        
                                                
                                        <tr>
                                            <th scope="row">{{$pedido->id}}</th>
                                            <td>{{Carbon::parse($pedido->fecha_entrega)->format('d-m-Y')}}</td>
                                            <p hidden>{{$total=0}}</p>
                                            @foreach($pedido->itemsPedidos as $item)     
                                                <p hidden>{{$total+= $item->cantidad * $item->cerveza->precio}} </p>
                                            @endforeach
                                            <td class="text-right">{{number_format($total,2)}}</td>
                                            <td scope="col">
                                                <center>
                                                    @if($pedido->estado=="entregado")
                                                    <a href="{{route('verFactura',$pedido)}}" class="btn btn-outline-primary">
                                                        Factura
                                                    </a>
                                                    <a href="{{route('verRemito',$pedido)}}" class="btn btn-outline-warning">
                                                        Remito
                                                    </a>
                                                    @endif
                                                    <button type="button"  class="btn btn-outline-info" data-toggle="modal" data-target="#_{{$pedido->id}}">
                                                    Ver Pedido
                                                    </button>
                                                </center>                                  
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                            @else
                            <h3><div class="col alert alert-info alert-dismissible fade show" role="alert"> <i class="fa fa-info-circle"></i> No hay pedidos con deuda</div></h3>
                    @endif
                    </div>
                    
                </div>        
        </center>

        @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="__{{$pedido->id}}" aria-hidden="true">
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

@stop