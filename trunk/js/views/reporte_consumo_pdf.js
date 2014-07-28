function grafico (chartData, label) {


              var chart;

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
                valueAxis.title = "Cosumo de Vales vs Asignacion";
                valueAxis.minorGridEnabled = true;
                valueAxis.minorGridAlpha = 0.08;
                valueAxis.gridAlpha = 0.15;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // column graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "ConsumiDo";
                graph1.valueField = "consumido";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#ADD981";
                graph1.fillAlphas = 0.8;
                graph1.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]:<b>[[value]]</b></span>";
                chart.addGraph(graph1);

                // line graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "line";
                graph2.lineColor = "#27c5ff";
                graph2.bulletColor = "#FFFFFF";
                graph2.bulletBorderColor = "#27c5ff";
                graph2.bulletBorderThickness = 2;
                graph2.bulletBorderAlpha = 1;
                graph2.title = "Asignado";
                graph2.valueField = "asignado";
                graph2.lineThickness = 2;
                graph2.bullet = "round";
                graph2.fillAlphas = 0;
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

function tabla (json) {
                var fila;

            $('#datos tbody').remove();        
            for (i=0;i<json.length;i++) {   
            var n = new Number(json[i].dinero);
             fila= "<tr>" +
              "<td align='center'>" + json[i].row_number + "</td>" +
              "<td align='center'>" + json[i].seccion + "</td>" +
              "<td align='center'>" + json[i].asignado + "</td>" +
              "<td align='center'>" + json[i].consumido + "</td>" +
              "<td align='center'>$" + n.toFixed(2) + "</td>" +
            "</tr>";    
                $('#datos').append(fila)    
                }  
}

