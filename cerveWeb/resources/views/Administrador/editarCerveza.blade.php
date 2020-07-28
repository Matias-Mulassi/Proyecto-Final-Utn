@extends('layouts.app')

@section('content')
		<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Editar Cerveza</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateCerveza') }}">
                        @csrf
                        <div class="form-row">
                             <div class="col-md-6 col-sm">
                               <label for="nombre">
                                      {{ __('Nombre') }}:
                               </label>
                               <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$cerveza->nombre }}" required autocomplete="nombre" autofocus placeholder="Nombre">
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
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion"  required>
                                {{$cerveza->descripcion}}
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
                                <label for="validationDefault03">Precio</label>
                                <input type="number" class="form-control  @error('precio') is-invalid @enderror" step="any" name="precio" value="{{$cerveza->precio }}" id="precio" required>
                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                            <div class="col-md-3 col-sm  mt-2 ">                                             
                                <button class="btn btn-primary mt-4 float-right" type="submit">Guardar</button>
                            </div>    
                        </div>

                        
                        
                               
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection