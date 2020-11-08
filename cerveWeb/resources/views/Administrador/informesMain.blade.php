@extends('templates.templateAdmin')

@section('content')
    <div class="container text-center">

        <div class="page-header mt-5">

            <h1 style="color:goldenrod;"><img src="https://img.icons8.com/doodle/48/000000/business-report.png"/></i> SECCIÓN INFORMES</h1>
        </div>

        
        
        <div class="row mt-5">


            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                <img src="https://i.ibb.co/f17WmKV/compra-Proveedor.jpg" alt="compra-Proveedor" class="card-img-top">
                    <div class="card-body">
                  
                        <h5 class="card-title">Compras</h5>
                        <p class="card-text">Informe detallado acerca de las compras de CerveWeb.</p>
                        <a href="{{route('informeCompras')}}" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                
                <div class="card" style="width: 18rem;">
                <img src="https://i.ibb.co/Kr9q56T/venta-Detallado.jpg" alt="venta-Detallado" class="card-img-top">
                        <div class="card-body">
                    
                            <h5 class="card-title">Ventas</h5>
                            <p class="card-text">Informe detallado acerca de las ventas a clientes de CerveWeb.</p>
                            <a href="{{route('informeVentas')}}" class="btn btn-primary">Ingresar</a>
                        </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                
                    <img src="https://i.ibb.co/yY7Qyhs/reporte-Gerencial.png" alt="reporte-Gerencial" class="card-img-top">
                    <div class="card-body">
                
                        <h5 class="card-title">Reporte</h5>
                        <p class="card-text">Reporte o informe resumido para la toma de decisiones en CerveWeb.</p>
                        <button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#_{{1}}">
                            Ingresar
                        </button>
                    </div>
                </div>
            </div>

        </div>
        
        
    </div>
    
    <!-- Modal -->
    <form method="GET" action="{{route('informeGerencial')}}">
                @csrf
                <div class="modal fade" id="_{{1}}" tabindex="-1" role="dialog" aria-labelledby="_{{1}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
    
                            <h5 class="modal-title" id="exampleModalLabel">Informe resumen</h5>
        
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <center>
                                Desde que fecha desea analizar sus compras y ventas?<br><hr>
                                
                                <p>
                                    <label for="validationDefault03" class="text-left">Fecha Desde: </label>
                                    <input type="date" name="fechaDesde" id="fechaDesde" value="{{ old('fechaDesde') }}" class="form-control @error('fechaDesde') is-invalid @enderror">
                                    @error('fechaDesde')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror  
                                </p>

                                <p>
                                    <label for="validationDefault03" class="text-left">Fecha Hasta: </label>
                                    <input type="date" name="fechaHasta" id="fechaHasta" value="{{ old('fechaHasta') }}" class="form-control @error('fechaHasta') is-invalid @enderror">
                                    @error('fechaHasta')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror  
                                </p>

                            
                        </div>
                        </center>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary">Continuar <i class="fa fa-chevron-circle-right"></i></button>  
                        </div>
                        </div>
                    </div>
                </div>
                <!-- -->  
                </form>


@endsection
    
