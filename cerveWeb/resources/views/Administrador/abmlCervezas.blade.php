@extends('templates.templateAdmin')

@section('content')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
 <center>
       <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header">
                        Cervezas <i class="fa fa-beer"></i>
                    </div>
                    <div class="card-body">
                        @if(count($cervezas))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0 text-center">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Imagen</th>
                                            <th class="sticky-top bg-light" scope="col">Descripcion</th>
                                            <th class="sticky-top bg-light" scope="col">Venta Limite</th>
                                            <th class="sticky-top bg-light" scope="col">Desperdicio</th>
                                            <th class="sticky-top bg-light" scope="col">Precio x lt</th>
                                            <th class="sticky-top bg-light" scope="col">Stock Disponible</th>
                                            <th class="sticky-top bg-light" scope="col">Punto Pedido</th>
                                            <th class="sticky-top bg-light" scope="col">Categoria</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($cervezas as $cerveza)    
                                        <tr>
                                            <th scope="row">{{$cerveza->id}}</th>
                                            <td>{{$cerveza->nombre}}</td>
                                            <td>
                                                <center>
                                                <img src="{{$cerveza->image}}" width="40">
                                                </center>
                                            </td>
                                            <td>{{$cerveza->descripcion}}</td>
                                            <td class="text-center">{{$cerveza->ventaLimite}}</td>
                                            <td class="text-center">% {{$cerveza->desperdicio *100}}</td>
                                            <td width="200">
                                            <form method="POST" action="{{ route('updateprecioCervezaManual',$cerveza->id) }}">
                                            @csrf
                                            <input size=40 style="float:left; width:100px" class="form-control @error('precio') is-invalid @enderror text-center"
                                                type="number"
                                                step="any"
                                                name="precio"
                                                value="{{$cervezaController->getUltimoPrecio($cerveza->id)}}"
                                                id="cerveza_{{$cerveza->id}}"
                                                >                                                
                                                <button style="float:left;"class="btn btn-warning btn-update-item ml-2"><i class="fa fa-refresh"></i></button> 
                                                 
                                                </form>
                                            
                                            </td>
                                            <td class="text-center">{{$cerveza->cantidadStock}}</td>
                                            <td class="text-center">{{$cerveza->puntoPedido}}</td>
                                            <td>{{$cerveza->categoria->nombre}}</td>
                                            <td scope="col">
                                                <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$cerveza->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                            </td>
                                                </center>
                                            <td scope="col">
                                                <center> 
                                                    <a href="{{route('editarCerveza',$cerveza->id)}}" class="btn btn-outline-primary">
                                                        <i class="fa fa-pencil square"></i>
                                                    </a>
                                                </center>                                      
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay cervezas en toda CerveWeb!
									
                        </div>    
                    </div>                         
                    </div>
                    @endif              
                    @if(count($cervezas)>0)
                        <a href="{{route('cambioprecioCervezas')}}" class="float-right mt-4 btn btn-danger"> Aumentar Precios</a>
                    @endif
                    <a href="{{route('agregarCerveza')}}" class="float-right mt-4 mr-2 btn btn-success ">      <i class="fa fa-plus-circle"></i> Agregar
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
         @foreach($cervezas as $cerveza)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$cerveza->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$cerveza->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Cerveza</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                           <center>
                             Desea eliminar la Cerveza:<br><hr>
                            <strong>Id: </strong>{{$cerveza->id}}<br> <br>

                            <strong>Nombre: </strong>{{$cerveza->nombre}}<br> <br>
                        
                            <strong>Descripción: </strong>{{$cerveza->descripcion}}<br> <br><br>


                            <strong>Precio x lt: </strong>{{$cervezaController->getUltimoPrecio($cerveza->id)}}<br> <br>
                            <br>


                          <strong>
                              <span class="text-danger">La acción no podrá revertirse.</span>
                          </strong>
                       </div>
                       </center>
                       <div class="modal-footer">
                           <a href="{{route('deleteCerveza',$cerveza->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                                                  
@endsection