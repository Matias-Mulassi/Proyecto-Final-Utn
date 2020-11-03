@extends('templates.templateOperator')

@section('content')
    <center>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
                <h1 style="color:goldenrod;" class="h3 mt-5 font-weight-normal">Pedidos con fecha de entrega {{$nombreDia}}, {{$fechaMañana}} <i class='fas fa-clipboard-list'></i></h1>
                     

        
        
        
        <div class="col-md-10 mt-4">
            <div class="card text-center mt-5">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('listadoPedidosEntrega')}}">Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('mostrarCamion')}}">Camión</a>
                </li>
                </ul>
            </div>
            <div class="card-body">
    
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
    @php
      use Carbon\Carbon;
    @endphp
    @if($litrosTotales==1500 & Carbon::now()->format('H:i:s')>='20:00:00')
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno y no se toman mas pedidos. Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia.Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif($litrosTotales==1500)
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>El camión se encuentra lleno.Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia. Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    </center> <br>
    @elseif(Carbon::now()->format('H:i:s')>='20:00:00')
    <center>
        <div class=" col-md-6 mt-2 mb-3 alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fa fa-info-circle fa-4x float-left"></i> <br>  <strong>No se toman más pedidos.Todos los nuevos pedidos que ingresar a partir de ahora son postergados 1 dia. Presione "Despachar camión" para enviar todos los pedidos</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span> 
                    </button>               
        </div>
    
    </center> <br>
    @endif

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


            </div>
            </div>
        </div>
    </center>

    <p>
 

        <a href="{{route('home')}}" class="btn btn-warning  btn-lg float-right mr-3 mt-5"><i class="fa fa-chevron-circle-left"></i> Menu Principal</a>

    </p>







@endsection