@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Alta Usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('agregarUsuario') }}">
                        @csrf

                   <div class="form-row">
                        <div class="col-md-6 mt-4 text-left">
                           <label for="nombre" >
                                  {{ __('Nombre') }}
                           </label>
                           <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus placeholder="Nombre">
                                @error('nombre')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                @enderror                           
                        </div>
                        <div class="col-md-6 mt-4 text-left">
                             <label for="apellido">
                                 {{ __('Apellido') }}
                             </label>
                              <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" value="{{ old('apellido') }}" required autocomplete="apellido" autofocus placeholder="Apellido">
                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                             
                        </div>
                    </div>                        
                    <div class="form-row">
                        <div class="col-md-6 mt-4 text-left">
                                <label for="Razon Social">
                                    {{ __('Razon Social [Solo Usuarios]') }}
                                </label>
                                <input id="razonSocial" type="text" class="form-control @error('razonSocial') is-invalid @enderror" name="razonSocial" value="{{ old('razonSocial') }}"  autocomplete="razonSocial" autofocus placeholder="razon Social">
                                    @error('razonSocial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                             
                        </div>

                         <div class="col-md-6 mt-4 text-left">
                            <label for="Cuit/Cuil">
                                {{ __('Cuit/Cuil [Solo Usuarios]') }}
                            </label>
                            <input type="tel" id="cuitcuil" class="form-control @error('cuitcuil') is-invalid @enderror" name="cuitcuil" autofocus placeholder="30-71031609-9" value="{{ old('cuitcuil') }}" pattern="[0-6]{2}-[0-9]{8}-[0-9]{1}" autocomplete="cuitcuil"><br>
                            <small>Formato: 30-71031609-5</small>
            
                                @error('cuitcuil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                              
                         </div>
                    </div>
                    <div class="form-row">

                        <div class="col-md-6 mt-4 text-left">
                                <label for="Telefono">
                                    {{ __('Telefono [Solo Usuarios]') }}
                                </label>
                                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" autofocus placeholder="30-71031609-9" value="{{ old('telefono') }}" autocomplete="telefono"><br>
                                <small>Formato: 341-71031609</small>
                
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                              
                        </div>
                        <div class="col-md-6 mt-4 text-left">
                                <label for="Razon Social">
                                    {{ __('Dirección Entrega [Solo Usuarios]') }}
                                </label>
                                <input id="direcciónEntrega" type="text" class="form-control @error('direcciónEntrega') is-invalid @enderror" name="direcciónEntrega" value="{{ old('direcciónEntrega') }}" autocomplete="direcciónEntrega" autofocus placeholder="dirección Entrega">
                                    @error('direcciónEntrega')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                             
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col text-left mt-2">
                           <label for="validationDefault03">{{ __('Email') }}</label>
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
                        </div>
                     </div>
                     <div class="form-row">
                         <div class="col-md-6 mt-4 text-left">
                            <label for="validationDefault01">
                                {{ __('Contraseña') }}
                            </label>
                            <input id="contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  required autocomplete="new-password" placeholder="Contraseña">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                              
                         </div>
                         <div class="col-md-6 mt-4 text-left">
                           <label for="validationDefault02">
                                {{ __('Confirmar contraseña') }}
                           </label>
                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar"> 
                            @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror          
                         </div>
                        
                     </div>
                      <div class="form-row">
                        <div class="col text-left mt-2">
                           <label for="validationDefault03">{{ __('Condicion IVA [Solo Usuarios]') }}</label>
                             <select id="condicionIVA" name="condicionIVA" class="form-control @error('condicionIVA') is-invalid @enderror" autocomplete="" placeholder="">
                             
                             <option value="" selected disabled hidden> Selecciona una opción</option>
                             	 <option value="Responsable Inscripto">Responsable Inscripto</option>
                                 <option value="Monotributista">Monotributista</option>
                                 <option value="Exento">Exento</option>
                                 <option value="Consumidor Final">Consumidor Final</option>
            
                             </select>
                             @error('condicionIVA')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror   
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col text-left mt-2">
                           <label for="validationDefault03">{{ __('Prioridad [Solo Usuarios]') }}</label>
                             <select id="prioridad" name="prioridad" class="form-control @error('prioridad') is-invalid @enderror" autocomplete="" placeholder="">
                                 <option value="" selected disabled hidden> Selecciona una opción</option>
                             	 <option value="1">Baja</option>
                                 <option value="2">Mediana</option>
                                 <option value="3">Alta</option>
                                 
            
                             </select>
                             @error('prioridad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror   
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col text-left mt-2">
                           <label for="validationDefault03">{{ __('Tipo Usuario') }}</label>
                             <select id="id_tipo_usuario" name="id_tipo_usuario" class="form-control @error('id_tipo_usuario') is-invalid @enderror" placeholder="Usuario" required>
                             	@foreach($tiposUsuarios as $tipoUsuario)
                             	 <option value="{{$tipoUsuario->id}}">{{$tipoUsuario->descripcion}}</option>
                             	@endforeach
                             </select>

                                @error('id_tipo_usuario')
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
