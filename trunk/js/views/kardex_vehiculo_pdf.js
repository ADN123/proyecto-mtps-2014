// JavaScript Document
function tabla(json)
{
	var cont='';
	var n=json.length;
	$('#tabla_resultado').html("");
	
	if(filtro!='' && filtro!=0)
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
		if(filtro2==0 || filtro2=='')cont=cont+'<th width="80px" align="center">Existencia</th>';
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
			if(filtro2==0 || filtro2=='')cont=cont+'<td align="right">'+parseFloat(ingresos-egresos)+'</td>';
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
		if(filtro2!='' && filtro2!=0)
		{
			cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
			cont=cont+'<thead>';
			cont=cont+'<tr>';
			cont=cont+'<th width="120px" align="center">Artículo</th>';
			cont=cont+'<th width="30px" align="center">Cantidad Usada</th>';
			cont=cont+'<th width="30px" align="center">Unidad de Medida</th>';
			cont=cont+'</tr>';
			cont=cont+'</thead>';
			cont=cont+'<tbody>';
			
			for(i=0;i<n;i++)
			{
				cont=cont+'<tr>';
				cont=cont+'<td>'+json[i].nombre+'</td>';
				cont=cont+'<td align="right">'+json[i].cantidad+'</td>';
				cont=cont+'<td align="right">'+json[i].unidad_medida+'</td>';
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
			cont=cont+'<th width="120px" align="center">Artículo</th>';
			cont=cont+'<th width="30px" align="center">Entrada</th>';
			cont=cont+'<th width="30px" align="center">Salida</th>';
			cont=cont+'<th width="30px" align="center">Existencia</th>';
			cont=cont+'</tr>';
			cont=cont+'</thead>';
			cont=cont+'<tbody>';
			
			for(i=0;i<n;i++)
			{
				cont=cont+'<tr>';
				cont=cont+'<td>'+json[i].nombre+'</td>';
				cont=cont+'<td align="right">'+json[i].entradas+'</td>';
				cont=cont+'<td align="right">'+json[i].salidas+'</td>';
				cont=cont+'<td align="right">'+json[i].existencia+'</td>';
				cont=cont+'</tr>';
			}
			
			cont=cont+'</tbody>';
			cont=cont+'</table>';
		}
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
	if(filtro!='' && filtro!='0')
	{
		titulo='KARDEX';
		chart.categoryField = "placa";
	}
	else
	{
		if(filtro2!='' && filtro2!='0')
		{
			titulo='MATERIALES POR VEHÍCULO';
			chart.categoryField = "nombre";
		}
		else
		{
			titulo='MATERIALES EN BODEGA';
			chart.categoryField = "nombre";
		}
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
		var graph1 = new AmCharts.AmGraph();
		graph1.type = "column";
		graph1.title = "cantidad usada";
		graph1.valueField = "cantidad";
		graph1.lineAlpha = 0;
		graph1.fillColors = color1;
		graph1.fillAlphas = 0.8;
		graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
		chart.addGraph(graph1);
	}
	else
	{	
		// column graph
		if(filtro2!='' && filtro2!=0)
		{
			var graph1 = new AmCharts.AmGraph();
			graph1.type = "column";
			graph1.title = "cantidad usada";
			graph1.valueField = "cantidad";
			graph1.lineAlpha = 0;
			graph1.fillColors = color1;
			graph1.fillAlphas = 0.8;
			graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
			chart.addGraph(graph1);
		}
		else
		{
			var graph3 = new AmCharts.AmGraph();
			graph3.type = "column";
			graph3.title = "Entradas";
			graph3.valueField = "entradas";
			graph3.lineAlpha=0;
			graph3.fillColors = color1
			graph3.fillAlphas = 0.8;
			graph3.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
			chart.addGraph(graph3)
			
			var graph2 = new AmCharts.AmGraph();
			graph2.type = "column";
			graph2.title = "Salidas";
			graph2.valueField = "salidas";
			graph2.lineAlpha=0;
			graph2.fillColors = color2
			graph2.fillAlphas = 0.8;
			graph2.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
			chart.addGraph(graph2);
		}
	}
	
	
	// LEGEND
	var legend = new AmCharts.AmLegend();
	legend.useGraphSettings = true;
	chart.addLegend(legend);
	
	chart.creditsPosition = "top-right";
	
	// WRITE
	chart.write("chartdiv");
}