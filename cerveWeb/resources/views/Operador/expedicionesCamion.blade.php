@extends('templates.templateOperator')

@section('content')
    
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse float-left">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
        @foreach($pedidos as $pedido)
          <li class="nav-item mt-2 mb-2">
            <center>
                <a type="button" class="text-info" data-toggle="modal" data-target="#_{{$pedido->id}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Pedido {{$pedido->id}}
                </a>
            </center>
          </li>
        @endforeach
        </ul>
        <hr>
        <ul class="nav flex-column mb-2 text-center">
          <li class="nav-item">
            <a type="button" class="text-info" data-toggle="modal" data-target="#_informe">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              Informe cervezas
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <h1 style="color:goldenrod; margin-right:220px;" class="h3 mt-5 font-weight-normal text-center"> Información del camion <img src="https://img.icons8.com/plasticine/80/000000/truck.png"/> </h1>
    @if($litrosTotales!=1500)
    <h4 style="color:goldenrod; margin-right:220px;" class="text-center">(Quedan {{1500-$litrosTotales}} lts de capacidad)</h4>
    @else
    <h4 style="color:goldenrod; margin-right:220px;" class="text-center">(El camión se encuentra lleno!)</h4>
    @endif
     
    <center>
    @if(count($pedidosPostergados)>0)
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>Debido a falta de stock, estos son los pedidos postergados para mañana :</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>
                    @foreach($pedidosPostergados as $number)
                      <h3>Pedido n° {{$number}}</h3>
                    @endforeach                   
        </div>
    @endif
    </center> <br>
    <center>
    @if(count($pedidosPostergadosCapacidad)>0)
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>Debido a exceso de capacidad del camion, estos son los pedidos postergados para mañana :</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>
                    @foreach($pedidosPostergadosCapacidad as $number)
                      <h3>Pedido n° {{$number}}</h3>
                    @endforeach                   
        </div>
    @endif
    </center>


    <center>
    @php
      use Carbon\Carbon;
    @endphp
    @if($litrosTotales==1500 & Carbon::now()->format('H:i:s')>='20:00:00')
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno y no se toman mas pedidos, presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif($litrosTotales==1500)
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno, presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif(Carbon::now()->format('H:i:s')>='20:00:00')
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>No se toman más pedidos, presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    
    </center> <br>
    @endif

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
    if({{$litrosTotales}} !=null)
    {
      var value = {{$litrosTotales}};
    }
    else
    {
      var value=0;
    }
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
    <div style="position: relative; margin-left:170px;">
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

        
      
        @php
        use App\Cerveza;
        $cervezas = Cerveza::all()->where('deleted_at',null);
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
        <!-- Modal Informe -->
        <div class="modal fade" id="_informe" tabindex="-1" role="dialog" aria-labelledby="_informe" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cervezas Por Litro</h5>
                        
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                           <!-- Styles -->
<style>
#chartdiv2 {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

/**
 * Chart design taken from Samsung health app
 */

var chart = am4core.create("chartdiv2", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.paddingBottom = 30;

chart.data = [
  
  @foreach($cervezas as $cerveza)
  {
    "name": "{{$cerveza->nombre}}",
    "steps":  @json(${"litros_".$cerveza->nombre}),
    "href": "{{$cerveza->image}}"
  },
  @endforeach
];

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "name";
categoryAxis.renderer.grid.template.strokeOpacity = 0;
categoryAxis.renderer.minGridDistance = 10;
categoryAxis.renderer.labels.template.dy = 35;
categoryAxis.renderer.tooltip.dy = 35;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.fillOpacity = 0.3;
valueAxis.renderer.grid.template.strokeOpacity = 0;
valueAxis.min = 0;
valueAxis.cursorTooltipEnabled = false;
valueAxis.renderer.baseGrid.strokeOpacity = 0;

var series = chart.series.push(new am4charts.ColumnSeries);
series.dataFields.valueY = "steps";
series.dataFields.categoryX = "name";
series.tooltipText = "{valueY.value}";
series.tooltip.pointerOrientation = "vertical";
series.tooltip.dy = - 6;
series.columnsContainer.zIndex = 100;

var columnTemplate = series.columns.template;
columnTemplate.width = am4core.percent(50);
columnTemplate.maxWidth = 66;
columnTemplate.column.cornerRadius(60, 60, 10, 10);
columnTemplate.strokeOpacity = 0;

series.heatRules.push({ target: columnTemplate, property: "fill", dataField: "valueY", min: am4core.color("#e5dc36"), max: am4core.color("#5faa46") });
series.mainContainer.mask = undefined;

var cursor = new am4charts.XYCursor();
chart.cursor = cursor;
cursor.lineX.disabled = true;
cursor.lineY.disabled = true;
cursor.behavior = "none";

var bullet = columnTemplate.createChild(am4charts.CircleBullet);
bullet.circle.radius = 30;
bullet.valign = "bottom";
bullet.align = "center";
bullet.isMeasured = true;
bullet.mouseEnabled = false;
bullet.verticalCenter = "bottom";
bullet.interactionsEnabled = false;

var hoverState = bullet.states.create("hover");
var outlineCircle = bullet.createChild(am4core.Circle);
outlineCircle.adapter.add("radius", function (radius, target) {
    var circleBullet = target.parent;
    return circleBullet.circle.pixelRadius + 10;
})

var image = bullet.createChild(am4core.Image);
image.width = 60;
image.height = 60;
image.horizontalCenter = "middle";
image.verticalCenter = "middle";
image.propertyFields.href = "href";

image.adapter.add("mask", function (mask, target) {
    var circleBullet = target.parent;
    return circleBullet.circle;
})

var previousBullet;
chart.cursor.events.on("cursorpositionchanged", function (event) {
    var dataItem = series.tooltipDataItem;

    if (dataItem.column) {
        var bullet = dataItem.column.children.getIndex(1);

        if (previousBullet && previousBullet != bullet) {
            previousBullet.isHover = false;
        }

        if (previousBullet != bullet) {

            var hs = bullet.states.getKey("hover");
            hs.properties.dy = -bullet.parent.pixelHeight + 30;
            bullet.isHover = true;

            previousBullet = bullet;
        }
    }
})

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv2"></div>
                       </div>
                       <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success btn-lg" data-dismiss="modal"><i class="fa fa-check"></i></button>
                       </div>
                    </div>
                </div>
            </div>
            <!-- -->


            <p>
 
              
              @if($litrosTotales==1500 || (Carbon::now()->format('H:i:s')>='20:00:00'))
              <a href="#" class="btn btn-success  btn-lg float-right mr-3 mt-3">Despachar Camión <i class="fa fa-truck"></i></a>
              @endif
              <a href="{{route('listadoPedidosEntrega')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Ver pedidos</a>
             
            </p>



@endsection