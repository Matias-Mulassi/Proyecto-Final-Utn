@extends('templates.template')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Registro Usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
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
                    <input type="hidden" name="id_tipo_usuario" value="1" required>
                    <input type="hidden" name="prioridad" value="1" required>
                    <div class="form-row">
                        <div class="col-md-6 mt-4 text-left">
                                <label for="Razon Social">
                                    {{ __('Razon Social') }}
                                </label>
                                <input id="razonSocial" type="text" class="form-control @error('razonSocial') is-invalid @enderror" name="razonSocial" value="{{ old('razonSocial') }}" required autocomplete="razonSocial" autofocus placeholder="razon Social">
                                    @error('razonSocial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                             
                        </div>

                         <div class="col-md-6 mt-4 text-left">
                            <label for="Cuit/Cuil">
                                {{ __('Cuit/Cuil') }}
                            </label>
                            <input type="tel" id="cuitcuil" class="form-control @error('cuitcuil') is-invalid @enderror" name="cuitcuil" autofocus placeholder="30-71031609-9" value="{{ old('cuitcuil') }}" pattern="[0-6]{2}-[0-9]{8}-[0-9]{1}" required autocomplete="cuitcuil" required><br>
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
                                    {{ __('Telefono') }}
                                </label>
                                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" autofocus placeholder="30-71031609-9" value="{{ old('telefono') }}" required autocomplete="telefono" required><br>
                                <small>Formato: 341-71031609</small>
                
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                              
                        </div>
                        <div class="col-md-6 mt-4 text-left">
                                <label for="Razon Social">
                                    {{ __('Dirección Entrega') }}
                                </label>
                                <input id="direcciónEntrega" type="text" class="form-control @error('direcciónEntrega') is-invalid @enderror" name="direcciónEntrega" value="{{ old('direcciónEntrega') }}" required autocomplete="direcciónEntrega" autofocus placeholder="dirección Entrega">
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
                           <label for="validationDefault03">{{ __('Condicion IVA') }}</label>
                             <select id="condicionIVA" name="condicionIVA" class="form-control @error('condicionIVA') is-invalid @enderror" placeholder="Responsable Inscripto" required>
                             	
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
                      <p>

                        
                        <button type="submit" class="btn btn-primary mt-4 float-right">
                                    {{ __('Confirmar Registro') }}
                        </button>

                        <a href="{{route('catalogoCervezas')}}" class="btn btn-warning float-right mr-3 mt-4">Volver</a>
                      
                        
                      </p>
                          
                    </form>                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
