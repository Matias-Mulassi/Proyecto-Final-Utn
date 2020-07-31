@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Edicion Usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updateUsuario') }}">
                        @csrf

                   <div class="form-row">
                        <div class="col-md-6 mt-4 text-left">
                           <label for="nombre" >
                                  {{ __('Nombre') }}
                           </label>
                           <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $us->nombre }}" required autocomplete="nombre" autofocus placeholder="Nombre">
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
                              <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" value="{{ $us->apellido }}" required autocomplete="apellido" autofocus placeholder="Apellido">
                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                             
                        </div>
                    </div>    
                    <input type="hidden" name="id" value="{{$us->id}}">                    
                    <div class="form-row">
                        <div class="col-md-6 mt-4 text-left">
                                <label for="Razon Social">
                                    {{ __('Razon Social [Solo Usuarios]') }}
                                </label>
                                <input id="razonSocial" type="text" class="form-control @error('razonSocial') is-invalid @enderror" name="razonSocial" value="{{ $us->razonSocial }}"  autocomplete="razonSocial" autofocus placeholder="razon Social">
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
                            <input type="tel" id="cuitcuil" class="form-control @error('cuitcuil') is-invalid @enderror" name="cuitcuil" autofocus placeholder="30-71031609-9" value="{{ $us->cuitcuil }}" pattern="[0-6]{2}-[0-9]{8}-[0-9]{1}" autocomplete="cuitcuil"><br>
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
                                <input type="tel" id="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" autofocus placeholder="telefono" value="{{ $us->telefono }}" ><br>
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
                                <input id="direcciónEntrega" type="text" class="form-control @error('direcciónEntrega') is-invalid @enderror" name="direcciónEntrega" value="{{ $us->direcciónEntrega }}" autocomplete="direcciónEntrega" autofocus placeholder="dirección Entrega">
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
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$us->email }}" required placeholder="Email" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror  
                        </div>
                     </div>
                      <div class="form-row">
                        <div class="col text-left mt-2">
                           <label for="validationDefault03">{{ __('Condicion IVA [Solo Usuarios]') }}</label>
                             <select id="condicionIVA" name="condicionIVA" class="form-control @error('condicionIVA') is-invalid @enderror" value="{{$us->condicionIVA }}" autocomplete="" placeholder="">
                             
                             <option value="" selected disabled hidden> {{$us->condicionIVA}}</option>
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
                             <select id="prioridad" name="prioridad" class="form-control @error('prioridad') is-invalid @enderror" value="{{$us->prioridad }}" autocomplete="" placeholder="">
                                 @switch($us->prioridad)
                                    @case(1)
                                    <option value="" selected disabled hidden>Baja</option>
                                    <option value="1">Baja</option>
                                    <option value="2">Mediana</option>
                                    <option value="3">Alta</option>
                                    @break

                                    @case(2)
                                    <option value="" selected disabled hidden>Mediana</option>
                                    <option value="1">Baja</option>
                                    <option value="2">Mediana</option>
                                    <option value="3">Alta</option>
                                    @break

                                    @case(3)
                                    <option value="" selected disabled hidden>Alta</option>
                                    <option value="1">Baja</option>
                                    <option value="2">Mediana</option>
                                    <option value="3">Alta</option>
                                    @break
                                    
                                    @default
                                    <option value="" selected disabled hidden>{{$us->prioridad}}</option>
                                    <option value="1">Baja</option>
                                    <option value="2">Mediana</option>
                                    <option value="3">Alta</option>
                                     @break
                                 @endswitch
                                 
            
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
                                    @if($tipoUsuario->id == $us->id_tipo_usuario)
                                    <option selected value="{{$tipoUsuario->id}}">{{$tipoUsuario->descripcion}}</option>
                                    @else
                                    <option value="{{$tipoUsuario->id}}">{{$tipoUsuario->descripcion}}</option>
                                    @endif                             	
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
