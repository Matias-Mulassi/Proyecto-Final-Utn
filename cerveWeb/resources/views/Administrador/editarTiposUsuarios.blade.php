@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">TIPOS USUARIOS <small>[Editar Tipo de usuario]</small></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateTiposUsuarios') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="nombre" >
                                        {{ __('Descripción') }}:
                                </label>
                                <input type="hidden" name="id" value="{{$tip->id}}">
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ $tip->descripcion }}" required autocomplete="descripcion" autofocus placeholder="Descripción">
                                        @error('descripcion')
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

                                <a href="{{route('abmlTiposUsuarios')}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>

                            </p>
                         
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection