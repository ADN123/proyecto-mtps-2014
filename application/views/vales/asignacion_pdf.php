
<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<html>
    <head>
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>

<!----------------------------------------------------------------------------------------------------------------- -->
        <script src="<?php echo base_url()?>js/views/reporte_consumo_pdf.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>/js/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>/js/serial.js" type="text/javascript"></script>  

    </head>
    <body >
    <div style="height:100px; background:#FFFFFF; width:600px; margin:auto" > 

    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php echo base_url()?>/img/mtps_report.jpg" />
            </td>
            <td align="right">
                <h3>REPORTE DE VALES DE COMBUSTIBLE</h3>
                <h6>Fecha: <strong><?php echo date('d-m-Y') ?></strong> </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br>
                <strong id="titulo">ASIGNACION y ENTREGA DE VALES DE COMBUSTIBLE</strong>
            </td>
        </tr>
    </table>
    </div>
<br><br><br>
 <!--------------------Plantilla de carga de grafico y tabla------------------------------------------------------------ -->
        <div style="height:400px; background:#FFFFFF; width:600px; margin:auto" id="chartdiv">
        </div>
        <br>
    <div  style="height:400px; width:850px;  margin:auto">
        <table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
               <th>
                   N&deg;
                </th>
                <th>
                   Secci&oacute;n
                </th>
                <th>
                    Asignado
                </th>
                <th>  
                    Consumido
                </th>
                <th>  
                    Consumido ($)
                </th>             

            </thead>
            <tbody>
            </tbody>
        </table>
        <br><br>
        <p style="width:650px; margin:auto;"> <?php echo$f; ?></p>
    </div>
    </body>

</html>
                

<script language="javascript" >




                data=<?php echo $j; ?>
                //grafico(data,"row_number");//contructor del grafico
                

            var label="row_number";
              var chart;
              var chartData=data;
              var color1="<?php echo $color1; ?>";
              var color2="<?php echo $color2; ?>";

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
                valueAxis.title = "";
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
                tabla3(data);


function imprimir() {
if (window.print)
window.print()
}
setTimeout ("imprimir();", 2000);

</script>

