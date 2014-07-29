
<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<html>
    <head>
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>

<!----------------------------------------------------------------------------------------------------------------- -->
        <script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>
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
                <strong id="titulo">HISTORICO DE CONSUMO DE VALES</strong>
            </td>
        </tr>
    </table>
    </div>
<br><br><br>
 <!--------------------Plantilla de carga de grafico y tabla------------------------------------------------------------ -->
        <div style="height:400px; background:#FFFFFF; width:600px; margin:auto" id="chartdiv">
        </div>
        <br>
    <div  style="height:400px; width:600px;  margin:auto">
        
        <table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
               <th>
                   N°
                </th>
                <th>
                   Fecha
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
                tabla1(data)

            var label="row_number";
              var chart;
              var chartData=data;
              var color1="<?php echo $color1; ?>";
              
                
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = label;
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 0;
                categoryAxis.gridPosition = "start";

                // value
                // in case you don't want to change default settings of value axis,
                // you don't need to create it, as one value axis is created automatically.

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "consumido";
                graph.balloonText = "[[category]]: <b>[[value]] Vales de combustible</b>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.8;
                graph.fillColors = color1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);


                chart.write("chartdiv");



function imprimir() {
if (window.print)
window.print()
}
setTimeout ("imprimir();", 2000);

</script>

