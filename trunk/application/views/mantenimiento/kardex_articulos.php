<section>
    <h2>Kardex de Artículos</h2>
</section>
<form id="filtro">
<p>
	<label style="width:100px">Artículo: </label>
    <select class="select" style="width:350px" name="id_articulo">
    	<option value="*" selected>[Todos]</option>
		<?php
			foreach($articulos as $art)
			{
				echo "<option value='".$art['id_articulo']."'>".$art['nombre']."</option>";
			}
        ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Vehículo: </label>
    <select class="select" style="width:100px" name="id_vehiculo">
    	<option value="*" selected='selected'>[Todos]</option>
    	<?php
			foreach($vehiculos as $v)
			{
				echo "<option value='".$v->id."'>".$v->placa."</option>";
			}
        ?>
    </select>
</p>
<p>
    <label style="width:100px">Fecha Inicial: </label>
    <input type="text" name="fecha_inicial" id="fecha_inicial" <?php if($bandera=='true') echo "value='".$fecha_inicial."'"; ?>>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <label>Fecha Final: </label>
    <input type="text" name="fecha_final" id="fecha_final" <?php if($bandera=='true') echo "value='".$fecha_final."'"; ?>>
</p>
 <p align="center">
        <input name="salida" value="1" type="radio">  PDF 
</p>
<p align="center">
        <button type="button" id="Filtrar" class="button tam-1" >Filtrar</button>                    
        <button   id="imp1" class="button tam-1" >Imprimir</button>

</p>
</form>
<br><br>
<h3>Vehiculos</h3>
<table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
               <th>
                    Placa
                </th>
                <th>
                    Marca
                </th>
                <th>
                    Vales aplicados
                </th>
                 <th>
                    Combustible Aplicado (gal)
                </th>
               <th>
                    Recorrido (Km)
                </th>  
                 <th>
                    Rendimiento (Km/gal)
                </th>             

            </thead>
            <tbody>
            </tbody>
        </table>
        
 <div style="height:400px; background:#FFFFFF;" id="chartdiv">
</div>
<script language="javascript">
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

$("#Filtrar").click(function(){             

		var formu = $('#filtro').serializeArray();
	//    console.log(formu); 

	reporte(formu);
	});


function reporte(formu){  
			$.ajax({  //para vehiculos
		async:  true, 
		url:    base_url()+"index.php/vehiculo/kardex_articulo_json",
		dataType:"json",
		 type: "POST",
		data: formu,
		success: function(data){
			tabla2(data), 
			grafico(data)
			},
		error:function(data){
				alertify.alert('Error al cargar datos de vehiculos');

			}
	});          
				$.ajax({  //para vehiculos
		async:  true, 
		url:    base_url()+"index.php/vales/reporte_vehiculo_json/2",
		dataType:"json",
		 type: "POST",
		data: formu,
		success: function(data){
			tabla3(data) 

			},
		error:function(data){
				alertify.alert('Error al cargar datos de Herramientas');

			}
	});          
	
}

function tabla3 (json) {
                var fila;

            $('#datos tbody').remove();        
            for (i=0;i<json.length;i++) {   
            
             fila= "<tr>" +
              "<td align='center'>" + json[i].row_number + "</td>" +
              "<td align='center'>" + json[i].seccion + "</td>" +
              "<td align='center'>" + json[i].asignado + "</td>" +
              "<td align='center'>" + json[i].entregado + "</td>" +
              "<td align='center'>"; 
                var series1=json[i].inicial.split(",");
                var series2=json[i].final.split(",");
                    
                    for (var j= 0; j < series1.length; j++) {
                        fila+=series1[j]+" - "+ series2[j];
                        if(j!=series1.length-1){ fila+="<br>"}
                    }

             fila+= "</td>" +
            "</tr>";    
                $('#datos').append(fila)    
                }  
}

function grafico (chartData, label) {

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
</script>