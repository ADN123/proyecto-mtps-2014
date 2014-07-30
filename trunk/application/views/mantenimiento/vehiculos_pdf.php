<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php echo base_url(); ?>img/mtps.jpg" />
            </td>
            <td align="right">
                <h3>REPORTE DE VEHÍCULOS</h3>
                <h6></h6>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong id="titulo"></strong>
            </td>
        </tr>
  	</table>
    <table align="center" border="1" class="tabla" cellspacing="0">    
        <tr>
        	<th>Placa</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Clase</th>
            <th>Condición</th>
        </tr>
        <?php
			foreach($datos as $d)
			{
				echo "<tr>";
				echo "<td>".$d['placa']."</td>";
				echo "<td>".$d['modelo']."</td>";
				echo "<td>".$d['clase']."</td>";
				echo "<td>".$d['condicion']."</td>";
				echo "</tr>";
			}
		?>
    </table>
</body>
</html>