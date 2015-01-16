<?php
extract($vehiculo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table align="center">
<tr>
	<td align="center" valign="middle"><img src="<?php echo base_url() ?>img/escudo.min.png" /></td>
    <td align="center" valign="middle" colspan="2">
    MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
    Departamento de Servicios Generales-Mantenimiento<hr />
    </td>
    <td align="center" valign="middle"><img src="<?php echo base_url() ?>img/mtps_report.jpg" /></td>
</tr>
<tr>
<td>
	<br />
	<table border="1" style="border:thin" cellpadding="0" cellspacing="0">
   	  <tr>
        	<th>Interno</th>
            <th>Si</th>
            <th>No</th>
        </tr>
        <?php
		foreach($revisiones as $rev)
		{
			if($rev['tipo']=='interno')
			{
				echo "<tr>";
				echo "<td>".$rev['revision']."</td>";
				$id_revision=$rev['id_revision'];
				$aux=0;
				foreach($revision as $re)
				{
					if($id_revision==$re['id_revision']) $aux=$aux+1;
					else $aux=$aux+0;
				}
				if($aux>0) echo "<td>X</td><td>&nbsp;</td>";
				else echo "<td>&nbsp;</td><td>X</td>";
				echo "</tr>";
			}
		}
		?>
    </table>
</td>
<td>
	<br />
    <table border="1" style="border:thin" cellpadding="0" cellspacing="0">
    	<tr>
        	<th>Externo</th>
            <th>Si</th>
            <th>No</th>
        </tr>
        <?php
		foreach($revisiones as $rev)
		{
			if($rev['tipo']=='externo')
			{
				echo "<tr>";
				echo "<td>".$rev['revision']."</td>";
				$id_revision=$rev['id_revision'];
				$aux=0;
				foreach($revision as $re)
				{
					if($id_revision==$re['id_revision']) $aux=$aux+1;
					else $aux=$aux+0;
				}
				if($aux>0) echo "<td>X</td><td>&nbsp;</td>";
				else echo "<td>&nbsp;</td><td>X</td>";
				echo "</tr>";
			}
		}
		?>
    </table>
</td>
<td colspan="2">
</td>
</tr>
	<td>
    <br />
    </td>
<tr>
	<td colspan="4">
	<br />
    <table align="center" cellpadding="0" cellspacing="0" border="1">
    	<tr>
        	<td>Nombre de motorista: <strong><?php echo ucwords($motorista) ?></strong></td>
            <td align="center" rowspan="8">Trabajo Solicitado: <strong><?php echo $trabajo_solicitado ?></strong></td>
        </tr>
        <tr><td>Kilometraje: <strong><?php echo $kilometraje_ingreso ?></strong></td></tr>
        <tr><td>Marca: <strong><?php echo $marca ?></strong></td></tr>
        <tr><td>Año: <strong><?php echo $anio ?></strong> Placa: <strong><?php echo $placa ?></strong></td></tr>
        <tr><td>Modelo: <strong><?php echo $modelo ?></strong></td></tr>
        <tr><td>Kilometraje de Mantenimiento: <strong><?php echo ($kilometraje_ingreso+5000) ?></strong></td></tr>
        <tr><td>Fecha de Recepción: <strong><?php echo $fecha_recepcion ?></strong></td></tr>
        <tr><td>Fecha de Entrega: <strong><?php echo $fecha_entrega ?></strong></td></tr>
    </table>
   	</td>
</tr>
<tr>
	<td colspan="4">
	<br />
    <table align="center" cellpadding="0" cellspacing="0" border="1">
    	<tr>
        	<td align="center">Nivel de Combustible:</td>
            <td align="center" rowspan="4">Trabajo Solicitado en la Carrocería: <strong><?php echo $trabajo_solicitado_carroceria ?></strong></td>
        </tr>
        <tr><td>R...../.....M...../.....F</td></tr>
        <tr><td>Firma de entregado para Revisión.</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>F.</td></tr>
        <tr><td>Por este medio hago constar que estoy recibiendo el vehículo a</td><td rowspan="5">NOTAS: <strong><?php echo $notas ?></strong></td></tr>
        <tr><td>mi entera satisfacción sin problemas mecánicos</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>F.</td></tr>
        <tr>FIRMA DE MOTORISTA</tr>
    </table>
   	</td>
</tr>
</table>
<br />
<center>HOJA DE CONTROL DE ENCARGADO DE MANTENIMIENTO.-</center>
<center><u>=====================================================================</u></center>
</body>
</html>