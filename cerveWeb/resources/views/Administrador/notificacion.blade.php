@extends('templates.templateAdmin')

@section('content')
<main role="main" class="container">
  <div class="d-flex align-items-center p-3 my-3 text-black-50 bg-white rounded shadow-sm">
    <img class="mr-3" src="{{asset('imagenes/notificacion.jpg')}}" alt="" width="48" height="48">
    <div class="lh-100">
      <h6 class="mb-0 text-black lh-100">Notificación</h6>
      <small>Notificaciones del administrador {{Auth::user()->apellido}}, {{Auth::user()->nombre}}</small>
    </div>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Notificacion Reciente</h6>
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@Sistema</strong>
        {{$mensaje->cuerpo}}
      </p>
    </div>
    <small class="d-block text-right mt-3">
      <a href="{{route('panelNotificaciones')}}">Ver Todas las notificaciones</a>
    </small>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Sugerencia</h6>
    <div class="media text-muted pt-3">
      <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"></rect><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <div class="d-flex justify-content-between align-items-center w-100">
          <strong class="text-gray-dark">@Sistema</strong>
          <a href="{{route('solicitarAbastecimiento',['cerveza'=>$cerveza,'proveedor'=>$proveedor])}}">Confirmar</a>
        </div>
        <span class="d-block">Realizar compra de {{$cerveza->loteOptimo}} lts de cerveza {{$cerveza->nombre}} al proveedor <strong>{{$proveedor->razonSocial}}</strong></span>
      </div>
    </div>
  </div>
</main>

@endsection