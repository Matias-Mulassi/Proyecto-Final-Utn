<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand main-title" href="{{ route('home') }}">CerveWeb</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text">
      Tienda de cerveceria Online
    </span>
  </nav>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ route('mostrarCarrito') }}"><i class="fa fa-shopping-cart"></i></a></li>
      <li><a href="#">Conocenos</a></li>
      <li><a href="#">Contacto</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-user"></i> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Iniciar Sesion</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>