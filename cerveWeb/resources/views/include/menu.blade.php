<nav class="navbar navbar-expand-sm bg-light navbar-info justify-content-end navbar-light mt-0">
              @if (Auth::check())
              <a class="navbar-brand"  href="{{ route('home') }}"><!--{{ config('app.name', 'CerveWeb') }}-->CerveWeb</a>
              @else
              <a class="navbar-brand"  href="{{ 'main' }}"><!--{{ config('app.name', 'CerveWeb') }}-->CerveWeb</a>
              @endif
                 <button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="col-md-8">                 
                        <nav class="navbar navbar-light bg-light">
                            <span class="navbar-text">
                                Tienda de cerveceria Online
                            </span>
                        </nav>
                    </div>
                    <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                       
                        <ul class="navbar-nav text-right">
                            <!-- Authentication Links -->
                             @guest
                                <div class="col-md-2" style="font-size: 24px;">
                                    <li><a href="{{ route('mostrarCarrito') }}"><i style="color: goldenrod;" class="fa fa-shopping-cart"></i></a></li>
                                </div>
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
                                <div style="font-size: 24px;">
                                    <li><a href="{{ route('mostrarCarrito') }}"><i style="color: goldenrod;" class="fa fa-shopping-cart"></i></a></li>
                                </div>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       <i class="fa fa-user"></i> {{Auth::user()->apellido}}, {{Auth::user()->nombre }} 
                                        <span class="caret"></span>
                                        
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                                     
                                        @switch(Auth::user()->id_tipo_usuario)
                                            @case(1)
                                                <span>

                                                    <a class="dropdown-item" href="#">Mis pedidos</a>
                                                    <a class="dropdown-item" href="{{ route('catalogoCervezas') }}">Realizar Pedidos</a>  
                                                    <a class="dropdown-item" href="#">Cuenta Corriente</a>                                        
                                                </span>
                                                @break

                                            @case(2)
                                                <span>                                               
                                                   <a class="dropdown-item" href="{{ route('abmlUsuarios') }}">Usuarios</a>
                                                   <a class="dropdown-item" href="{{ route('abmlCervezas') }}">Cervezas</a>
                                                   <a class="dropdown-item" href="#">Proveedores</a>
                                                   <a class="dropdown-item" href="#">Pedidos</a>
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
                                        <a class="dropdown-item" href="">Cambiar Contraseña</a>
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