@extends('templates.templateAdmin')

@section('content')
<div class="container mt-3">
<div class="row justify-content-center">
 <div class="col-md-8">
     <div class="card">
         <div class="card-header">{{ __('Cambiar Contraseña') }}</div>

         <div class="card-body">
             <form method="POST" action="{{ route('actualizarContraseña') }}">
                 @csrf

                 <div class="form-group row">
                     <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                     <div class="col-md-6">
                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="nueva contraseña" placeholder="Nueva Contraseña">

                         @error('password')
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                     </div>
                 </div>

                 <div class="form-group row">
                     <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                     <div class="col-md-6">
                         <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="confirmar contraseña" placeholder="Confirmar Nueva Contraseña">
                     </div>
                 </div>

                 <div class="form-group row mb-0">
                     <div class="col-md-6 offset-md-4">
                         <button type="submit" class="btn btn-primary">
                             {{ __('Confirmar cambio Contraseña') }}
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
