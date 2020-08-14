@extends('templates.template')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Registro Categorias</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('altaCategoria') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="nombre" >
                                        {{ __('Nombre') }}:
                                </label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="Nombre" autofocus placeholder="Nombre">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                        </div>
                        <div class="form-row">
                                <div class="col text-left mt-4">
                                <label for="nombre" >
                                        {{ __('Descripción') }}:
                                </label>
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" placeholder="Escriba una Descripción"></textarea>
                                        @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 float-right">
                                {{ __('Confirmar Registro') }}
                       </button>  
                         
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection