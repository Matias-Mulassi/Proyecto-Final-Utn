@extends('templates.templateDeshabilitados')
@section('content')
<center>
       <div class="col-md-9 mt-4">
                <div class="card">
                  <div class="card-header">
                  <i class="fa fa-info-circle mr-2"></i>    Situación del usuario : {{Auth::user()->nombre}} ,  {{Auth::user()->apellido}}
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <p><span class="label label-warning">
                                

                                    Estimado(a) usuario {{Auth::user()->nombre}} {{Auth::user()->apellido}} : <br> <br> <br> <br>

                                    Actualmente usted se encuentra <strong style="color:red;"> deshabilitado </strong> por los administradores del sitio web "CERVEWEB" <br>

                                    Para poder volver a utilizar las funcionalidades de nuestro servicio Online, favor de comunicarse con algun administrador del sitio. <br> <br>

                                    Disculpe las molestias ocasionadas...  <br> <br>

                                    <img style= "height:400px; width:500px" src="{{ asset('imagenes/logoDeshabilitado.png') }}"> <br>
                                    <hr>
                                    <strong>CerveWeb Staff</strong> 


                                    
                                    
                                    </span></p>
                            </div>
                        </div>    
                    </div>                         
                    </div>
        </div>

@stop