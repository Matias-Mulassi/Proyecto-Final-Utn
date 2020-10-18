<nav class="navbar navbar-expand-sm bg-light navbar-info justify-content-end navbar-light mt-0">
              @if (Auth::check())
              <a class="navbar-brand"  href="{{ route('home') }}"><!--{{ config('app.name', 'CerveWeb') }}-->CerveWeb</a>
              @else
              <a class="navbar-brand"  href="{{ 'main' }}"><!--{{ config('app.name', 'CerveWeb') }}-->CerveWeb</a>
              @endif
                 <button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="col-md-7">                 
                        <nav class="navbar navbar-light bg-light">
                            <span class="navbar-text">
                                <strong><i class="fa fa-dashboard"></i> Dashboard</strong>
                            </span>
                        </nav>
                    </div>
                    <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                       
                        <ul class="navbar-nav text-right">
                            <!-- Authentication Links -->
                             @guest
                                <li class="nav-item active">
                                    <a href="{{ route('login') }}" class="col btn btn-success ml-md-1 mr-0 mr-md-1">
                                            {{ __('Ingresar') }}
                                    </a>
                                </li>                                
                                <li class="nav-item active">
                                    <div class="mt-2">
                                        
                                    </div>  
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item active">
                                    <a href="{{ route('register') }}" class=" col btn btn-primary ml-md-2 mr-md-2 mb-2">
                                          Registrarse
                                    </a>
                                </li>
                                @endif
                             @else                               
                                <p hidden>{{$mensajes = App\Mensaje::where('id_usuario','=',Auth::user()->id)->where('leido',false)->get()}}</p>
                                <li class="mt-2 mr-3"><div class="dropdown">
                                    <a class="toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-globe"></i> Notificaciones <span class="badge badge-info">{{count($mensajes)}}</span>
                                    </a>
                                    @if(count($mensajes)>0)
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        @foreach($mensajes->take(4) as $mensaje)
                                        <a class="dropdown-item" href="{{route('notificacion',$mensaje)}}">{{$mensaje->cuerpo}}</a>
                                        @endforeach
                                        <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-center" style="color:blue;" href="{{route('panelNotificaciones')}}"> <u>Ver todas las notificaciones</u></a>
                                        </div>
                                    </div></li>
                                    @else
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
                                                <strong><i class="fa fa-info-circle"></i></strong> No posee notificaciones sin leer
                                                        
                                            </div>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-center" style="color:blue;" href="{{route('panelNotificaciones')}}"> <u>Ver todas las notificaciones</u></a>
                                            </div>
                                        </div></li>
                                    @endif
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       <i class="fa fa-user"></i> {{Auth::user()->apellido}}, {{Auth::user()->nombre }} 
                                        <span class="caret"></span>
                                        
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                                     
                                        @switch(Auth::user()->id_tipo_usuario)
                                            @case(1)
                                                <span>

                                                    <a class="dropdown-item" href="{{ route('catalogoCervezas') }}">Realizar Pedidos</a>  
                                                    <a class="dropdown-item" href="{{ route('cuentaCorriente') }}">Cuenta Corriente</a>                                        
                                                </span>
                                                @break

                                            @case(2)
                                                <span>                                               
                                                   <a class="dropdown-item" href="{{ route('abmlUsuarios') }}">Usuarios</a>
                                                   <a class="dropdown-item" href="{{ route('abmlTiposUsuarios') }}">Tipos de Usuarios</a>
                                                   <a class="dropdown-item" href="{{ route('abmlCervezas') }}">Cervezas</a>
                                                   <a class="dropdown-item" href="{{ route('abmlCategorias') }}">Categorias</a>
                                                   <a class="dropdown-item" href="{{ route('abmlProveedores') }}">Proveedores</a>
                                                   <a class="dropdown-item" href="{{ route('blPedidos') }}">Pedidos</a>
                                                   <a class="dropdown-item" href="{{ route('infoStock') }}">Stock</a>
                                                   <a class="dropdown-item" href="{{ route('informes') }}">Informes</a>
                                               </span>
                                                @break
                                                
                                            @case(3)
                                                <span>
                                                    <a class="dropdown-item" href="#">Pedidos</a>
                                                    <a class="dropdown-item" href="#">Stock</a>
                                                    <a class="dropdown-item" href="#">Logistica</a>
                                                </span>
                                                @break    
                                           
                                        @endswitch
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{route('cambiarContraseña')}}">Cambiar Contraseña</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Salir') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                              @endguest
                        </ul>
                    </div>
</nav>