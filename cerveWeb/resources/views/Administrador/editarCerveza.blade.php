@extends('templates.templateAdmin')

@section('content')
@php
use App\Http\Controllers\CervezaController;
$cervezaController = new CervezaController();
@endphp
		<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">CERVEZAS <small>[Editar Cerveza]</small></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateCerveza') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                             <div class="col text-left mt-2">
                               <label for="nombre">
                                      {{ __('Nombre') }}:
                               </label>
                               <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$cerveza->nombre }}"  autocomplete="nombre" autofocus placeholder="Nombre">
                                    @error('nombre')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror     
                              </div>
                        </div>
                        <input type="hidden" name="id" value="{{$cerveza->id}}">
                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Descripción</label>
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion"  >{{$cerveza->descripcion}}
                                </textarea>
                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Limite de venta (lts/dia)</label>
                                <input type="number"  class="form-control  @error('limite') is-invalid @enderror" name="limite" value="{{$cerveza->ventaLimite }}" id="limite" >
                                @error('limite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Desperdicio (lts)</label>
                                <input type="number"  class="form-control  @error('desperdicio') is-invalid @enderror" name="desperdicio" value="{{$cerveza->desperdicio*100}}" id="desperdicio" >
                                @error('desperdicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Precio x lt</label>
                                <input type="number" class="form-control  @error('precio') is-invalid @enderror" step="any" name="precio" value="{{$cervezaController->getUltimoPrecio($cerveza->id)}}" id="precio" >
                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Stock Disponible</label>
                                <input type="number"  class="form-control  @error('stockDisponible') is-invalid @enderror" name="stockDisponible" value="{{$cerveza->cantidadStock }}" id="stockDisponible" >
                                @error('stockDisponible')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Punto Pedido</label>
                                <input type="number"  class="form-control  @error('puntoPedido') is-invalid @enderror" name="puntoPedido" value="{{$cerveza->puntoPedido}}" id="puntoPedido" >
                                @error('puntoPedido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">												
                            <div class="col text-left mt-3">
                                <label class="control-label" for="fichero1">Imagen</label>
                                <input style="padding: 5px;" id="image" class="form-control @error('image') is-invalid @enderror" type="file" name="image" >
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 	
                            </div>
                        </div>
                       
                        <div class="form-row">
                                <div class="col text-left mt-2">
                                    <label for="validationDefault03">{{ __('Categoria') }}</label>
                                        <select id="id_categoria" name="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror p-1" placeholder="Categoria" >
                                            @foreach($categorias as $categoria)
                                                @if($categoria->id == $cerveza->id_categoria)
                                                    <option selected value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                                    @else
                                                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                                    @endif                             	
                                            @endforeach
                                        </select>

                                            @error('categoria')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror  
                                </div>
                        </div>
                        <p>

                            <button type="submit" class="btn btn-primary float-right mt-3">
                                    {{ __('Confirmar Edición') }}
                            </button>  

                            <a href="{{route('abmlCervezas')}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>
                         
                        </p>
                           

                        
                        
                               
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection