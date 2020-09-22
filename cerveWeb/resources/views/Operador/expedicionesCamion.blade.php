@extends('templates.templateOperator')

@section('content')
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
        @foreach($pedidos as $pedido)
          <li class="nav-item mt-2 mb-2">
            <center>
                <a type="button" class="text-info" data-toggle="modal" data-target="#_{{$pedido->id}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Pedido {{$pedido->id}}
                <a>
            </center>
          </li>
        @endforeach
          
        </ul>
      </div>
    </nav>

    <!-- Styles -->
    <style>
    #chartdiv {
      width: 100%;
      height: 500px;
    }
    </style>

    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/plugins/venn.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Chart code -->
    <script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    var capacity = 1500;
    var value = 1300;
    var circleSize = 0.57;

    var component = am4core.create("chartdiv", am4core.Container)
    component.width = am4core.percent(100);
    component.height = am4core.percent(100);

    var chartContainer = component.createChild(am4core.Container);
    chartContainer.x = am4core.percent(50)
    chartContainer.y = am4core.percent(50)

    var circle = chartContainer.createChild(am4core.Circle);
    circle.fill = am4core.color("#dadada");

    var circleMask = chartContainer.createChild(am4core.Circle);

    var waves = chartContainer.createChild(am4core.WavedRectangle);
    waves.fill = am4core.color("goldenrod");
    waves.mask = circleMask;
    waves.horizontalCenter = "middle";
    waves.waveHeight = 10;
    waves.waveLength = 30;
    waves.y = 500;
    circleMask.y = -500;

    component.events.on("maxsizechanged", function(){
      var smallerSize = Math.min(component.pixelWidth, component.pixelHeight);  
      var radius = smallerSize * circleSize / 2;

      circle.radius = radius;
      circleMask.radius = radius;
      waves.height = smallerSize;
      waves.width = Math.max(component.pixelWidth, component.pixelHeight);  

      //capacityLabel.y = radius;

      var labelRadius = radius + 20

      capacityLabel.path = am4core.path.moveTo({x:-labelRadius, y:0}) + am4core.path.arcToPoint({x:labelRadius, y:0}, labelRadius, labelRadius);
      capacityLabel.locationOnPath = 0.5;

      setValue(value);
    })


    function setValue(value){
      var y = - circle.radius - waves.waveHeight + (1 - value / capacity) * circle.pixelRadius * 2;
      waves.animate([{property:"y", to:y}, {property:"waveHeight", to:10, from:15}, {property:"x", from:-50, to:0}], 5000, am4core.ease.elasticOut);
      circleMask.animate([{property:"y", to:-y},{property:"x", from:50, to:0}], 5000, am4core.ease.elasticOut);
    }


    var label = chartContainer.createChild(am4core.Label)
    var formattedValue = component.numberFormatter.format(value, "#.#a");
    formattedValue = formattedValue.toUpperCase();

    label.text = formattedValue + " Litros";
    label.fill = am4core.color("gold");
    label.fontSize = 30;
    label.horizontalCenter = "middle";


    var capacityLabel = chartContainer.createChild(am4core.Label)

    var formattedCapacity = component.numberFormatter.format(capacity, "#.#a").toUpperCase();;

    capacityLabel.text = "Capacidad : " + formattedCapacity + " Litros";
    capacityLabel.fill = am4core.color("#fff");
    capacityLabel.fontSize = 20;
    capacityLabel.textAlign = "middle";
    capacityLabel.padding(0,0,0,0);

    }); // end am4core.ready()
    </script>

    <!-- HTML -->
    <center>
    <div style="position: relative;">
      <div class="carga" id="chartdiv"></div>
      <div class="camion">
        <img src="https://img.icons8.com/officel/560/000000/truck.png"/>
      </div>
    </div>
    </center>
    @foreach($pedidos as $pedido)        
            <!-- Modal -->
             <div class="modal fade" id="_{{$pedido->id}}" tabindex="-1" role="dialog" aria-labelledby="_{{$pedido->id}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Acciones sobre pedido {{$pedido->id}}</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                            <center>
                            <a href="{{route('mostrarFactura',$pedido->id)}}" class="btn btn-outline-primary">
                                Ver Factura
                            </a>
                            <a href="{{route('mostrarRemito',$pedido->id)}}" class="btn btn-outline-warning">
                                Ver Remito
                            </a>
                            
                            
                            </center>
                       </div>
                       <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->  
         @endforeach

         @if(session('error'))
            <div class=" col-md-6 float-left mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{session('error')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif



@endsection