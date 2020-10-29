@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Aumento de precios </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateprecioCervezas') }}">
                        @csrf

                    
                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Porcentaje suba de precios</label>
                                <input type="number" step="any" class="form-control  @error('porcentaje') is-invalid @enderror" name="porcentaje"  id="porcentaje">
                                @error('porcentaje')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>
                        <p>

                            <button type="submit" class="btn btn-primary float-right mt-3">
                                    {{ __('Confirmar') }}
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