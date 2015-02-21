<?php
header('Content-Type: text/html; charset=UTF-8'); 
?>
<html>
    <head>
        <link href="<?php echo base_url()?>css/style-base.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url()?>js/jquery-1.8.2.js"></script>

<!----------------------------------------------------------------------------------------------------------------- -->
        <script src="<?php echo base_url()?>js/views/reporte_presupuesto_pdf.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>/js/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>/js/serial.js" type="text/javascript"></script>  

    </head>
    <body>
     <div style="height:100px; background:#FFFFFF; width:600px; margin:auto" > 

    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php echo base_url()?>/img/mtps_report.jpg" />
            </td>
            <td align="right">
                <h3>REPORTE DE PRESUPUESTO</h3>
                <h6>Fecha: <strong><?php echo date('d-m-Y') ?></strong> </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br>
                <strong id="titulo"></strong>
            </td>
        </tr>
    </table>
    </div>
 <!--------------------Plantilla de carga de grafico y tabla------------------------------------------------------------ -->
        <br><br>
        <div id="tabla_resultado">
        </div>
        <br><br>
        <div style="height:400px; width:600px; background:#FFFFFF;" id="chartdiv">
        </div>
    </body>

</html>
                

<script language="javascript" >


filtro=<?php echo $mtto ?>;
filtro2=<?php echo $id_vehiculo ?>;
                data=<?php echo $j; ?>;
                tabla(data);
				grafico(data);//contructor del grafico
                

  

function imprimir() {
if (window.print)
window.print()
}
setTimeout ("imprimir();", 2000);

</script>