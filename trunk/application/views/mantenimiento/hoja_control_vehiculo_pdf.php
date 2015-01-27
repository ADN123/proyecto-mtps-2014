<?php
	extract($vehiculo);
	$cont=0;
	$cont2=0;
	$filas_tabla=0;
	foreach($reparaciones as $repairs)
	{
		if($repairs['tipo']=='mantenimiento') $cont++;
		else $cont2++;
	}
	$filas_tabla=number_format($cont/2,0);
	$cont2=$cont2-1;
?>
<br><br>
<table width="100%"><tr><td><p>PLACA: <strong><u><?php echo $placa ?></u></strong></p></td><td align="right"><p>FECHA: <strong><u><?php echo $fecha ?></u></strong></p></td></tr></table>
<table width="100%" border="1">
	<tr>
    	<th bgcolor="#CCCCCC" colspan="4" align="left"><strong><P>DATOS GENERALES DEL VEHÍCULO:</P></strong></th>
    </tr>
    <tr>
    	<td colspan="3">TIPO DE VEHÍCULO: <strong><?php echo $clase ?></strong></td>
        <td rowspan="2" valign="top">Motorista Asignado: <br><strong><?php echo ucwords($motorista); ?></strong></td>
    </tr>
    <tr>
    	<td>Marca: <strong><?php echo $marca ?></strong></td>
        <td>Modelo: <strong><?php echo $modelo ?></strong></td>
        <td>A&ntilde;o: <strong><?php echo $anio ?></strong></td>
    </tr>
    <tr>
    	<td colspan="2">Tipo de Combustible que usa: <strong><?php echo $tipo_combustible; ?></strong></td>
        <td>Kilometraje Actual: <strong><u><?php echo $kilometraje_ingreso." Km" ?></u></strong></td>
        <td>Oficina en donde está asignado: <br><strong><p><?php echo $seccion; ?></p></strong></td>
    </tr>
</table>
<br>
<table width="100%" border="1">
	<tr>
    	<th align="left" colspan="5"><strong>MANTENIMIENTO REALIZADO</strong></th>
    <tr>
    <?php
	$aux=0;
	$band=0;
    foreach($reparaciones as $repairs)
	{
		if($repairs['tipo']=='mantenimiento')
		{
			$id_re=$repairs['id_reparacion'];
			if($aux==0)
			{
				echo "<tr>";
				echo "<td>".$repairs['reparacion']."</td>";
				
				$aux2=0;
				foreach($reparacion as $re)
				{
					$id_re2=$re['id_reparacion'];
					if($id_re==$id_re2) $aux2++;
					
				}
				if($aux2==1) echo "<td>X</td>";
				else echo "<td>&nbsp;</td>";
				$aux=1;
			}
			elseif($aux==1)
			{
				echo "<td>".$repairs['reparacion']."</td>";
				
				$aux2=0;
				foreach($reparacion as $re)
				{
					$id_re2=$re['id_reparacion'];
					if($id_re==$id_re2) $aux2++;
					
				}
				if($aux2==1) echo "<td>X</td>";
				else echo "<td>&nbsp;</td>";
				if($band==0)
				{
					echo "<td valign='top' rowspan='".$filas_tabla."' width='25%'>Otros (Especifíque): <br><strong>".$otro_mtto."</strong></td>";
					echo "</tr>";
					$band=1;
				}
				elseif($band==1) echo "</tr>";
				$aux=0;
			}
		}
	}
	if($aux==1)
	{
		echo "<td>&nbsp;</td><td>&nbsp;</td></tr>";
	}
	?>
</table>
<br>
<table width="100%" border="1">
	<tr>
    	<th align="left" colspan="3"><strong>INSPECCIÓN/CHEQUEO REALIZADO</strong></th>
    </tr>
    <?php
		$band=0;
		foreach($reparaciones as $repairs)
		{
			if($repairs['tipo']=='inspeccion')
			{
				$id_re=$repairs['id_reparacion'];
				echo "<tr>";
				echo "<td width='40%'>".$repairs['reparacion']."</td>";
				
				$aux=0;
				foreach($reparacion as $re)
				{
					$id_re2=$re['id_reparacion'];
					if($id_re==$id_re2) $aux++;
					
				}
				if($aux==1) echo "<td width='1%'>X</td>";
				else echo "<td width='1%'>&nbsp;</td>";
				
				if($band==0)
				{
					echo "<td valign='top' rowspan='".$cont2."' width='30%'>Observaciones: <br><strong>".$observaciones."</strong></td>";
					echo "</tr>";
					$band=$band+1;
				}
				elseif($band>0 && $band<=$cont2)
				{
					if($band==$cont2) echo "<td>Próximo Mantenimiento: <strong>".($kilometraje_ingreso+5000)." Km.</strong></td>";
					else echo "</tr>";
					
					$band=$band+1;
				}
			}
		}
	?>
</table>
<br>
FIRMA <strong><u><?php echo ucwords($mecanico) ?></u></strong>