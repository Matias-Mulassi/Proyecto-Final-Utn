@extends('templates.templateOperator')

@section('content')

  @php
          use App\Cerveza;
          use App\User;
          use Carbon\Carbon;
          use App\Pedido;
          $cervezas = Cerveza::all()->where('deleted_at',null);
          $clientes = User::where('deleted_at',null)->where('id_tipo_usuario',1)->get();
  @endphp

<!-- se declaran litros por cerveza de cada cliente y cantidad garrafas por cerveza -->

  @foreach($clientes as $cliente)
    @foreach($cervezas as $cerveza)
    <p hidden>{{${"litros_".$cerveza->nombre.$cliente->razonSocial}=0}}</p>
      <p hidden>
            {{${"cantgarrafas20_".$cerveza->nombre.$cliente->razonSocial}=0}}
            {{${"cantgarrafas10_".$cerveza->nombre.$cliente->razonSocial}=0}}
            {{${"cantgarrafas5_".$cerveza->nombre.$cliente->razonSocial}=0}}
            {{${"cantgarrafas1_".$cerveza->nombre.$cliente->razonSocial}=0}}
          @endforeach
      </p>
  @endforeach

  <!-- Se definen los litros netos, a entregar para cliente -->
  @foreach($clientes as $cliente)
  <p hidden>{{$pedidos=Pedido::where('id_usuario','=',$cliente->id)->where('deleted_at',null)->where('estado','=','en expedicion')->get()}}</p>
    @foreach($pedidos as $pedido)
      @foreach($pedido->itemsPedidos as $item)
        <p hidden>{{${"litros_".$item->cerveza->nombre.$cliente->razonSocial} = ${"litros_".$item->cerveza->nombre.$cliente->razonSocial} + $item->cantidad}}</p>
      @endforeach
    @endforeach
  @endforeach


 <!-- Se obtiene litros totales de cada cerveza por cliente -->
 @foreach($clientes as $cliente)
    @foreach($cervezas as $cerveza)
      <p hidden>@php ${"totalLitros_".$cerveza->nombre.$cliente->razonSocial}= ${"litros_".$cerveza->nombre.$cliente->razonSocial}; @endphp</p>
    @endforeach
  @endforeach


<!-- Total litros por cliente -->

@foreach($clientes as $cliente)
<p hidden>{{${"totalLitros_".$cliente->razonSocial}=0}}</p>
  @foreach($cervezas as $cerveza)
  <p hidden> @php ${"totalLitros_".$cliente->razonSocial}+= ${"totalLitros_".$cerveza->nombre.$cliente->razonSocial}; @endphp</p>
  @endforeach
  @endforeach


<!-- Se determina cant garrafas x cerveza de cada cliente -->
  <p hidden>
    @foreach($clientes as $cliente)
    
      @foreach($cervezas as $cerveza)

      @while (${"litros_".$cerveza->nombre.$cliente->razonSocial}/20>=1)
          {{${"litros_".$cerveza->nombre.$cliente->razonSocial}-=20}}
          {{${"cantgarrafas20_".$cerveza->nombre.$cliente->razonSocial}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre.$cliente->razonSocial}/10>=1)
          {{${"litros_".$cerveza->nombre.$cliente->razonSocial}-=10}}
          {{${"cantgarrafas10_".$cerveza->nombre.$cliente->razonSocial}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre.$cliente->razonSocial}/5>=1)
          {{${"litros_".$cerveza->nombre.$cliente->razonSocial}-=5}}
          {{${"cantgarrafas5_".$cerveza->nombre.$cliente->razonSocial}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre.$cliente->razonSocial}/1>=1)
          {{${"litros_".$cerveza->nombre.$cliente->razonSocial}-=1}}
          {{${"cantgarrafas1_".$cerveza->nombre.$cliente->razonSocial}+=1}}
          @endwhile

      @endforeach
    
    @endforeach
  </p>


  <p hidden>{{$pedidosHoy=Pedido::where('deleted_at',null)->where('estado','=','en expedicion')->get()}}</p>

<center>

<div id="noImprime">
    <a href="{{route('expedicionCamion')}}" class="btn btn-warning mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Volver</a>
    <button type="button"  class="btn btn-outline-primary mt-3 " onclick="imprimir()">
        Imprimir / Exportar <i class="fa fa-print"></i>
    </button>
</div>
</center>

        <div class="card mt-3">
            <div class="card-header">
                <h2 class="text-center">Hoja ruta para descargar camión --- Pedidos para el {{Carbon::now()->addDays(1)->format('d-m-Y')}} </h2>
            </div>
            <div class="card-body text-center">

            @if(count($pedidosHoy)>0)

              @foreach($clientes as $cliente)

              @if(${"totalLitros_".$cliente->razonSocial}>0)
          
                <div class="col-md-11 mt-3">
                  <div class="card">
                      <div class="card-header">
                          Empresa : {{$cliente->razonSocial}}
                          <br>
                          Dirección : {{$cliente->direcciónEntrega}}
                          <br>
                          Total Litros : @php echo(${"totalLitros_".$cliente->razonSocial}); @endphp
                      </div>
                      <div class="card-body">
                          
                              
                              <div class="table-responsive">
                                  
                                      <table class="table table-bordered table-striped mb-0">
                                          <thead>
                                        
                                          <tr>
                                              <th class="sticky-top bg-light text-center" scope="col">Cerveza</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Garrafa 20 lts (unidades)</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Garrafa 10 lts (unidades)</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Garrafa 5 lts (unidades)</th>
                                              <th class="sticky-top bg-light text-center" scope="col">Garrafa 1 lt (unidades)</th>
                                              
                                          </tr>
                                          </thead>
                                          <tbody>
                                            @foreach($cervezas as $cerveza)
                                              <tr>
                                                  <th scope="row">{{$cerveza->nombre}}</th>
                                                  @if(${"cantgarrafas20_".$cerveza->nombre.$cliente->razonSocial}>0)
                                                  <td class="text-right">@php echo(${"cantgarrafas20_".$cerveza->nombre.$cliente->razonSocial}); @endphp <strong></strong></td>
                                                  @else
                                                  <td class="text-center"> - <strong></strong></td>
                                                  @endif
                                                  @if(${"cantgarrafas10_".$cerveza->nombre.$cliente->razonSocial}>0)
                                                  <td class="text-right">@php echo(${"cantgarrafas10_".$cerveza->nombre.$cliente->razonSocial}); @endphp <strong></strong></td>
                                                  @else
                                                  <td class="text-center"> - <strong></strong></td>
                                                  @endif
                                                  @if(${"cantgarrafas5_".$cerveza->nombre.$cliente->razonSocial}>0)
                                                  <td class="text-right">@php echo(${"cantgarrafas5_".$cerveza->nombre.$cliente->razonSocial}); @endphp <strong></strong></td>
                                                  @else
                                                  <td class="text-center"> - <strong></strong></td>
                                                  @endif
                                                  @if(${"cantgarrafas1_".$cerveza->nombre.$cliente->razonSocial}>0)
                                                  <td class="text-right">@php echo(${"cantgarrafas1_".$cerveza->nombre.$cliente->razonSocial}); @endphp <strong></strong></td>
                                                  @else
                                                  <td class="text-center"> - <strong></strong></td>
                                                  @endif
                                              </tr>

                                            @endforeach
                                          </tbody>
                                  </table>
                            
                              </div>
                          
                                            
                          
                      </div>                         
                  </div>
              
                </div>
              @endif  
              @endforeach
              @else
              <div class="col mt-4 alert alert-info alert-dismissible fade show text-center" role="alert">
                    <strong><i class="fa fa-info-circle"></i></strong> Por el momento, no hay pedidos a entregar!
									
              </div>
              @endif
           
            </div>
        </div>


<script type="text/javascript">
    function imprimir()
    {
        window.print();
    }
</script>
@endsection