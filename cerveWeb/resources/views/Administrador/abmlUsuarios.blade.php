@extends('templates.templateAdmin')

@section('content')
 <center>
      <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header">
                        Usuarios <i class="fa fa-user"></i>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Apellido</th>
                                            <th class="sticky-top bg-light" scope="col">E-mail</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha-Hora Alta</th>
                                            <th class="sticky-top bg-light" scope="col">Tipo</th>
                                            <th colspan="3" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($usuarios as $usuario)    
                                        <tr>
                                            <th scope="row">{{$usuario->id}}</th>
                                            <td>{{$usuario->nombre}}</td>
                                            <td>{{$usuario->apellido}}</td>
                                            <td>{{$usuario->email}}</td>                                                                              
                                            <td>{{$usuario->created_at->format('d-m-Y H:m:s')}}</td>
                                            <td>{{$usuario->tipo_usuario->descripcion}}</td>
                                            <td scope="col">
                                              @if(isset($usuario->deleted_at))
                                                <button type="button"  class="btn btn-outline-success" data-toggle="modal" data-target="#_{{$usuario->id}}">
                                                <i class="fa fa-check-circle"></i>
                                                </button>
                                              @else
                                               <button type="button"  class="btn btn-outline-danger" data-toggle="modal" data-target="#___{{$usuario->id}}">
                                               <i class="fa fa-times-circle"></i>
                                                </button>
                                              @endif                                          
                                            </td>
                                            <td scope="col">
                                                <a href="{{route('editarUsuario',$usuario->id)}}" class="btn btn-outline-primary">
                                                  <i class="fa fa-pencil square"></i>
                                                </a>                                         
                                            </td>
                                            <td scope="col">
                                              <button type="button"  class="btn btn-outline-info" data-toggle="modal" data-target="#__{{$usuario->id}}">
                                                <i class="fa fa-info-circle" style="font-size:15px"></i>
                                              </button>                                     
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>                         
                    </div>
                    <a href="{{route('agregarUsuario')}}" class="float-right mt-4 btn btn-success ">      <i class="fa fa-plus-circle"></i> Agregar
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
         @foreach($usuarios as $usuario)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$usuario->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Habilitar Usuario</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             ¿Desea habilitar el usuario:<br>
                            <strong>Id: </strong>{{$usuario->id}}<br>
                            <strong>Apellido: </strong>{{$usuario->apellido}}<br>
                            <strong>Nombre: </strong>{{$usuario->nombre}}?<br>                     
                       </div>
                       <div class="modal-footer">
                           <a href="{{route('deleteUsuarios',$usuario->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach
         @foreach($usuarios as $usuario)        
            <!-- Modal -->
             <div class="modal fade" id="___{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="___{{$usuario->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inhabilitar Usuario</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             ¿Desea Inhabilitar el usuario:<br>
                            <strong>Id: </strong>{{$usuario->id}}<br>
                            <strong>Apellido: </strong>{{$usuario->apellido}}<br>
                            <strong>Nombre: </strong>{{$usuario->nombre}}?<br>                     
                       </div>
                       <div class="modal-footer">
                           <a href="{{route('deleteUsuarios',$usuario->id)}}" class="btn btn-primary">Aceptar</a>   
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach
         @foreach($usuarios as $usuario)        
            <!-- Modal -->
             <div class="modal fade" id="__{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="__{{$usuario->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Datos Usuario</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                             <center>
                              Información usuario:<br><hr>
                              
                              @if((($usuario->tipo_usuario->descripcion)=="Administrador") || (($usuario->tipo_usuario->descripcion)=="Operador" ))
                                  <strong>Id: </strong>{{$usuario->id}}<br>
                                  <strong>Apellido: </strong>{{$usuario->apellido}}<br>
                                  <strong>Nombre: </strong>{{$usuario->nombre}}<br>
                                  
                                  <strong>Email: </strong>{{$usuario->email}}<br> 
                                  <strong>Tipo de usuario: </strong>{{$usuario->tipo_usuario->descripcion}}<br> 
                                  @if(isset($usuario->deleted_at))
                                  <strong>Habilitado: </strong>No <br>
                                  @else
                                  <strong>Habilitado: </strong>Si<br>
                                  @endif
                                @else
                                  <strong>Id: </strong>{{$usuario->id}}<br>
                                  <strong>Apellido: </strong>{{$usuario->apellido}}<br>
                                  <strong>Nombre: </strong>{{$usuario->nombre}}<br>
                                  
                                  <strong>Email: </strong>{{$usuario->email}}<br> 
                                  <strong>Tipo de usuario: </strong>{{$usuario->tipo_usuario->descripcion}}<br> 
                                  @if(isset($usuario->deleted_at))
                                  <strong>Habilitado: </strong>No <br>
                                  @else
                                  <strong>Habilitado: </strong>Si<br>
                                  @endif
                                  <strong>Telefono: </strong>{{$usuario->telefono}}<br>
                                  <strong>Cuit/Cuil: </strong>{{$usuario->cuitcuil}}<br>     
                                  <strong>Razon Social: </strong>{{$usuario->razonSocial}}<br>   
                                  <strong>Condición IVA: </strong>{{$usuario->condicionIVA}}<br> 
                                  <strong>Recibe pedidos en : </strong>{{$usuario->direcciónEntrega}}<br>            
                                  @switch($usuario->prioridad)
                                    @case(1)
                                        <strong>Prioridad : </strong>Baja<br>
                                        @break

                                    @case(2)
                                        <strong>Prioridad : </strong>Mediana<br>
                                        @break

                                    @case(3)
                                        <strong>Prioridad : </strong>Alta<br>
                                        @break
                                    @default
                                        <strong>Prioridad : </strong>No aplica<br>
                                  @endswitch
                                @endif
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
@endsection