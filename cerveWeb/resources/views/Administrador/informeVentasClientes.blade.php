@extends('templates.templateAdmin')

@section('content')
@php
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CervezaController;
use Carbon\Carbon;
$pedidoController = new PedidoController();
$cervezaController = new CervezaController();
@endphp

<style type="text/css" media="print">
@media print {
#noImprime {display:none;}
}
</style>


<h2>Fecha Informe: {{Carbon::now()->format('d-m-Y')}}</h2>

<center>
<div id="noImprime">
    <a href="{{route('informeVentas')}}" class="btn btn-warning mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Volver</a>
    <button type="button"  class="btn btn-outline-primary mt-3 " onclick="imprimir()">
        Imprimir / Exportar <i class="fa fa-print"></i>
    </button>
    <button type="button"  class="btn btn-outline-warning mt-3" data-toggle="modal" data-target="#_{{1}}">
        Seleccionar Período Analisis <i class="fa fa-calendar"></i>
    </button>
</div>

<nav class="col-md-8 navbar navbar-light text-center mt-4 bg-light">
  <a class="navbar-brand">¿Desea consultar algun cliente en particular?</a>
  <form class="form-inline" action="{{ route('buscarCliente') }}">
    <input type="hidden" name="fechaDesde" value="{{$fechaDesde}}">
    <input type="hidden" name="fechaHasta" value="{{$fechaHasta}}">
    <input name="razonSocial" class="form-control mr-sm-2" type="search" placeholder="Cliente" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
  </form>
</nav>

<p hidden>{{$totalVenta=0}}</p>
<p hidden>{{$totalLitrosVendidos=0}}</p>
@if(count($clientes)>0)
    @foreach($clientes as $cliente)
        <p hidden>{{$totalVentaCliente=0}}</p>
        <p hidden>{{$totalLtsVendidosCliente=0}}</p>
        <p hidden>{{$pedidos=$pedidoController->getPedidosVendidosCliente($cliente->id,$fechaDesde,$fechaHasta)}}</p>
        @if(count($pedidos)>0)
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    Ventas de {{$cliente->razonSocial}}
                </div>
                <div class="card-body">
                    
                        
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
        @endif           
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

    @else
    <div class="alert alert-info col-md-6 mt-5" role="alert">
                 
        <h4> <i class="fa fa-info-circle"></i><strong> La busqueda no arrojó resultados. </strong></h3>
                    
    </div>
    @endif

</center>


<!-- Modal -->
<form method="GET" action="{{route('informeVentasClientesSeleccionados')}}">
            @csrf
             <div class="modal fade" id="_{{1}}" tabindex="-1" role="dialog" aria-labelledby="_{{1}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ventas x Cliente</h5>
    
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                           <center>
                             Desde que fecha desea conocer información acerca de sus clientes?<br><hr>
                            
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

                            <p>
                                <label for="razonSocial" >
                                        {{ __('Cliente') }}:
                                </label>
                                <input id="cliente" type="text" class="form-control @error('cliente') is-invalid @enderror" value="{{ old('cliente') }}" name="cliente" autocomplete="cliente" autofocus placeholder="cliente">
                                        @error('cliente')
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

<script type="text/javascript">
    function imprimir()
    {
        window.print();
    }
</script>

@endsection
    
