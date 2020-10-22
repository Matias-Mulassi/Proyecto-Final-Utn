@extends('templates.template')

@section('content')


<center>
       <div class="col-md-12 mt-4">
       @php
        use Carbon\Carbon;
        @endphp
                <div class="card">
                    <div class="card-header">
                        Cuenta corriente del usuario {{Auth::user()->apellido}} , {{Auth::user()->nombre}}
                    </div>
                    <div class="card-body">
                        @if(!($pedidos->isEmpty()))
                        <div class="alert alert-info col-md-3" role="alert">
                                    <strong> Total deuda: $ </strong>{{number_format($totalAbonar,2)}}<br>  
                        </div>
                        
                            <div class="table-responsive">
                            
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th class="sticky-top bg-light" scope="col">Nro Pedido</th>
                                            <th class="sticky-top bg-light" scope="col">Fecha de entrega</th>
                                            <th colspan="3" class="sticky-top bg-light" scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pedidos as $pedido)
                                        
                                                
                                        <tr>
                                            <th scope="row">{{$pedido->id}}</th>
                                            <td>{{Carbon::parse($pedido->fecha_entrega)->format('d-m-Y')}}</td>
                                            <td scope="col">
                                                <center>
                                                    @if($pedido->estado=="entregado")
                                                    <a href="{{route('verFactura',$pedido)}}" class="btn btn-outline-primary">
                                                        Factura
                                                    </a>
                                                    <a href="{{route('verRemito',$pedido)}}" class="btn btn-outline-warning">
                                                        Remito
                                                    </a>
                                                    @endif
                                                    <a href="#" class="btn btn-outline-success">
                                                        Pagar
                                                    </a>
                                                </center>                                  
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                            </div>
                            @else
                            <h3><div class="col alert alert-info alert-dismissible fade show" role="alert"> <i class="fa fa-info-circle"></i> No hay pedidos con deuda</div></h3>
                    @endif
                    </div>
                    
                </div>        
        </center>

@stop