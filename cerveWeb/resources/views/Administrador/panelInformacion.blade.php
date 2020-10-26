@extends('templates.templateAdmin')

@section('content')

<main role="main" class="container">
  <div class="d-flex p-3 my-3 text-black-50 bg-white rounded shadow-sm">
    <img class="mr-3" src="{{asset('imagenes/notificacion.jpg')}}" alt="" width="48" height="48">
    <div class="lh-100">
      <h6 class="mb-0 text-black lh-100">Panel de notificaciones</h6>
      <small>Notificaciones del administrador {{Auth::user()->apellido}}, {{Auth::user()->nombre}}</small>
    </div>
  </div>

  <div class="col-md-12 mt-4">
            <div class="card mt-5">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('panelNotificaciones')}}">Acciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('panelInformacion')}}">Información</a>
                </li>
                </ul>
            </div>
            <div class="card-body">
            @if(count($mensajes)>0)
  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Información de Stock</h6>
    @foreach($mensajes as $mensaje)
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@Sistema</strong>
        {{$mensaje->cuerpo}}.
      </p>
      <div class="text-right">
          <a href="{{route('eliminarNotificacionStock',$mensaje)}}">Eliminar Notificación</a>
      </div>
    </div>
    
    @endforeach
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Sugerencias</h6>
    <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay sugerencias por el momento!
									
    </div>
    <small class="d-block text-right mt-3">
      <a href="{{route('eliminarMensajes')}}">Eliminar todos los mensajes</a>
    </small>
  </div>
  @else
  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Ultimas Notificaciones</h6>
    <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay información por mostrar!
									
    </div>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Sugerencias</h6>
    <div class="col mt-4 alert alert-info alert-dismissible fade show" role="alert">
							<strong><i class="fa fa-info-circle"></i></strong> No hay sugerencias por el momento!
									
    </div>
  </div>
  @endif
            </div>
            </div>
        </div>
  
  @if(session('success'))
      <div class=" col-md-6 float-left mt-2 alert alert-success alert-dismissible fade show" role="alert">
              <strong>{{session('success')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
      </div>
      @elseif(session('error'))
      <div class=" col-md-6 float-left mt-2 alert alert-danger alert-dismissible fade show" role="alert">
              <strong>{{session('error')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
      </div>
  @endif
</main>

@endsection