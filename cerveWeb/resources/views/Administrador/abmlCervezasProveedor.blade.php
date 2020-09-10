@extends('templates.templateAdmin')

@section('content')
 <center>
       <div class="col-md-10 mt-4">
                <div class="card">
                  <div class="card-header">
                        Cervezas que abastece la proveedora {{$proveedor->razonSocial}}
                    </div>
                    <div class="card-body">
                        @if(count($proveedor->productos_cervezas))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Imagen</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Costo x litro</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                          @foreach($proveedor->productos_cervezas as $cervezaProveedor)    
                                          <tr>
                                              <td>
                                                  <center>
                                                  <img src="../{{$cervezaProveedor->image}}" width="40">
                                                  </center>
                                              </td>
                                              <td>{{$cervezaProveedor->nombre}}</td>
                                              <td>{{$cervezaProveedor->pivot->costo}}</td>
                                              <td scope="col">
                                                  <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$cervezaProveedor->id}}">
                                                            <i class="fa fa-trash"></i>
                                                    </button>
                                                    <a href="{{route('editarCervezaProveedor',['idProveedor'=>$proveedor->id,'idCerveza'=>$cervezaProveedor->pivot->id_producto_cerveza])}}" class="btn btn-outline-primary">
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
							<strong><i class="fa fa-info-circle"></i></strong> Este proveedor no tiene cervezas asignadas!
									
                        </div>   
                    </div>                         
                    </div>
                        @endif
                    <hr>
                    <p>
                        <a href="{{route('abmlProveedores')}}" class="btn btn-warning"><i class="fa fa-chevron-circle-left"></i> Volver</a>
                    </p>
                    @if(session('success'))
                    <div class=" col-md-6 float-left mt-2 alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{session('success')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    @endif
                </div>        
        </center>
        @foreach($proveedor->productos_cervezas as $cervezaProveedor)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$cervezaProveedor->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$cervezaProveedor->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Cerveza abastecida por Proveedor</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                       <center>
                             Desea eliminar la siguiente cerveza abastecida ? <br> <br>
                            <strong>Id: </strong>{{$cervezaProveedor->id}}<br> <br>

                            <strong>Nombre: </strong>{{$cervezaProveedor->nombre}}<br> <b></b>
                        
                            <img style= "height:100px; width:100px" src="../{{ $cervezaProveedor->image }}"> <br> <br>

                            <strong>Costo x lt: </strong>{{$cervezaProveedor->pivot->costo}}<br> <br> <br>



                          <strong>
                              <span class="text-danger">La acción no podrá revertirse.</span>
                          </strong>
                       </div>
                       </center>
                       <div class="modal-footer">
                           <a href="{{route('deleteCervezaProveedor',['idProveedor'=>$proveedor->id,'idCerveza'=>$cervezaProveedor->pivot->id_producto_cerveza])}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                                                
@endsection