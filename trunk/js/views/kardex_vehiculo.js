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
			tabla(data) 
			//grafico(data)
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
	
	$('#tabla_resultado').html("");
	
	if(json[0]=='true')
	{
		var ingresos=0;
		var egresos=0;
		cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
		cont=cont+'<thead>';
		cont=cont+'<tr>';
		cont=cont+'<th>Fecha</th>';
		cont=cont+'<th>Placa de Vehículo</th>';
		cont=cont+'<th>Entrada</th>';
		cont=cont+'<th>Salida</th>';
		cont=cont+'<th>Existencia</th>';
		cont=cont+'<th>Decripción</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		
		for(i=1;i<n;i++)
		{
			cont=cont+'<tr>';
			cont=cont+'<td>'+json[i].fecha_transaccion+'</td>';
			cont=cont+'<td>'+json[i].placa+'</td>';
			if(json[i].tipo_transaccion=='ENTRADA')
			{
				cont=cont+'<td>'+json[i].cantidad+'</td>';
				cont=cont+'<td>Salida</td>';
			}
			cont=cont+'<td>Existencia</td>';
			cont=cont+'<td>'+json[i].descripcion+'</td>';
			cont=cont+'</tr>';
		}
		
		cont=cont+'</tbody>';
		cont=cont+'</table>';
	}
	else
	{
		cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
		cont=cont+'<thead>';
		cont=cont+'<tr>';
		cont=cont+'<th>Fecha</th>';
		cont=cont+'<th>Artículo</th>';
		cont=cont+'<th>Entrada</th>';
		cont=cont+'<th>Salida</th>';
		cont=cont+'<th>Existencia</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		cont=cont+'</tbody>';
		cont=cont+'</table>';
	}
	$('#tabla_resultado').html(cont);
	/*for (i=0;i<json.length;i++)
	{   
		fila= "<tr>" +
		"<td align='center'>" + json[i].row_number + "</td>" +
		"<td align='center'>" + json[i].seccion + "</td>" +
		"<td align='center'>" + json[i].asignado + "</td>" +
		"<td align='center'>" + json[i].entregado + "</td>" +
		"<td align='center'>"; 
		var series1=json[i].inicial.split(",");
		var series2=json[i].final.split(",");
		
		for (var j= 0; j < series1.length; j++)
		{
			fila+=series1[j]+" - "+ series2[j];
			if(j!=series1.length-1){ fila+="<br>"}
		}
		
		fila+= "</td>" +
		"</tr>";    
		$('#datos').append(fila)    
	}  */
}

function grafico(chartData, label)
{
	var color1 = "#ADD981";
	var color2 ="#27c5ff";
	var chart;
	color1 = $("#color1").val();
	color2 = $("#color2").val();
	
	
	// SERIAL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	chart.categoryField = label;
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
	valueAxis.title = "vales";
	valueAxis.minorGridEnabled = true;
	valueAxis.minorGridAlpha = 0.08;
	
	valueAxis.gridAlpha = 0.15;
	chart.addValueAxis(valueAxis);
	
	// GRAPHS
	// column graph
	var graph1 = new AmCharts.AmGraph();
	graph1.type = "column";
	graph1.title = "Consumido";
	graph1.valueField = "consumido";
	graph1.lineAlpha = 0;
	graph1.fillColors = color1;
	graph1.fillAlphas = 0.8;
	graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
	chart.addGraph(graph1);
	
	
	// column graph
	var graph2 = new AmCharts.AmGraph();
	graph2.type = "column";
	graph2.title = "Asignado";
	graph2.valueField = "asignado";
	graph2.lineAlpha=0;
	graph2.fillColors = color2
	graph2.fillAlphas = 0.8;
	graph2.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
	chart.addGraph(graph2);
	
	
	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.useGraphSettings = true;
	chart.addLegend(legend);
	
	chart.creditsPosition = "top-right";
	
	// WRITE
	chart.write("chartdiv");
}