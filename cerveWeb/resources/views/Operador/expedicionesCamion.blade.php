@extends('templates.templateOperator')

@section('content')
    
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse float-left">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
        @foreach($pedidos as $pedido)
          <li class="nav-item mt-2 mb-2">
            <center>
                <a type="button" class="text-info" data-toggle="modal" data-target="#_{{$pedido->id}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Pedido {{$pedido->id}}
                </a>
            </center>
          </li>
        @endforeach
        </ul>
        <hr>
        <ul class="nav flex-column mb-2 text-center">
          <li class="nav-item">
            <a href="{{route('informeCargaCamion')}}" class="text-info">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Informe cervezas
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <h1 style="color:goldenrod; margin-right:220px;" class="h3 mt-5 font-weight-normal text-center"> Información del camion <img src="https://img.icons8.com/plasticine/80/000000/truck.png"/> </h1>
    @if($litrosTotales!=1500)
    <h4 style="color:goldenrod; margin-right:220px;" class="text-center">(Quedan {{1500-$litrosTotales}} lts de capacidad)</h4>
    @else
    <h4 style="color:goldenrod; margin-right:220px;" class="text-center">(El camión se encuentra lleno!)</h4>
    @endif
     
    <center>
    @if(count($pedidosPostergados)>0)
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>Debido a falta de stock, estos son los pedidos postergados para mañana :</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>
                    @foreach($pedidosPostergados as $number)
                      <h3>Pedido n° {{$number}}</h3>
                    @endforeach                   
        </div>
    @endif
    </center> <br>
    <center>
    @if(count($pedidosPostergadosCapacidad)>0)
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>Debido a exceso de capacidad del camion, estos son los pedidos postergados para mañana :</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>
                    @foreach($pedidosPostergadosCapacidad as $number)
                      <h3>Pedido n° {{$number}}</h3>
                    @endforeach                   
        </div>
    @endif
    </center>


    <center>
    @php
      use Carbon\Carbon;
    @endphp
    @if($litrosTotales==1500 & Carbon::now()->format('H:i:s')>='20:00:00')
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno y no se toman mas pedidos. Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia.Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif($litrosTotales==1500)
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno.Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia. Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif(Carbon::now()->format('H:i:s')>='20:00:00')
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>No se toman más pedidos.Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia. Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    
    </center> <br>
    @endif

    
    @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$pedido->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acciones sobre pedido {{$pedido->id}}</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                            <center>
                            <a href="{{route('mostrarFactura',$pedido->id)}}" class="btn btn-outline-primary">
                                Ver Factura
                            </a>
                            <a href="{{route('mostrarRemito',$pedido->id)}}" class="btn btn-outline-warning">
                                Ver Remito
                            </a>
                            
                            
                            
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

         @if(session('error'))
            <div class=" col-md-6 float-left mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{session('error')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif

        
      
        
        


            <p>
 
              @if(count($pedidos)>0)
              
              <a href="{{route('imprimirFacturas')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-print"></i> Imprimir Facturas</a>
              <a href="{{route('imprimirRemitos')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-print"></i> Imprimir Remitos</a>
              <a href="{{route('hojaRuta')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-print"></i> Hoja de ruta</a>
              @endif
              @if($litrosTotales==1500 || (Carbon::now()->format('H:i:s')>='20:00:00'))
              <a href="{{route('logisticaCamion')}}" class="btn btn-success  btn-lg float-right mr-3 mt-3">Despachar Camión <i class="fa fa-truck"></i></a>
              @endif
              <a href="{{route('listadoPedidosEntrega')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Ver pedidos</a>
              
            </p>



@endsection