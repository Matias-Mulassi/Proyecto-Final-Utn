@extends('templates.templateAdmin')

@section('content')
@php
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CervezaController;
use Carbon\Carbon;
$pedidoController = new PedidoController();
$cervezaController = new CervezaController();
@endphp
<center>
<button type="button"  class="btn btn-outline-primary mt-3" onclick="imprimir()">
    Imprimir / Exportar <i class="fa fa-print"></i>
</button>

<p hidden>{{$totalVenta=0}}</p>
<p hidden>{{$totalLitrosVendidos=0}}</p>
    @foreach($cervezas as $cerveza)
    <p hidden>{{$totalLitrosCerveza=0}}</p>
    <p hidden>{{$totalVentaCerveza=0}}</p>
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    Ventas de cerveza {{$cerveza->nombre}}
                </div>
                <div class="card-body">
                    
                        <div class="table-responsive">
                            
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th class="sticky-top bg-light" scope="col">Fecha</th>
                                        <th class="sticky-top bg-light" scope="col">Cliente</th>
                                        <th class="sticky-top bg-light" scope="col">Lts Vendidos</th>
                                        <th class="sticky-top bg-light" scope="col">Precio x lt.</th>
                                        <th class="sticky-top bg-light" scope="col">Subtotal.</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cerveza->itemsPedidos as $item)
                                        <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$item->pedido->created_at)}}</p> 
                                        
                                        <tr>
                                            <th scope="row">{{Carbon::parse($item->pedido->fecha_entrega)->format('d-m-Y')}}</th>
                                            <td class="text-right"> <strong>{{$item->pedido->usuario->razonSocial}}</strong></td>
                                            <td class="text-right"><strong> {{$item->cantidad}}</strong></td>
                                            <td class="text-right"><strong> {{number_format($precioCerveza,2)}}</strong></td>
                                            <td class="text-right"><strong> {{number_format($item->cantidad * $precioCerveza,2)}}</strong></td>
                                        </tr>
                                        <p hidden>{{$totalVentaCerveza+=$item->cantidad * $precioCerveza}}</p>
                                        <p hidden>{{$totalLitrosCerveza+=$item->cantidad}}</p>
                                    @endforeach
                                    
                                    </tbody>
                            </table>
                      
                        </div>                    
                    <div class="alert alert-warning col-md-3 mt-3 float-right ml-3" role="alert">
                                <strong> TOTAL CERVEZA : $ </strong>{{number_format($totalVentaCerveza,2)}} 
                    </div>
                    <div class="alert alert-warning col-md-3 mt-3 float-right" role="alert">
                                <strong> LITROS CERVEZA : </strong>{{$totalLitrosCerveza}} Lts
                    </div>
                </div>                         
            </div>
                             
            <p hidden>{{$totalVenta+=$totalVentaCerveza}}</p>
            <p hidden>{{$totalLitrosVendidos+=$totalLitrosCerveza}}</p>
        </div>       
    @endforeach 

    <div class="alert alert-info col-md-6 mt-5" role="alert">
        <h2 class="alert-heading">Resumen Informe Detallado</h4>
        <hr>
        <h4><strong>Total Litros Vendidos: </strong> {{$totalLitrosVendidos}} Lts</h3>
        <h4><strong>Total Venta: $</strong> {{number_format($totalVenta,2)}}</h3>
    </div>
</center>

<script type="text/javascript">
    function imprimir()
    {
        window.print();
    }
</script>

@endsection
    
