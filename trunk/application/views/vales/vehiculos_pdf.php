<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if($base){
     echo '<link href="'.base_url().'/css/kendo.common.min.css" rel="stylesheet" type="text/css" />';
 } ?>
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php if($base){ echo base_url();} ?>img/mtps_report2.jpg" width="175" height="106" />
            </td>
            <td align="right">
                <h3>REPORTE DE VALES DE COMBUSTIBLE</h3>
                <h6>Fecha: <strong><?php echo date('d-m-Y') ?></strong> </h6>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong id="titulo">CONSUMO EN VEHICULOS</strong>
            </td>
        </tr>
  	</table>
    <br>
    <table align="center"   cellspacing="0" class='table_design'>    
        <thead>
        <tr>
            <th>Placa</th>
            <th>Marca</th>
            <th>Vales aplicados</th>
            <th>Combustible Aplicado (gal)</th>
            <th>Recorrido (Km)</th>  
            <th>Rendimiento (Km/gal)</th>             
        </tr>
        </thead>
        <tbody>
        <?php
        $s1=$s2=$s3=0;
			foreach($datos as $d)
			{    
                $s1+=$d->vales;
                $s2+=$d->gal;
                $s3+=$d->recorrido;
				echo "<tr>";
				echo "<td>".$d->placa."</td>";
				echo "<td>".$d->marca."</td>";
                echo "<td>".$d->vales."</td>";
                echo "<td>".$d->gal."</td>";
				echo "<td>".$d->recorrido."</td>";
                echo "<td>".$d->rendimiento."</td>";
				echo "</tr>";
			}

                echo "<tr>";
                echo "<td><strong>TOTAL</strong></td>";
                echo "<td></td>";
                echo "<td><strong>".$s1."</strong></td>";
                echo "<td><strong>".$s2."</strong></td>";
                echo "<td><strong>".$s3."</strong></td>";
                echo "<td></td>";
                echo "</tr>";
		?>
    </tbody>
    </table>
</body>
        <br><br>
        <p style="width:650px; margin:auto;"> <?php echo$f; ?></p>

</html>