@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">CERVEZAS <small>[Agregar Cerveza]</small></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('altaCerveza') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                             <div class="col text-left mt-2">
                               <label for="nombre">
                                      {{ __('Nombre') }}:
                               </label>
                               <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" autocomplete="nombre" autofocus placeholder="Nombre">
                                    @error('nombre')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                    @enderror     
                              </div>
                        </div>
                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Descripción</label>
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion"  id="descripcion" placeholder="Ingrese una descripción">{{ old('descripcion') }}</textarea>
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
                                <input type="number" class="form-control  @error('limite') is-invalid @enderror" name="limite" value="{{ old('limite') }}" id="limite">
                                @error('limite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Desperdicio (%)</label>
                                <input type="number" class="form-control  @error('desperdicio') is-invalid @enderror" name="desperdicio" value="{{ old('desperdicio') }}" id="desperdicio">
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
                                <input type="number"  step="any" class="form-control  @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" id="precio">
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
                                <input type="number" class="form-control  @error('stockDisponible') is-invalid @enderror" name="stockDisponible" value="{{ old('stockDisponible') }}" id="stockDisponible">
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
                                <input type="number" class="form-control  @error('puntoPedido') is-invalid @enderror" name="puntoPedido" value="{{ old('puntoPedido') }}" id="puntoPedido">
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
                                <input style="padding: 5px;" id="image" class="form-control @error('image') is-invalid @enderror" type="file" name="image" value="{{ old('image') }}">
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
                                        <select id="id_categoria" name="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror p-1" placeholder="Categoria">
                                            @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
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
                                    {{ __('Confirmar Registro') }}
                            </button>  

                            <a href="{{route('abmlCervezas')}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>
                         
                        </p>
                </div>

                        
                        
                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection