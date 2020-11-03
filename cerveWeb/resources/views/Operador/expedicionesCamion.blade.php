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

    <h1 class="text-center mt-5"  style="color:goldenrod;"><img src="https://img.icons8.com/doodle/48/000000/business-report.png"/></i> SECCIÓN LOGISTICA</h1>
    @if($litrosTotales!=1500)
    <h4 style="color:goldenrod; margin-right:220px;" class="text-center">(Quedan {{1500-$litrosTotales}} lts de capacidad)</h4>
    @else
    <h4 style="color:goldenrod;" class="text-center">(El camión se encuentra lleno!)</h4>
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

        
        <div class="container text-center">

          @if(count($pedidos)>0)
          <div class="row mt-5">


              <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                          <div class="card-body">
                      
                              <h5 class="card-title">Facturas</h5>
                              <hr>
                              <p class="card-text">Imprimir todas las facturas de los pedidos a entregar.</p>
                              <a href="{{route('imprimirFacturas')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-print"></i> Imprimir Facturas</a>
                          </div>
                  </div>
                
              </div>

              <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                          <div class="card-body">
                      
                              <h5 class="card-title">Remitos</h5>
                              <hr>
                              <p class="card-text">Imprimir todas los remitos para respaldar la mercaderia entregada.</p>
                              <a href="{{route('imprimirRemitos')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-print"></i> Imprimir Remitos</a>
                          </div>
                  </div>
                
              </div>

              <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                          <div class="card-body">
                      
                              <h5 class="card-title">Hoja de ruta</h5>
                              <hr>
                              <p class="card-text">Listado con todos los destinos y cantidad a entregar de cada pedido.</p>
                              <a href="{{route('hojaRuta')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-map"></i> Hoja de ruta</a>
                          </div>
                  </div>
                
              </div>

              
          </div>
          @endif
      
        </div>

        @if($litrosTotales==1500 || (Carbon::now()->format('H:i:s')>='20:00:00'))
        <a href="{{route('logisticaCamion')}}" class="btn btn-success  btn-lg float-right mr-3 mt-5">Despachar Camión <i class="fa fa-truck"></i></a>  
        @endif
        <a href="{{route('listadoPedidosEntrega')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Ver pedidos</a>

@endsection