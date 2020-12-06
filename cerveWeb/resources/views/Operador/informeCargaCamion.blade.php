@extends('templates.templateOperator')

@section('content')

@php
        use App\Cerveza;
        use Carbon\Carbon;
        $cervezas = Cerveza::all();
        @endphp
        @foreach($cervezas as $cerveza)
          <p hidden> {{${"litros_".$cerveza->nombre}=0}} </p>
        @endforeach
        <p hidden>
          @foreach($pedidos as $pedido)
            @foreach($pedido->itemsPedidos as $item)
              {{${"litros_".$item->cerveza->nombre} +=$item->cantidad}}
            @endforeach
          @endforeach
        </p>


<!-- Se obtiene total litros por cerveza -->
        
        @foreach($cervezas as $cerveza)
        @php ${"totalLitros_".$cerveza->nombre}=${"litros_".$cerveza->nombre};@endphp
        
        @endforeach
     

<!-- Se crean garrafas x cerveza -->
        <p hidden>
        @foreach($cervezas as $cerveza)
          {{${"cantgarrafas20_".$cerveza->nombre}=0}}
          {{${"cantgarrafas10_".$cerveza->nombre}=0}}
          {{${"cantgarrafas5_".$cerveza->nombre}=0}}
          {{${"cantgarrafas1_".$cerveza->nombre}=0}}
        @endforeach
        </p>

<!-- Se determina cant garrafas x cerveza -->
        <p hidden>
        @foreach($cervezas as $cerveza)
      
          @while (${"litros_".$cerveza->nombre}/20>=1)
          {{${"litros_".$cerveza->nombre}-=20}}
          {{${"cantgarrafas20_".$cerveza->nombre}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre}/10>=1)
          {{${"litros_".$cerveza->nombre}-=10}}
          {{${"cantgarrafas10_".$cerveza->nombre}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre}/5>=1)
          {{${"litros_".$cerveza->nombre}-=5}}
          {{${"cantgarrafas5_".$cerveza->nombre}+=1}}
          @endwhile

          @while (${"litros_".$cerveza->nombre}/1>=1)
          {{${"litros_".$cerveza->nombre}-=1}}
          {{${"cantgarrafas1_".$cerveza->nombre}+=1}}
          @endwhile

        @endforeach
        
        </p>

        <p hidden>
        {{$totalLitros=0}}
        {{$totalGarrafas=0}}
        {{$totalGarrafas20=0}}
        {{$totalGarrafas10=0}}
        {{$totalGarrafas5=0}}
        {{$totalGarrafas1=0}}
        </p>
        @foreach($cervezas as $cerveza)
          @php 
          
          $totalLitros+=${"totalLitros_".$cerveza->nombre};

          @endphp
        @endforeach

        
        @foreach($cervezas as $cerveza)
          @php 
            
            $totalGarrafas+=${"cantgarrafas20_".$cerveza->nombre} + ${"cantgarrafas10_".$cerveza->nombre}+ ${"cantgarrafas5_".$cerveza->nombre}+${"cantgarrafas1_".$cerveza->nombre};
            $totalGarrafas20+=${"cantgarrafas20_".$cerveza->nombre};
            $totalGarrafas10+=${"cantgarrafas10_".$cerveza->nombre};
            $totalGarrafas5+=${"cantgarrafas5_".$cerveza->nombre};
            $totalGarrafas1+=${"cantgarrafas1_".$cerveza->nombre};


          @endphp
        @endforeach


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
                <h2 class="text-center">Carga para el camión --- Pedidos para el {{Carbon::now()->addDays(1)->format('d-m-Y')}} </h2>
            </div>
            <div class="card-body">

                @if($totalLitros>0)
                <center>
                
                 <h3>Total litros a despachar: {{$totalLitros}} lts</h3>
                 <hr>
                </center>
                <br>
                <div style="float:right;">
                  <img src="{{ asset('imagenes/logo.png') }}" class="avatar" width="400">
                  <h4>Total Garrafas a cargar : {{$totalGarrafas}} unidades  </h4>

                  <br>
                  <h4>Resumen: </h4>
                  <br>

                  <ul>
                        @if($totalGarrafas20>0)
                        <li>Garrafas 20 Litros : {{$totalGarrafas20}} unidades</li>
                        @endif
                        @if($totalGarrafas10>0)
                        <li>Garrafas 10 Litros : {{$totalGarrafas10}}  unidades</li>
                        @endif
                        @if($totalGarrafas5>0)
                        <li>Garrafas 5 Litros : {{$totalGarrafas5}} unidades</li>
                        @endif
                        @if($totalGarrafas1>0)
                        <li>Garrafas 1 Litro : {{$totalGarrafas1}} unidades</li>
                        @endif
                </ul>
                </div>
                
                <div class="ml-5">
                @foreach($cervezas as $cerveza)

                @if(${"totalLitros_".$cerveza->nombre}>0)
                    <h4>Cerveza {{$cerveza->nombre}} : @php echo(${"totalLitros_".$cerveza->nombre}); @endphp lts  </h4>
                    <ul>
                        @if(${"cantgarrafas20_".$cerveza->nombre}>0)
                        <li>Garrafas 20 Litros : @php echo(${"cantgarrafas20_".$cerveza->nombre}); @endphp unidades</li>
                        @endif
                        @if(${"cantgarrafas10_".$cerveza->nombre}>0)
                        <li>Garrafas 10 Litros : @php echo(${"cantgarrafas10_".$cerveza->nombre}); @endphp unidades</li>
                        @endif
                        @if(${"cantgarrafas5_".$cerveza->nombre}>0)
                        <li>Garrafas 5 Litros : @php echo(${"cantgarrafas5_".$cerveza->nombre}); @endphp unidades</li>
                        @endif
                        @if(${"cantgarrafas1_".$cerveza->nombre}>0)
                        <li>Garrafas 1 Litro : @php echo(${"cantgarrafas1_".$cerveza->nombre}); @endphp unidades</li>
                        @endif
                    </ul>
                @endif
                @endforeach
                </div>

                
                
                
                @else
                <div class="col mt-4 alert alert-info alert-dismissible fade show text-center" role="alert">
                    <strong><i class="fa fa-info-circle"></i></strong> Por el momento, no hay garrafas de cervezas a cargar en el camion!
									
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