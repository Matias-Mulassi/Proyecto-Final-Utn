@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Registro de cerveza que vende el proveedor </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registroCervezaProveedor') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                    <label for="validationDefault03">{{ __('Cerveza') }}</label>
                                        <select id="id_cerveza" name="id_cerveza" class="form-control @error('id_cerveza') is-invalid @enderror" placeholder="Cerveza" required>
                                            @foreach($cervezas as $cerveza)
                                            <option value="{{$cerveza->id}}">{{$cerveza->nombre}} </option>
                                            @endforeach
                                        </select>

                                            @error('id_cerveza')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror  
                                </div>
                        </div>
                        <input type="hidden" name="idProveedor" value="{{$id}}">
                        <div class="form-row">
                            <div class="col text-left mt-3">
                                <label for="validationDefault03">Costo x lt</label>
                                <input type="number" step="any" class="form-control  @error('costo') is-invalid @enderror" name="costo" value="{{ old('costo') }}" id="costo" required>
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

                            <a href="{{route('abmlProveedores')}}" class="btn btn-warning float-right mr-3 mt-3">Cancelar</a>
                         
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection