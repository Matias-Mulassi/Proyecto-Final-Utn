@extends('templates.templateAdmin')

@section('content')
@php

use App\Http\Controllers\CompraController;
use Carbon\Carbon;
$compraController = new CompraController();
@endphp

<style type="text/css" media="print">
@media print {
#noImprime {display:none;}
}
</style>
<h2>Fecha Informe: {{Carbon::now()->format('d-m-Y')}}</h2>
<center>

<h2>Compra de Cervezas desde: {{Carbon::parse($fechaDesde)->format('d-m-Y')}} hasta {{Carbon::parse($fechaHasta)->format('d-m-Y')}}</h2>
<div id="noImprime">
<a href="{{route('informeCompras')}}" class="btn btn-warning mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Volver</a>
    <button type="button"  class="btn btn-outline-primary mt-3 " onclick="imprimir()">
        Imprimir / Exportar <i class="fa fa-print"></i>
    </button>
    <button type="button"  class="btn btn-outline-warning mt-3" data-toggle="modal" data-target="#_{{1}}">
        Seleccionar Período Analisis <i class="fa fa-calendar"></i>
    </button>
</div>

<nav class="col-md-8 navbar navbar-light text-center mt-4 bg-light">
  <a class="navbar-brand">¿Desea consultar alguna cerveza en particular?</a>
  <form class="form-inline" action="{{ route('buscarCompraCerveza') }}">
    <input type="hidden" name="fechaDesde" value="{{$fechaDesde}}">
    <input type="hidden" name="fechaHasta" value="{{$fechaHasta}}">
    <input name="cerveza" class="form-control mr-sm-2" type="search" placeholder="Cerveza" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
  </form>
</nav>

<p hidden>{{$totalCompra=0}}</p>
<p hidden>{{$totalLitrosComprados=0}}</p>
@if(count($cervezas)>0)
    @foreach($cervezas as $cerveza)
    <p hidden>{{$compras=$compraController->getComprasByCerveza($cerveza->id,$fechaDesde,$fechaHasta)}}</p>
    <p hidden>{{$totalLitrosCerveza=0}}</p>
    <p hidden>{{$totalCompraCerveza=0}}</p>
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    Compras de cerveza {{$cerveza->nombre}}
                </div>
                <div class="card-body">
                @if(count($compras)>0)
                    
                        <div class="table-responsive">
                            
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th class="sticky-top bg-light" scope="col">Fecha</th>
                                        <th class="sticky-top bg-light" scope="col">Proveedor</th>
                                        <th class="sticky-top bg-light" scope="col">Lts Comprados</th>
                                        <th class="sticky-top bg-light" scope="col">Total.</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                
                                        @foreach($compras as $compra)
                                            <tr>
                                                <th scope="row">{{Carbon::parse($compra->fecha)->format('d-m-Y')}}</th>
                                                <td class="text-left"> <strong>{{$compra->proveedor->razonSocial}}</strong></td>
                                                <td class="text-right"><strong> {{$compra->cantidad}}</strong></td>
                                                <td class="text-right"><strong> {{number_format($compra->total,2)}}</strong></td>
                                            </tr>
                                            <p hidden>{{$totalCompraCerveza+=$compra->total}}</p>
                                            <p hidden>{{$totalLitrosCerveza+=$compra->cantidad}}</p>
                                        @endforeach
                                    </tbody>
                            </table>
                      
                        </div>                    
                        <div class="alert alert-warning col-md-3 mt-3 float-right ml-3" role="alert">
                                    <strong> TOTAL CERVEZA : $ </strong>{{number_format($totalCompraCerveza,2)}} 
                        </div>
                        <div class="alert alert-warning col-md-3 mt-3 float-right" role="alert">
                                    <strong> LITROS CERVEZA : </strong>{{$totalLitrosCerveza}} Lts
                        </div>
                    @else
                    <div class="alert alert-info col-md-6 mt-5" role="alert">
                 
                    <h4> <i class="fa fa-info-circle"></i><strong> No hay compras registradas de esta cerveza en el periodo solicitado </strong></h3>
                    
                    </div>
                    @endif
                </div>                         
            </div>
                             
            <p hidden>{{$totalCompra+=$totalCompraCerveza}}</p>
            <p hidden>{{$totalLitrosComprados+=$totalLitrosCerveza}}</p>
        </div>       
    @endforeach 

    <div class="alert alert-info col-md-6 mt-5" role="alert">
        <h2 class="alert-heading">Resumen Informe Detallado</h2>
        <hr>
        <h4><strong>Total Litros Comprados: </strong> {{$totalLitrosComprados}} Lts</h4>
        <h4><strong>Total Compra: $</strong> {{number_format($totalCompra,2)}}</h4>
    </div>

    @else
    <div class="alert alert-info col-md-6 mt-5" role="alert">
                 
        <h4> <i class="fa fa-info-circle"></i><strong> La busqueda no arrojó resultados. </strong></h3>
                    
    </div>
    @endif

</center>


<!-- Modal -->
<form method="GET" action="{{route('informeVentasCervezasSeleccionados')}}">
            @csrf
             <div class="modal fade" id="_{{1}}" tabindex="-1" role="dialog" aria-labelledby="_{{1}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Compras x Cerveza</h5>
    
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                           <center>
                             Desde que fecha desea obtener información acerca de la compra de sus cervezas?<br><hr>
                            
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
                                <label for="cerveza" >
                                        {{ __('Cerveza') }}:
                                </label>
                                <input id="cerveza" type="text" class="form-control @error('cerveza') is-invalid @enderror" value="{{ old('cerveza') }}" name="cerveza" autocomplete="cerveza" autofocus placeholder="Cerveza">
                                        @error('cerveza')
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
    
