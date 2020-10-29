@extends('templates.templateAdmin')

@section('content')

    <div class="container text-center">

        <div class="page-header mt-5">

            <h1 style="color:goldenrod;"><img src="https://img.icons8.com/doodle/48/000000/business-report.png"/></i> INFORMES VENTAS </h1>
        </div>

        
        
        <div class="row mt-5" >


            <div class="col-md-6">
                <div class="card" style="width: 18rem;">
                
                <img src="https://i.ibb.co/YBk9g60/clientes.jpg" alt="clientes" alt="compra-Proveedor" class="card-img-top">
                    <div class="card-body">
                  
                        <h5 class="card-title">Ventas por Clientes</h5>
                        <p class="card-text">Informe detallado acerca de las ventas de CerveWeb analizado por clientes.</p>
                        <a href="{{route('informeVentasClientes')}}" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                
                <div class="card" style="width: 18rem;">
 
                <img src="https://i.ibb.co/BcMH8Mg/cervezas.jpg" alt="cervezas" class="card-img-top">
                        <div class="card-body">
                    
                            <h5 class="card-title">Ventas por Cervezas</h5>
                            <p class="card-text">Informe detallado acerca de las ventas de CerveWeb analizado por Cervezas.</p>
                            <a href="{{route('informeVentasCervezas')}}" class="btn btn-primary">Ingresar</a>
                        </div>
                </div>
            </div>


        </div>
        
        
    </div>
    

</center>

@endsection
    
