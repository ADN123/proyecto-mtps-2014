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
		url: base_url()+"index.php/vehiculo/reporte_mantenimientos_json",
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
			alertify.alert('Error al cargar datos de los mantenimientos');
		}
	});
}

function tabla(json)
{
	var cont='';
	var n=json.length;
	var filtro=document.getElementById('mecanico');
	var filtro2=document.getElementById('id_vehiculo');
	$('#tabla_resultado').html("");
	
	cont=cont+'<table class="table_design" align="center" cellpadding="0" cellspacing="0">';
	cont=cont+'<thead>';
	cont=cont+'<tr>';
	cont=cont+'<th align="center">Mecánico</th>';
	if((filtro.value!='' && filtro.value!=0) || (filtro2.value!='' && filtro2.value!=0)) cont=cont+'<th align="center">Placa</th>';
	cont=cont+'<th align="center">N° de Mttos.</th>';
	cont=cont+'</tr>';
	cont=cont+'</thead>';
	cont=cont+'<tbody>';
	
	for(i=0;i<n;i++)
	{
		cont=cont+'<tr>';
		cont=cont+'<td>'+json[i].nombre.capitalize()+'</td>';
		if((filtro.value!='' && filtro.value!=0) || (filtro2.value!='' && filtro2.value!=0))cont=cont+'<td>'+json[i].placa+'</td>';
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
	var filtro=document.getElementById('mecanico');
	var filtro2=document.getElementById('id_vehiculo');
	var titulo;
	var chart;
	//color1 = $("#color1").val();
	//color2 = $("#color2").val();
	
	// SERIAL CHART
	chart = new AmCharts.AmSerialChart();
	chart.dataProvider = chartData;
	if(filtro.value!='' && filtro.value!='0')
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