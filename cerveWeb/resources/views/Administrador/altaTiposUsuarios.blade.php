@extends('templates.template')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Registro Tipos de Usuarios</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agregarTiposUsuarios') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="nombre" >
                                        {{ __('Descripción') }}:
                                </label>
                                <input id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus placeholder="Descripción">
                                        @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col text-left mt-2 ">
                                    <button type="submit" class="btn btn-primary mt-md-2 mt-2 float-right">
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