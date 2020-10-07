@extends('templates.templateAdmin')

@section('content')
 <center>
       <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header">
                        Proveedores <i class="fa fa-provideer"></i>
                    </div>
                    <div class="card-body">
                        @if(count($proveedores))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Cuit</th>
                                            <th class="sticky-top bg-light" scope="col">Razon Social</th>
                                            <th class="sticky-top bg-light" scope="col">E-mail</th>
                                            <th class="sticky-top bg-light" scope="col">Telefono</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($proveedores as $proveedor)    
                                        <tr>
                                            <th scope="row">{{$proveedor->id}}</th>
                                            <td>{{$proveedor->cuit}}</td>
                                            <td>{{$proveedor->razonSocial}}</td>
                                            <td>{{$proveedor->email}}</td>
                                            <td>{{$proveedor->telefono}}</td>
                                            <td scope="col">
                                                <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$proveedor->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button> 
                                                    <a href="{{route('editarProveedor',$proveedor->id)}}" class="btn btn-outline-primary">
                                                        <i class="fa fa-pencil square"></i>
                                                    </a>
                                                    <a href="{{route('asignarCerveza',$proveedor->id)}}" class="btn btn-outline-warning">
                                                        <i class="fa fa-beer"></i>
                                                    </a>
                                                    <a href="{{route('abmlCervezasProveedores',$proveedor->id)}}" class="btn btn-outline-info">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                </center>                                      
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>
                    @else
                    <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay proveedores registrados en CerveWeb!
									
                    </div>
                    @endif               
                    </div>
                    <a href="{{route('agregarProveedor')}}" class="float-right mt-4 btn btn-success ">      <i class="fa fa-plus-circle"></i> Agregar
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
         @foreach($proveedores as $proveedor)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$proveedor->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$proveedor->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Proveedor</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             Desea eliminar el Proveedor:<br>
                            <strong>Id: </strong>{{$proveedor->id}}<br>

                            <strong>Cuit: </strong>{{$proveedor->cuit}}<br>
                        
                            <strong>Razon Social: </strong>{{$proveedor->razonSocial}}<br>

                            <br>


                          <strong>
                              <span class="text-danger">La acción no podrá revertirse.</span>
                          </strong>
                       </div>
                       <div class="modal-footer">
                           <a href="{{route('deleteProveedor',$proveedor->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                                                  
@endsection