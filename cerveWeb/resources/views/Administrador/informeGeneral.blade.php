@extends('templates.templateAdmin')

@section('content')

    @php
    use App\Http\Controllers\PedidoController;
    use App\Http\Controllers\CervezaController;
    use App\Http\Controllers\CompraController;
    use Carbon\Carbon;
    $pedidoController = new PedidoController();
    $cervezaController = new CervezaController();
    $compraController = new CompraController();
    @endphp

    <style type="text/css" media="print">
      @media print {
      #noImprime {display:none;}
      }
    </style>


    <h1 class="text-center"  style="color:goldenrod;"><img src="https://img.icons8.com/doodle/48/000000/business-report.png"/> INFORME GENERAL DESDE {{Carbon::parse($fechaDesde)->format('d-m-Y')}} HASTA {{Carbon::parse($fechaHasta)->format('d-m-Y')}}</h1>

<center>

      <div id="noImprime">
        <a href="{{route('informes')}}" class="btn btn-warning mr-3 mt-3"><i class="fa fa-chevron-circle-left"></i> Volver</a>
        <button type="button"  class="btn btn-outline-primary mt-3 " onclick="imprimir()">
            Imprimir / Exportar <i class="fa fa-print"></i>
        </button>
        <button type="button"  class="btn btn-outline-warning mt-3" data-toggle="modal" data-target="#_{{1}}">
            Seleccionar Período Analisis <i class="fa fa-calendar"></i>
        </button>
      </div>
</center>
    <h2>Fecha Informe: {{Carbon::now()->format('d-m-Y')}}</h2>

    <p hidden>{{$totalVenta=0}}</p>
    <p hidden>{{$totalLitrosVendidos=0}}</p>
    <p hidden>{{$cervezaMasVendida=null}}</p>
    <p hidden>{{$litrosVendidos=0}}</p>
    <p hidden>{{$totallitrosComprados=0}}</p>
    <p hidden>{{$totalCompra=0}}</p>
    <p hidden>{{$cantPedidos=0}}</p>
    <p hidden>{{$mejorCliente=null}}</p>


    <h1 class="text-center"  style="color:goldenrod;"><img src="https://img.icons8.com/color/48/000000/shopping-cart.png"/> COMPRAS</h1>


<!-- Obtencion total litros y compra x proveedor -->

  @foreach($proveedores as $proveedor)
    <p hidden>{{${"litros_".$proveedor->razonSocial}=0}}</p>
    <p hidden>{{${"totalCompra_".$proveedor->razonSocial}=0}}</p>
    <p hidden>{{$compras=$compraController->getComprasByProveedor($proveedor->id,$fechaDesde,$fechaHasta)}}</p>
    @foreach($compras as $compra)
      @php ${"litros_".$proveedor->razonSocial}+=$compra->cantidad;@endphp
      @php ${"totalCompra_".$proveedor->razonSocial}+=$compra->total;@endphp
    @endforeach
    @php $totallitrosComprados+=${"litros_".$proveedor->razonSocial};@endphp
    @php $totalCompra+=${"totalCompra_".$proveedor->razonSocial};@endphp</p>
  @endforeach


<!-- Obtencion Proveedor más solicitado -->
<p hidden>{{$provedoresMasSolicitado=null}}</p>
<p hidden>{{$mayor=0}}</p>
@foreach($proveedores as $proveedor)
  @if(${"litros_".$proveedor->razonSocial}>$mayor)
  @php
  $mayor=${"litros_".$proveedor->razonSocial};
  $provedoresMasSolicitado= $proveedor->razonSocial;
  @endphp
  @endif
@endforeach


<!-- Obtencion total litros comprados x cerveza -->

  @foreach($cervezas as $cerveza)
  <p hidden>{{${"litrosComprados_".$cerveza->nombre}=0}}</p>
  <p hidden>{{$compras=$compraController->getComprasByCerveza($cerveza->id,$fechaDesde,$fechaHasta)}}</p>
  @foreach($compras as $compra)
      @php ${"litrosComprados_".$cerveza->nombre}+=$compra->cantidad;@endphp
    @endforeach
  @endforeach


<!-- Obtencion Cerveza más requerida -->
<p hidden>{{$cervezaRequerida=null}}</p>
<p hidden>{{$mayor=0}}</p>
@foreach($cervezas as $cerveza)
  @if(${"litrosComprados_".$cerveza->nombre}>$mayor)
    @php
    $mayor=${"litrosComprados_".$cerveza->nombre};
    $cervezaRequerida= $cerveza->nombre;
    @endphp
  @endif
@endforeach


<!-- Obtencion total litros vendidos x cliente -->

@foreach($clientes as $cliente)
  <p hidden>{{${"litrosVendidos_".$cliente->razonSocial}=0}}</p>
  <p hidden>{{$pedidos=$pedidoController->getPedidosVendidosCliente($cliente->id,$fechaDesde,$fechaHasta)}}</p>
  @foreach($pedidos as $pedido)
    @foreach($pedido->itemsPedidos as $item)
      @php ${"litrosVendidos_".$cliente->razonSocial}+=$item->cantidad;@endphp
    @endforeach
  @endforeach
@endforeach

<p hidden>{{$mayorVenta=0}}</p>
@foreach($clientes as $cliente)
  @if(${"litrosVendidos_".$cliente->razonSocial}>$mayorVenta)
  @php $mayorVenta= ${"litrosVendidos_".$cliente->razonSocial};@endphp
  <p hidden>{{$mejorCliente=$cliente->razonSocial}}</p>
  @endif
@endforeach

<!-- Obtencion total ingresos x venta x cliente y total -->

@foreach($clientes as $cliente)
  <p hidden>{{${"totalVenta".$cliente->razonSocial}=0}}</p>
  <p hidden>{{$pedidos=$pedidoController->getPedidosVendidosCliente($cliente->id,$fechaDesde,$fechaHasta)}}</p>
  <p hidden>{{$cantPedidos+=count($pedidos)}}</p>
  @foreach($pedidos as $pedido)
    @foreach($pedido->itemsPedidos as $item)
    <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$pedido->created_at)}}</p>
      @php ${"totalVenta".$cliente->razonSocial}+=$item->cantidad * $precioCerveza;@endphp
    @endforeach
   
  @endforeach

  @php
    $totalVenta+=${"totalVenta".$cliente->razonSocial};
    @endphp
@endforeach



<!-- Obtencion litros vendidos x cerveza -->
@foreach($cervezas as $cerveza)
        <p hidden>{{${"litros_".$cerveza->nombre}=0}}</p>
        @php
            $itemspedidos=$pedidoController->getItemPedidosFecha($cerveza,$fechaDesde,$fechaHasta);
        @endphp
        @foreach($itemspedidos as $item)
        <p hidden>{{$precioCerveza=$cervezaController->getPrecioVigente($item->cerveza->id,$item->pedido->created_at)}}</p> 
        <p hidden>{{${"litros_".$cerveza->nombre}+=$item->cantidad}}</p>
        
        @endforeach

        @php $totalLitrosVendidos+=${"litros_".$cerveza->nombre}; @endphp

    @endforeach


    <!-- Obtencion Cerveza más vendida -->
    @foreach($cervezas as $cerveza)
      @if(${"litros_".$cerveza->nombre}>$litrosVendidos)
      @php $litrosVendidos= ${"litros_".$cerveza->nombre};@endphp
      <p hidden>{{$cervezaMasVendida= $cerveza->nombre}}</p>
      @endif
    @endforeach


<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 300px;
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

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data

chart.data = [
  
  @foreach($proveedores as $proveedor)
  {
    "provider": "{{$proveedor->razonSocial}}",
    "litres":  @json(${"litros_".$proveedor->razonSocial}),
  },
  @endforeach
];


// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "provider";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "litres";
series.dataFields.categoryX = "provider";
series.name = "Litres";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<!-- HTML -->
<div>
  
  <h3 class="text-center">Litros comprados x proveedor</h3>
  @if($totallitrosComprados>0)
  <div id="chartdiv" >
  </div>
  @else
  <center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen compras realizadas en el periodo solicitado!</i></h4>
        </div>
</center>
  @endif
</div>




<!-- Styles -->
<style>
#chartdiv3 {
  width: 100%;
  height: 200px;
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

// Create chart instance
var chart = am4core.create("chartdiv3", am4charts.PieChart);

// Add data
chart.data = [
  
  @foreach($proveedores as $proveedor)
  {
    "provider": "{{$proveedor->razonSocial}}",
    "cost":  @json(${"totalCompra_".$proveedor->razonSocial}),
  },
  @endforeach
];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "cost";
pieSeries.dataFields.category = "provider";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

chart.hiddenState.properties.radius = am4core.percent(0);


}); // end am4core.ready()
</script>

<!-- HTML -->
<div>
  
  <h3 class="text-center">Distribución costo x proveedor</h3>
  @if($totallitrosComprados>0)
  <div id="chartdiv3"></div>
  @else
  <center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen compras realizadas en el periodo solicitado!</i></h4>
        </div>
</center>
  @endif
</div>


<!-- Styles -->
<style>
#chartdiv4 {
  width: 100%;
  height: 400px;
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

var chart = am4core.create("chartdiv4", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.paddingBottom = 30;

chart.data = [
  
  @foreach($cervezas as $cerveza)
  {
    "name": "{{$cerveza->nombre}}",
    "steps":  @json(${"litrosComprados_".$cerveza->nombre}),
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
<h3 class="text-center mt-4">Litros comprados x cerveza</h3>
@if($totallitrosComprados>0)
<div id="chartdiv4"></div>
@else
<center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen compras realizadas en el periodo solicitado!</i></h4>
        </div>
</center>
@endif

    <center>
      <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
          <h2 class="alert-heading">Información Compras</h2>
          <hr>
          <h4><strong>Total costo Compra: $</strong> {{number_format($totalCompra,2)}}</h4>
          <h4><strong>Total litros comprados: </strong> {{$totallitrosComprados}} lts</h4>
          <h4><strong>Proveedor más solicitado: </strong> {{$provedoresMasSolicitado}}</h4>
          <h4><strong>Cerveza mas requerida: </strong> {{$cervezaRequerida}}</h4>
      </div>
    </center>




    <h1 class="text-center ml-5"  style="color:goldenrod;"><img src="https://img.icons8.com/dusk/64/000000/sell.png"/> VENTAS</h1>



    <!-- Styles -->
<style>
#chartdiv5 {
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

// Create chart instance
var chart = am4core.create("chartdiv5", am4charts.XYChart);

// Add data

chart.data = [
  
  @foreach($clientes as $cliente)
  @if(${"litrosVendidos_".$cliente->razonSocial}>0)
  {
    "customer": "{{$cliente->razonSocial}}",
    "litres":  @json(${"litrosVendidos_".$cliente->razonSocial}),
  },
  @endif
  @endforeach
];


// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "customer";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "litres";
series.dataFields.categoryX = "customer";
series.name = "Litres";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<!-- HTML -->
<div>
  
  <h3 class="text-center">Litros vendidos x cliente</h3>
  @if($totalLitrosVendidos>0)
  <div id="chartdiv5" ></div>
  @else
  <center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen ventas de cervezas en el periodo solicitado!</i></h4>
        </div>
  </center>
  @endif
</div>

<!-- Styles -->
<style>
#chartdiv6 {
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

// Create chart instance
var chart = am4core.create("chartdiv6", am4charts.PieChart);

// Add data
chart.data = [
  
  @foreach($clientes as $cliente)
  @if(${"litrosVendidos_".$cliente->razonSocial}>0)
  {
    "beer": "{{$cliente->razonSocial}}",
    "litres":  @json(${"litrosVendidos_".$cliente->razonSocial}),
  },
  @endif
  @endforeach
];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "beer";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()
</script>

<!-- HTML -->
<h3 class="text-center mt-4">Distribución ventas x cliente</h3>
@if($totalLitrosVendidos>0)
<div id="chartdiv6"></div>
@else
<center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen ventas de cervezas en el periodo solicitado!</i></h4>
        </div>
  </center>
@endif



<!-- Styles -->
<style>
#chartdiv7 {
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

var chart = am4core.create("chartdiv7", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.paddingBottom = 30;

chart.data = [
  
  @foreach($cervezas as $cerveza)
  @if(${"litros_".$cerveza->nombre}>0)
  {
    "name": "{{$cerveza->nombre}}",
    "steps":  @json(${"litros_".$cerveza->nombre}),
    "href": "{{$cerveza->image}}"
  },
  @endif
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
<h3 class="text-center" style="margin-top:320px;">Litros vendidos x cerveza</h3>
@if($totalLitrosVendidos>0)
<div id="chartdiv7"></div>
@else
<center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen ventas de cervezas en el periodo solicitado!</i></h4>
        </div>
  </center>
@endif




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

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.PieChart);

// Add data
chart.data = [
  
  @foreach($cervezas as $cerveza)
  @if(${"litros_".$cerveza->nombre}>0)
  {
    "beer": "{{$cerveza->nombre}}",
    "litres":  @json(${"litros_".$cerveza->nombre}),
  },
  @endif
  @endforeach
];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "beer";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()
</script>

<!-- HTML -->
<h3 class="text-center mt-4">Distribución ventas x cerveza</h3>
@if($totalLitrosVendidos>0)
  <div id="chartdiv2"></div>
@else
  <center>
        <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
            <h2 class="alert-heading"><i class="fa fa-info"> No existen ventas de cervezas en el periodo solicitado!</i></h4>
        </div>
  </center>
@endif




<center>
      <div class="alert alert-info col-md-6 mt-5 text-center" role="alert">
          <h2 class="alert-heading">Información Ventas</h4>
          <hr>
          <h4><strong>Total ingreso x Ventas: $</strong> {{number_format($totalVenta,2)}}</h4>
          <h4><strong>Total litros vendidos: </strong> {{$totalLitrosVendidos}} lts</h4>
          <h4><strong>Mejor Cliente: </strong>{{$mejorCliente}}</h4>
          <h4><strong>Cerveza más vendida: </strong>{{$cervezaMasVendida}}</h4>
          <h4><strong>Pedidos Entregados: </strong> {{$cantPedidos}}</h4>
      </div>
</center>



    <!-- Modal -->
<form method="GET" action="{{route('informeGerencial')}}">
            @csrf
             <div class="modal fade" id="_{{1}}" tabindex="-1" role="dialog" aria-labelledby="_{{1}}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Informe General</h5>
    
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                       </div>
                       <div class="modal-body">
                           <center>
                             Desde que fecha desea conocer información acerca de sus compras y ventas?<br><hr>
                            
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
    
