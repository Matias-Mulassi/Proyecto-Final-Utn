@extends('layouts.app')

@section('content')
		<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Registro Cerveza</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('altaCerveza') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                             <div class="col-md-6 col-sm">
                               <label for="nombre">
                                      {{ __('Nombre') }}:
                               </label>
                               <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus placeholder="Nombre">
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
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" required></textarea>
                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Precio</label>
                                <input type="number" step="any" class="form-control  @error('precio') is-invalid @enderror" name="precio" value="{{ old('precio') }}" id="precio" required>
                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                       
                        <div class="form-row">
                                <div class="col text-left mt-2">
                                    <label for="validationDefault03">{{ __('Categoria') }}</label>
                                        <select id="id_categoria" name="id_categoria" class="form-control @error('id_categoria') is-invalid @enderror" placeholder="Categoria" required>
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
                        <div class="col-md-3 col-sm  mt-2 ">                                             
                                <button type="submit" class=" btn btn-primary mt-md-4 float-right">
                                        {{ __('Confirmar Registro') }}
                                </button> 
                        </div>    
                </div>

                        
                        
                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection