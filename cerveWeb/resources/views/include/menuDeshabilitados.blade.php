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
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       <i class="fa fa-user"></i> {{Auth::user()->apellido}}, {{Auth::user()->nombre }} 
                                        <span class="caret"></span>
                                        
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                                     
                                    <a class="dropdown-item" href="{{route('cambiarContraseña')}}">Cambiar Contraseña</a>
                                    @switch(Auth::user()->id_tipo_usuario)
                                            @case(1)
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#_{{1}}">Guia del Usuario</a>
                                                @break
                                            @case(2)
                                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#__{{2}}">Guia del Usuario</a>
                                                @break
                                            @case(3)
                                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#___{{3}}">Guia del Usuario</a>
                                                @break
                                        @endswitch
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




<!-- Modal manual cliente -->
<div class="modal fade" id="_{{1}}" tabindex="-1" role="dialog" aria-labelledby="_{{1}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">

                       <a href="https://online.flippingbook.com/view/566188/" class="fbo-embed" data-fbo-id="566188" data-fbo-lightbox="yes" data-fbo-width="740px" data-fbo-height="480px" data-fbo-version="1" style="max-width: 100%">Manual del Usuario</a><script async defer src="https://online.flippingbook.com/EmbedScriptUrl.aspx?m=redir&hid=566188"></script>

                       </div>
                       <div class="modal-footer">
                       <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  



<!-- Modal manual Administrador -->
<div class="modal fade" id="__{{2}}" tabindex="-1" role="dialog" aria-labelledby="__{{2}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                       <a href="https://online.flippingbook.com/view/421457/" class="fbo-embed" data-fbo-id="421457" data-fbo-lightbox="yes" data-fbo-width="740px" data-fbo-height="480px" data-fbo-version="1" style="max-width: 100%">Manual del Administrador</a><script async defer src="https://online.flippingbook.com/EmbedScriptUrl.aspx?m=redir&hid=421457"></script>

                       </div>
                       <div class="modal-footer">
                       <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  



<!-- Modal manual Operador -->
<div class="modal fade" id="___{{3}}" tabindex="-1" role="dialog" aria-labelledby="___{{3}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                       <a href="https://online.flippingbook.com/view/738469/" class="fbo-embed" data-fbo-id="738469" data-fbo-lightbox="yes" data-fbo-width="740px" data-fbo-height="480px" data-fbo-version="1" style="max-width: 100%">Manual del Operador</a><script async defer src="https://online.flippingbook.com/EmbedScriptUrl.aspx?m=redir&hid=738469"></script>
                       </div>
                       <div class="modal-footer">
                       <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  