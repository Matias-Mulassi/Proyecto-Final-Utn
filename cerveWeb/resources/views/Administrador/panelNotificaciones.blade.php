@extends('templates.templateAdmin')

@section('content')

<main role="main" class="container">
  <div class="d-flex align-items-center p-3 my-3 text-black-50 bg-white rounded shadow-sm">
    <img class="mr-3" src="{{asset('imagenes/notificacion.jpg')}}" alt="" width="48" height="48">
    <div class="lh-100">
      <h6 class="mb-0 text-black lh-100">Panel de notificaciones</h6>
      <small>Notificaciones del administrador {{Auth::user()->apellido}}, {{Auth::user()->nombre}}</small>
    </div>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Ultimas Notificaciones</h6>
    @foreach($mensajes as $mensaje)
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"></rect><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@Sistema</strong>
        {{$mensaje->cuerpo}}.
      </p>
    </div>
    @endforeach
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Sugerencias</h6>
    @for ($i = 0; $i <= count($mensajes)-1; $i++)
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <div class="d-flex justify-content-between align-items-center w-100">
          <strong class="text-gray-dark">@Sistema</strong>
          <a href="#">Confirmar</a>
        </div>
        <span class="d-block">Realizar compra de {{$cervezas[$i]->loteOptimo}} lts de cerveza {{$cervezas[$i]->nombre}} al proveedor <strong>{{$cervezas[$i]->proveedor->razonSocial}}</strong></span>
      </div>
    </div>
    @endfor
    <small class="d-block text-right mt-3">
      <a href="#">Realizar Todas las compras</a>
    </small>
  </div>
</main>

@endsection