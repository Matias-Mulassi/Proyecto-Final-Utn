@extends('templates.templateAdmin')

@section('content')
 <center>
       <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header">
                        Stock Cervezas <i class="fa fa-beer"></i>
                </div>
                    <div class="card-body">
                        @if(count($cervezas))
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Id</th>
                                            <th class="sticky-top bg-light" scope="col">Nombre</th>
                                            <th class="sticky-top bg-light" scope="col">Imagen</th>
                                            <th class="sticky-top bg-light" scope="col">Stock Disponible</th>
                                            <th class="sticky-top bg-light" scope="col">Punto Pedido</th>
                                            <th class="sticky-top bg-light" scope="col">Lote Optimo</th>    
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
                                            <td>{{$cerveza->cantidadStock}}</td>
                                            <td>{{$cerveza->puntoPedido}}</td>
                                            <td>{{$cerveza->loteOptimo}}</td>
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
                <a href="{{route('home')}}" class="btn btn-warning btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Volver</a>
                    
            </div>        
        </center>                                     
@endsection