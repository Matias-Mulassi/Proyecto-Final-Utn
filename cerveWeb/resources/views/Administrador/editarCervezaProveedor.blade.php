@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Edición cerveza que vende el proveedor {{$proveedor->razonSocial}} </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateCervezaProveedor') }}">
                        @csrf

                    
                        <input type="hidden" name="idProveedor" value="{{$proveedor->id}}">
                        <input type="hidden" name="idCerveza" value="{{$idCerveza}}">
                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Costo x lt</label>
                                <input type="number" min="1" step="any" class="form-control  @error('costo') is-invalid @enderror" name="costo" value="{{ $costo }}" id="costo">
                                @error('costo')
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

                            <a href="{{route('abmlCervezasProveedores',$proveedor->id)}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>
                         
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection