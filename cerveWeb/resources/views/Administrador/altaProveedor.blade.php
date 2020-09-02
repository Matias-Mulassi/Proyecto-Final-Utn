@extends('templates.templateAdmin')

@section('content')
		<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">PROVEEDORES <small>[Agregar Proveedor]</small>  </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('altaProveedor') }}">
                        @csrf

                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="cuit" >
                                        {{ __('Cuit') }}:
                                </label>
                                <input type="tel" id="cuit" class="form-control @error('cuit') is-invalid @enderror" value="{{ old('cuit') }}" name="cuit" autofocus placeholder="30-71031609-9" autocomplete="cuit"><br>
                            <small>Formato: 30-71031609-5</small>
                                        @error('cuit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                        </div>
                        <div class="form-row">
                                <div class="col text-left mt-2">
                                <label for="razonSocial" >
                                        {{ __('Razon Social') }}:
                                </label>
                                <input id="razonSocial" type="text" class="form-control @error('razonSocial') is-invalid @enderror" value="{{ old('razonSocial') }}" name="razonSocial" autocomplete="razonSocial" autofocus placeholder="razon Social">
                                        @error('razonSocial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                           
                                </div>
                        </div>
                        <div class="form-row">

                            <div class="col text-left mt-2">
                                    <label for="Telefono">
                                        {{ __('Telefono') }}
                                    </label>
                                    <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" name="telefono" autofocus placeholder="30-71031609-9" autocomplete="telefono"><br>
                                    <small>Formato: 341-71031609</small>
                    
                                        @error('telefono')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                              
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col text-left mt-2">
                            <label for="validationDefault03">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="email">

                                    @error('email')
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