<?php
extract($vehiculo);
?>
<br><br><br>
<table align="center" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" width="200px">
	<br />
	<table border="1" cellpadding="0" cellspacing="0">
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
<td valign="top" width="190px">
	<br />
    <table border="1" cellpadding="0" cellspacing="0">
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
<td width="255px" valign="top">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" valign="top">
	<table align="center" cellpadding="0" cellspacing="0" border="1" width="800px">
    	<tr>
        	<td width="350px">Nombre de motorista: <strong><?php echo ucwords($motorista) ?></strong></td>
            <td align="center" valign="top">Trabajo Solicitado:</td>
        </tr>
        <tr><td>Kilometraje: <strong><?php echo $kilometraje_ingreso ?></strong></td><td rowspan="7" valign="top" align="justify"><strong><?php echo $trabajo_solicitado ?></strong></td></tr>
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
	<td colspan="3">
    <br>
    <table align="center" cellpadding="0" cellspacing="0" style="border:dotted" border="1" width="800px">
    	<tr>
        	<td align="center">Nivel de Combustible:</td>
            <td align="center" valign="top">Trabajo Solicitado en la Carrocería: </td>
        </tr>
        <tr><td>R...../.....M...../.....F</td><td align="justify" valign="top" rowspan="4"><strong><?php echo $trabajo_solicitado_carroceria ?></strong></td></tr>
        <tr><td>Firma de entregado para Revisión.</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>F. <strong><?php echo ucwords($persona_entrega) ?></strong></td></tr>
        <tr><td>Por este medio hago constar que estoy recibiendo el vehículo a</td><td valign="top" align="center">NOTAS:</strong></td></tr>
        <tr><td>mi entera satisfacción sin problemas mecánicos</td><td valign="top" align="justify" rowspan="4"><strong><?php echo $notas ?></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>F. <strong><?php echo ucwords($persona_recibe) ?></strong></td></tr>
        <tr><td>FIRMA DE MOTORISTA</td></tr>
    </table>
   	</td>
</tr>
</table>