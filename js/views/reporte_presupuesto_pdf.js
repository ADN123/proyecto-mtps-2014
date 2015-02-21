// JavaScript Document
function tabla(json)
{
	var cont='';
	var n=json.length;
	$('#tabla_resultado').html("");
	
	if(filtro!='' && filtro!=0)
	{
		cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
		cont=cont+'<thead>';
		cont=cont+'<tr>';
		cont=cont+'<th align="center">ID</th>';
		cont=cont+'<th align="center">Presupuesto($)</th>';
		cont=cont+'<th align="center">Gasto($)</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		
		for(i=0;i<n;i++)
		{
			cont=cont+'<tr>';
			cont=cont+'<td align="center">'+json[i].id_presupuesto+'</td>';
			cont=cont+'<td align="right">'+json[i].presupuesto+'</td>';
			cont=cont+'<td align="right">'+json[i].gasto+'</td>';
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
		cont=cont+'<th align="center">ID</th>';
		cont=cont+'<th align="center">Presupuesto($)</th>';
		cont=cont+'<th align="center">Gasto en Mtto. Interno($)</th>';
		cont=cont+'<th align="center">Gasto en Mtto. Externo($)</th>';
		cont=cont+'<th align="center">Gasto Total($)</th>';
		if(filtro2!=0 && filtro2!='')cont=cont+'<th align="center">Placa</th>';
		cont=cont+'</tr>';
		cont=cont+'</thead>';
		cont=cont+'<tbody>';
		
		for(i=0;i<n;i++)
		{
			cont=cont+'<tr>';
			cont=cont+'<td align="center">'+json[i].id_presupuesto+'</td>';
			cont=cont+'<td align="right">'+json[i].presupuesto+'</td>';
			cont=cont+'<td align="right">'+json[i].gasto_interno+'</td>';
			cont=cont+'<td align="right">'+json[i].gasto_externo+'</td>';
			cont=cont+'<td align="right">'+json[i].total_gasto+'</td>';
			if(filtro2!=0 && filtro2!='')cont=cont+'<td align="center">'+json[i].placa+'</td>';
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
	var titulo;
	var chart;
	//color1 = $("#color1").val();
	//color2 = $("#color2").val();
	
	// SERIAL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	if(filtro!='' && filtro!=0)
	{
		titulo='PRESUPUESTO DE MANTENIMIENTOS';
		chart.categoryField = "id_presupuesto";
	}
	else
	{
		titulo='PRESUPUESTO DE MANTENIMIENTOS';
		chart.categoryField = "id_presupuesto";
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
	if(filtro!='' && filtro!=0)
	{
		var graph3 = new AmCharts.AmGraph();
		graph3.type = "column";
		graph3.title = "Presupuesto($)";
		graph3.valueField = "presupuesto";
		graph3.lineAlpha=0;
		graph3.fillColors = color1
		graph3.fillAlphas = 0.8;
		graph3.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph3)
		
		var graph2 = new AmCharts.AmGraph();
		graph2.type = "column";
		graph2.title = "Cantidad gastada($)";
		graph2.valueField = "gasto";
		graph2.lineAlpha=0;
		graph2.fillColors = color2
		graph2.fillAlphas = 0.8;
		graph2.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph2);
	}
	else
	{	
		// column graph
		
		var graph3 = new AmCharts.AmGraph();
		graph3.type = "column";
		graph3.title = "Gasto Interno($)";
		graph3.valueField = "gasto_interno";
		graph3.lineAlpha=0;
		graph3.fillColors = color1
		graph3.fillAlphas = 0.8;
		graph3.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph3)
		
		var graph2 = new AmCharts.AmGraph();
		graph2.type = "column";
		graph2.title = "Gasto Externo($)";
		graph2.valueField = "gasto_externo";
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