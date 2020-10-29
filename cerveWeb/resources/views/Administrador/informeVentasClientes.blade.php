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
    @foreach($clientes as $cliente)
        <p hidden>{{$totalVentaCliente=0}}</p>
        <p hidden>{{$totalLtsVendidosCliente=0}}</p>
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    Ventas de {{$cliente->razonSocial}}
                </div>
                <div class="card-body">
                    <p hidden>{{$pedidos=$pedidoController->getPedidosVendidosCliente($cliente->id)}}</p>
                        <div class="table-responsive">
                            
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th class="sticky-top bg-light" scope="col">Fecha</th>
                                        <th class="sticky-top bg-light" scope="col">Lts Vendidos</th>
                                        <th class="sticky-top bg-light" scope="col">Importe Venta</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pedidos as $pedido)
                                        <p hidden>{{$totalLitrosPedido=0}}</p>
                                        <p hidden>{{$importeVenta=0}}</p>
                                        @foreach($pedido->itemsPedidos as $item)
                                        <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>
                                        <p hidden>{{$totalLitrosPedido= $totalLitrosPedido + $item->cantidad}}</p>
                                        <p hidden>{{$importeVenta= $importeVenta + $item->cantidad * $precioCerveza}}</p>
                                        
                                        
                                        @endforeach
                                        <p hidden>{{$totalVentaCliente+=$importeVenta}}</p>
                                        <p hidden>{{$totalLtsVendidosCliente+=$totalLitrosPedido}}</p>
                                            <tr>
                                                <th scope="row">{{Carbon::parse($pedido->fecha_entrega)->format('d-m-Y')}}</th>
                                                <td class="text-right"> <strong>{{$totalLitrosPedido}}</strong> Lts</td>
                                                <td class="text-right"><strong>$ {{number_format($importeVenta,2)}}</strong></td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                      
                        </div>
                    <div class="alert alert-warning col-md-3 mt-3 float-right ml-3" role="alert">
                                <strong> TOTAL CLIENTE : $ </strong>{{number_format($totalVentaCliente,2)}} 
                    </div>
                    <div class="alert alert-warning col-md-3 mt-3 float-right" role="alert">
                                <strong> LITROS CLIENTE : </strong>{{$totalLtsVendidosCliente}} Lts
                    </div>
                    
                    
                </div>                         
            </div>
                             
            <p hidden>{{$totalVenta+=$totalVentaCliente}}</p>
            <p hidden>{{$totalLitrosVendidos+=$totalLtsVendidosCliente}}</p>
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
    
