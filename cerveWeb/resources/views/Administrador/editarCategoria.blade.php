@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">CATEGORIAS <small>[Editar Categoria]</small></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateCategoria') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="nombre" >
                                        {{ __('Nombre') }}:
                                </label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$categoria->nombre }}" autocomplete="Nombre" autofocus placeholder="Nombre">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                        </div>
                        <input type="hidden" name="id" value="{{$categoria->id}}"> 
                        <div class="form-row">
                                <div class="col text-left mt-4">
                                <label for="nombre" >
                                        {{ __('Descripción') }}:
                                </label>
                                <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion">{{$categoria->descripcion}}</textarea>
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

                            <a href="{{route('abmlCategorias')}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>

                        </p>
                         
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection