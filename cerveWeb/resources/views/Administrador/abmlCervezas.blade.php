@extends('templates.templateAdmin')

@section('content')
 <center>
       <div class="col-md-10 mt-4">
                <div class="card">
                  <div class="card-header">
                        Cervezas <i class="fa fa-beer"></i>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Descripcion</th>
                                            <th class="sticky-top bg-light" scope="col">Precio x lt</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($cervezas as $cerveza)    
                                        <tr>
                                            <th scope="row">{{$cerveza->id}}</th>
                                            <td>{{$cerveza->nombre}}</td>
                                            <td>{{$cerveza->descripcion}}</td>
                                            <td>{{$cerveza->precio}}</td>
                                            <td scope="col">
                                                <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$cerveza->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button> 
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
                    </div>                         
                    </div>
                    <a href="{{route('agregarCerveza')}}" class="float-right mt-4 btn btn-success ">      <i class="fa fa-plus-circle"></i> Agregar
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
                             Desea eliminar la Cerveza:<br>
                            <strong>Id: </strong>{{$cerveza->id}}<br>

                            <strong>Nombre: </strong>{{$cerveza->nombre}}<br>
                        
                            <strong>Descripción: </strong>{{$cerveza->descripcion}}<br>

                            <strong>Precio x lt: </strong>{{$cerveza->precio}}<br>
                            <br>


                          <strong>
                              <span class="text-danger">La acción no podrá revertirse.</span>
                          </strong>
                       </div>
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