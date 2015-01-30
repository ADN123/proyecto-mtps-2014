// JavaScript Document
$(document).ready(function()
{
	function startChange()
	{
		var startDate = start.value(),
		endDate = end.value();
	
		if (startDate) 
		{
			//startDate = new Date(2014,07,01);
			startDate.setDate(startDate.getDate());
			end.min(startDate);
		}
		else if (endDate)
		{
			start.max(new Date(endDate));
		}
		else
		{
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	
	function endChange()
	{
		var endDate = end.value(),
		startDate = start.value();
	
		if (endDate)
		{
			endDate = new Date(endDate);
			endDate.setDate(endDate.getDate());
			start.max(endDate);
		}
		else if (startDate)
		{
			end.min(new Date(startDate));
		}
		else
		{
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	
	var start = $("#fecha_inicial").kendoDatePicker({
		change: startChange,
		format: "dd-MM-yyyy"		 
	}).data("kendoDatePicker");

	var end = $("#fecha_final").kendoDatePicker({
		change: endChange,
		format: "dd-MM-yyyy" 
	}).data("kendoDatePicker");

	start.max(end.value());
	end.min(start.value());
});

$("#Filtrar").click(function()
{             
	var formu = $('#filtro').serializeArray();
	//    console.log(formu); 
	reporte(formu);
});


function reporte(formu)
{  
	$.ajax({  //para articulos
		async: true, 
		url: base_url()+"index.php/vehiculo/kardex_articulo_json",
		dataType: "json",
		type: "POST",
		data: formu,
		success: function(data)
		{
			tabla(data), 
			grafico(data)
		},
		error:function(data)
		{
			alertify.alert('Error al cargar datos de los articulos');
		}
	});
}

function tabla(json)
{
	var cont='';
	var n=json.length;
	var filtro=document.getElementById('id_articulo');
	$('#tabla_resultado').html("");
	
	if(filtro.value!='' && filtro.value!=0)
	{
		var ingresos=0;
		var egresos=0;
		cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
		cont=cont+'<thead>';
		cont=cont+'<tr>';
		cont=cont+'<th width="90px" align="center">Fecha</th>';
		cont=cont+'<th width="120px" align="center">Placa de Vehículo</th>';
		cont=cont+'<th width="80px" align="center">Entrada</th>';
		cont=cont+'<th width="80px" align="center">Salida</th>';
		cont=cont+'<th width="80px" align="center">Existencia</th>';
		cont=cont+'<th>Decripción</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		
		for(i=0;i<n;i++)
		{
			cont=cont+'<tr>';
			cont=cont+'<td>'+json[i].fecha_transaccion+'</td>';
			cont=cont+'<td>'+json[i].placa+'</td>';
			if(json[i].tipo_transaccion=='ENTRADA')
			{
				cont=cont+'<td align="rigth">'+json[i].cantidad+'</td>';
				cont=cont+'<td>&nbsp;</td>';
				ingresos=ingresos+parseFloat(json[i].cantidad);
			}
			else if(json[i].tipo_transaccion=='SALIDA')
			{
				cont=cont+'<td>&nbsp;</td>';
				cont=cont+'<td align="right">'+json[i].cantidad+'</td>';
				egresos=egresos+parseFloat(json[i].cantidad);
			}
			cont=cont+'<td align="right">'+parseFloat(ingresos-egresos)+'</td>';
			cont=cont+'<td>'+json[i].descripcion+'</td>';
			cont=cont+'</tr>';
		}
		
		cont=cont+'</tbody>';
		cont=cont+'</table>';
	}
	else
	{
		var ingresos=0;
		var egresos=0;
		cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
		cont=cont+'<thead>';
		cont=cont+'<tr>';
		cont=cont+'<th width="90px" align="center">Fecha</th>';
		cont=cont+'<th width="120px" align="center">Artículo</th>';
		cont=cont+'<th width="80px" align="center">Entrada</th>';
		cont=cont+'<th width="80px" align="center">Salida</th>';
		cont=cont+'<th width="80px" align="center">Existencia</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		
		for(i=0;i<n;i++)
		{
			cont=cont+'<tr>';
			cont=cont+'<td>'+json[i].fecha_transaccion+'</td>';
			cont=cont+'<td>'+json[i].nombre+'</td>';
			if(json[i].tipo_transaccion=='ENTRADA')
			{
				cont=cont+'<td align="rigth">'+json[i].cantidad+'</td>';
				cont=cont+'<td>&nbsp;</td>';
				ingresos=ingresos+parseFloat(json[i].cantidad);
			}
			else if(json[i].tipo_transaccion=='SALIDA')
			{
				cont=cont+'<td>&nbsp;</td>';
				cont=cont+'<td align="right">'+json[i].cantidad+'</td>';
				egresos=egresos+parseFloat(json[i].cantidad);
			}
			cont=cont+'<td align="right">'+parseFloat(ingresos-egresos)+'</td>';
			cont=cont+'</tr>';
		}
		
		cont=cont+'</tbody>';
		cont=cont+'</table>';
	}
	$('#tabla_resultado').html(cont);	
}

function grafico(chartData)
{
	var color1 = "#ADD981";
	var color2 ="#27c5ff";
	var filtro=document.getElementById('id_articulo');
	var titulo;
	var chart;
	//color1 = $("#color1").val();
	//color2 = $("#color2").val();
	
	// SERIAL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	if(filtro.value!='' && filtro.value!=0)
	{
		titulo='KARDEX DE INSUMOS';
		chart.categoryField = "placa";
	}
	else
	{
		titulo='MATERIALES EN EXISTENCIA EN BODEGA DE TALLER INSTITUCIONAL';
		chart.categoryField = "nombre";
	}
	chart.startDuration = 1;
	chart.rotate = true;
	
	// AXES
	// category
	var categoryAxis = chart.categoryAxis;
	categoryAxis.gridPosition = "start";
	categoryAxis.axisColor = "#DADADA";
	categoryAxis.dashLength = 3;
	
	// value
	var valueAxis = new AmCharts.ValueAxis();
	valueAxis.dashLength = 3;
	valueAxis.axisAlpha = 0.2;
	valueAxis.position = "top";
	valueAxis.title = titulo;
	valueAxis.minorGridEnabled = true;
	valueAxis.minorGridAlpha = 0.08;
	
	valueAxis.gridAlpha = 0.15;
	chart.addValueAxis(valueAxis);
	
	// GRAPHS
	// column graph
	if(filtro.value!='' && filtro.value!=0)
	{
		var graph1 = new AmCharts.AmGraph();
		graph1.type = "column";
		graph1.title = "cantidad usada";
		graph1.valueField = "cant_usada";
		graph1.lineAlpha = 0;
		graph1.fillColors = color1;
		graph1.fillAlphas = 0.8;
		graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph1);
	}
	else
	{	
		// column graph
		var graph2 = new AmCharts.AmGraph();
		graph2.type = "column";
		graph2.title = "Existencia";
		graph2.valueField = "existencias";
		graph2.lineAlpha=0;
		graph2.fillColors = color2
		graph2.fillAlphas = 0.8;
		graph2.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph2);
	}
	
	
	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.useGraphSettings = true;
	chart.addLegend(legend);
	
	chart.creditsPosition = "top-right";
	
	// WRITE
	chart.write("chartdiv");
}