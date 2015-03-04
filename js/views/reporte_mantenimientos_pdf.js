// JavaScript Document
function tabla(json)
{
	var cont='';
	var n=json.length;
	
	$('#tabla_resultado').html("");
	
	cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
	cont=cont+'<thead>';
	cont=cont+'<tr>';
	cont=cont+'<th align="center">Mecánico</th>';
	if((filtro!='' && filtro!=0) || (filtro2!='' && filtro2!=0)) cont=cont+'<th align="center">Placa</th>';
	cont=cont+'<th align="center">N° de Mttos.</th>';
	cont=cont+'</tr>';
	cont=cont+'</thead>';
	cont=cont+'<tbody>';
	
	for(i=0;i<n;i++)
	{
		cont=cont+'<tr>';
		cont=cont+'<td>'+json[i].nombre+'</td>';
		if((filtro!='' && filtro!=0) || (filtro2!='' && filtro2!=0))cont=cont+'<td>'+json[i].placa+'</td>';
		cont=cont+'<td>'+json[i].mttos+'</td>';
		cont=cont+'</tr>';
	}
	
	cont=cont+'</tbody>';
	cont=cont+'</table>';
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
	if(filtro!='' && filtro!='0')
	{
		document.getElementById('titulo').value='MANTENIMIENTOS POR VEHICULO';
		titulo='VEHICULOS';
		chart.categoryField = "placa";
	}
	else
	{
		document.getElementById('titulo').value='MANTENIMIENTOS POR MECÁNICOS';
		titulo='MECÁNICOS';
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
	var graph1 = new AmCharts.AmGraph();
	graph1.type = "column";
	graph1.title = "Mantenimientos";
	graph1.valueField = "mttos";
	graph1.lineAlpha = 0;
	graph1.fillColors = color1;
	graph1.fillAlphas = 0.8;
	graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
	chart.addGraph(graph1);

	
	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.useGraphSettings = true;
	chart.addLegend(legend);
	
	chart.creditsPosition = "top-right";
	
	// WRITE
	chart.write("chartdiv");
}