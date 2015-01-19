 
                 function startChange() {
                        var startDate = start.value(),
                        endDate = end.value();

                        if (startDate) {
                            startDate = new Date(startDate);
                            startDate.setDate(startDate.getDate());
                            end.min(startDate);
                        } else if (endDate) {
                            start.max(new Date(endDate));
                        } else {
                            endDate = new Date();
                            start.max(endDate);
                            end.min(endDate);
                        }
                    }

                    function endChange() {
                        var endDate = end.value(),
                        startDate = start.value();

                        if (endDate) {
                            endDate = new Date(endDate);
                            endDate.setDate(endDate.getDate());
                            start.max(endDate);
                        } else if (startDate) {
                            end.min(new Date(startDate));
                        } else {
                            endDate = new Date();
                            start.max(endDate);
                            end.min(endDate);
                        }
                    }

                    var start = $("#start").kendoDatePicker({
                        change: startChange,
                         format: "dd-MM-yyyy" 
                    }).data("kendoDatePicker");

                    var end = $("#end").kendoDatePicker({
                        change: endChange,
                         format: "dd-MM-yyyy" 
                    }).data("kendoDatePicker");

                    start.max(end.value());
                    end.min(start.value());
                
                  $("#color1").kendoColorPicker({
                            value: "#8281d9",
                            buttons: false
                        });
                 $("#color2").kendoColorPicker({
                            value: "#ff0040",
                            buttons: false
                       });


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

function grafico2 (chartData, label) {//para el  reporte de asignacion

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
                graph1.title = "Entregado";
                graph1.valueField = "entregado";
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

function tabla1 (json) {
                var fila;

            $('#datos tbody').remove();        
            for (i=0;i<json.length;i++) {   
            var n = new Number(json[i].dinero);
             fila= "<tr>" +
              "<td align='center'>" + json[i].row_number + "</td>" +
              "<td align='center'>" + json[i].fecha + "</td>" +
              "<td align='center'>" + json[i].consumido + "</td>" +
              "<td align='center'>$" + n.toFixed(2) + "</td>" +
            "</tr>";    
                $('#datos').append(fila)    
                }  
}
function tabla2 (json) {
                var fila, total, suma_vales, suma_gal, suma_rec;
                suma_vales=suma_rec=suma_gal=0;

            $('#datos tbody').remove();        
            for (i=0;i<json.length;i++) {   
            var n = new Number(json[i].rendimiento);;
            suma_vales+=Number(json[i].vales);
            suma_gal+=Number(json[i].gal);
            suma_rec+=Number(json[i].recorrido);
             fila= "<tr>" +
              "<td align='center'>" + json[i].placa + "</td>" +
              "<td align='center'>" + json[i].marca + "</td>" +
              "<td align='center'>" + json[i].vales + "</td>" +
              "<td align='center'>" + json[i].gal + "</td>" +
              "<td align='center'>" + json[i].recorrido + "</td>" +
              "<td align='center'>" + n.toFixed(2) + "</td>" +
            "</tr>";    
                $('#datos').append(fila)    
                }  

                         var total= "<tr>" +
              "<td align='center'><strong>TOTAL</strong></td>" +
              "<td align='center'></td>" +
              "<td align='center'><strong>" + suma_vales + "</strong></td>" +
              "<td align='center'><strong>" + suma_gal.toFixed(2) + "</strong></td>" +
              "<td align='center'><strong>" + suma_rec + "<strong></td>" +
              "<td align='center'> </td>" +
            "</tr>";    
            $('#datos').append(total);

}
function tabla2_2(json) {
                var fila, total, suma_vales, suma_gal, suma_rec;
                suma_vales=suma_rec=suma_gal=0;

            $('#datos2 tbody').remove();        
            for (i=0;i<json.length;i++) {   
            suma_vales+=Number(json[i].vales);
            var g=Number(json[i].gal);
            suma_gal+=g;

             fila= "<tr>" +
              "<td align='center'>" + json[i].nombre + "</td>" +
              "<td align='center'>" + json[i].seccion + "</td>" +
              "<td align='center'>" + json[i].vales + "</td>" +
              "<td align='center'>" + g.toFixed(2) + "</td>" +
            "</tr>";    
                $('#datos2').append(fila)    
                }  

                var total= "<tr>" +
              "<td align='center'><strong>TOTAL</strong></td>" +
              "<td align='center'></td>" +
              "<td align='center'><strong>" + suma_vales + "</strong></td>" +
              "<td align='center'><strong>" + suma_gal.toFixed(2) + "</strong></td>" +
            "</tr>";    
            $('#datos2').append(total);

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