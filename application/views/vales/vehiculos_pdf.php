<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="img/mtps_report.jpg" />
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
            <th>Rendimiento (gal/Km)</th>             
        </tr>
        </thead>
        <tbody>
        <?php
			foreach($datos as $d)
			{
				echo "<tr>";
				echo "<td>".$d->placa."</td>";
				echo "<td>".$d->marca."</td>";
                echo "<td>".$d->vales."</td>";
                echo "<td>".$d->glxv."</td>";
				echo "<td>".$d->recorrido."</td>";
                echo "<td>".$d->rendimiento."</td>";
				echo "</tr>";
			}
		?>
    </tbody>
    </table>
</body>
        <br><br>
        <p style="width:650px; margin:auto;"> <?php echo$f; ?></p>

</html>