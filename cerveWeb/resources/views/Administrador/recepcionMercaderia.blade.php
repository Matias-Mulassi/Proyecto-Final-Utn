@extends('templates.templateAdmin')

@section('content')
@php
use Carbon\Carbon;
use App\Http\Controllers\PedidoController;
$pedidoController = new PedidoController();
@endphp

<div class="container" style="margin:15px auto;">

<center>
    <nav class="col-md-8 navbar navbar-light text-center mt-4 bg-light">
    <a class="navbar-brand">¿Desea consultar alguna compra a un proveedor en particular?</a>
    <form class="form-inline" action="{{ route('buscarCompraProveedor') }}">
        <input name="razonSocial" class="form-control mr-sm-2" type="search" placeholder="Proveedor" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    </nav>
</center>
    
    <div class="col-md-11 mt-3">
                  <div class="card">
                      <div class="card-header">
                         
                         <h3 class="text-center">Seguimiento ultimas compras realizadas</h3>
                          
                      </div>
                      <div class="card-body">
                          
                              
                              <div class="table-responsive">
                                  
                                      <table class="table table-bordered table-striped mb-0">
                                          <thead>
                                        
                                          <tr>
                                              <th class="sticky-top bg-light text-center" scope="col">Fecha</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Proveedor</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Detalle</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Cantidad (lts)</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Total</th>
                                              <th class="sticky-top bg-light" scope="col"></th>
                                              
                                          </tr>
                                          </thead>
                                          <tbody>
                                            @foreach($compras as $compra)


                                            <tr>
                                                <th class="text-left"scope="row">{{Carbon::parse($compra->fecha)->format('d-m-Y')}}</th>
                                                <td class="text-left">{{$compra->proveedor->razonSocial}}</td>
                                                <td class="text-left">{{$compra->cerveza->nombre}}</td>
                                                <td class="text-right">{{$compra->cantidad}} lts</td>
                                                <td class="text-right">{{number_format($compra->total,2)}}</td>
                                                <td scope="col">
                                                    <center>
                                                        <button type="button"  class="btn btn-outline-success" data-toggle="modal" data-target="#_{{$compra->id}}">
                                                            Recibida
                                                        </button> 
                                                        
                                                    </center>                                      
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                          </tbody>
                                  </table>
                            
                              </div>
                          
                                            
                          
                      </div>                         
                  </div>
              
                </div>
    


</div>


@foreach($compras as $compra)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$compra->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$compra->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ingreso Mercaderia</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             Confirma el ingreso de la siguiente mercaderia? <br> <br>
                            <strong>Cerveza: </strong>{{$compra->cerveza->nombre}}<br> <br>

                            <strong>Cantidad: </strong>{{$compra->cantidad}} lts<br> <br>
                        
                            <strong>Proveedor: </strong>{{$compra->proveedor->nombre}}<br> <br>

                             <p class="text-center"> Compra realizada el {{$pedidoController->traducirDia(Carbon::parse($compra->fecha)->format('l'))}} {{Carbon::parse($compra->fecha)->format('d-m-Y')}}
                             </p>

                          <strong>
                            <center>
                                <span class="text-danger text-center">La acción no podrá revertirse.</span>
                            </center>
                          </strong>
                       </div>
                       <div class="modal-footer">
                           <a href="#" class="btn btn-primary">Confirmar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                          


@endsection