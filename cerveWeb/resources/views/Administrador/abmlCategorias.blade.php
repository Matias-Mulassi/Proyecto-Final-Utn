@extends('templates.templateAdmin')

@section('content')
 <center>
       <div class="col-md-10 mt-4">
                <div class="card">
                  <div class="card-header">
                        Categorias <i class="fa fa-list"></i>
                    </div>
                    <div class="card-body">
                        @if(count($categorias)>0)
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Descripcion</th>
                                            <th colspan="2" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($categorias as $categoria)    
                                        <tr>
                                            <th scope="row">{{$categoria->id}}</th>
                                            <td>{{$categoria->nombre}}</td>
                                            <td>{{$categoria->descripcion}}</td>
                                            <td scope="col">
                                                <center>
                                                    <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#_{{$categoria->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button> 
                                                    <a href="{{route('editarCategoria',$categoria->id)}}" class="btn btn-outline-primary">
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
							<strong><i class="fa fa-info-circle"></i></strong> No hay categorias en toda CerveWeb!
									
                        </div>    
                    </div>                         
                    </div>
                    @endif
                    <a href="{{route('agregarCategoria')}}" class="float-right mt-4 btn btn-success ">      <i class="fa fa-plus-circle"></i> Agregar
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
         @foreach($categorias as $categoria)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$categoria->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Categoria</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             Desea eliminar la Categoria:<br>
                            <strong>Id: </strong>{{$categoria->id}}<br>

                            <strong>Nombre: </strong>{{$categoria->nombre}}<br>
                        
                            <strong>Descripción: </strong>{{$categoria->descripcion}}<br>

                            <br>


                          <strong>
                              <span class="text-danger">La acción no podrá revertirse.</span>
                          </strong>
                       </div>
                       <div class="modal-footer">
                           <a href="{{route('deleteCategoria',$categoria->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach                                                  
@endsection