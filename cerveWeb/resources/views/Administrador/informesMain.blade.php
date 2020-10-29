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
                        <a href="#" class="btn btn-primary">Ingresar</a>
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
                        <p class="card-text">Reporte o informe semanal resumido para la toma de decisiones en CerveWeb.</p>
                        <a href="#" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>

        </div>
        
        
    </div>
    



@endsection
    
