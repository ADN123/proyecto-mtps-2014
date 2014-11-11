<?php
extract($presupuesto_info)
?>
<form name="form_presupuesto_info" method="post">

<fieldset>
	<legend>Información del Presupuesto</legend>
    Presupuesto ($): <strong><?php echo $presupuesto; ?></strong>
    Período: <strong><?php echo "DESDE: ".$fecha_inicial." HASTA: ".$fecha_final; ?></strong>
    Cantidad Actual ($): <strong><?php echo $cant_actual; ?></strong>
</fieldset>
<fieldset>
	<legend>Información de los gastos</legend>
    <table align="center" class="table_design" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
	        <th>Descripción</th>
            <th>Fecha</th>
            <th>Cantidad Gastada($)</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$suma=0;
		foreach($gastos as $g)
		{
			echo "<tr>";
			echo "<td>".$g['descripcion']."</td>";
			echo "<td>".$g['fecha']."</td>";
			echo "<td align='right'>".$g['gasto']."</td>";
			echo "</tr>";
			$suma=$suma+$g['gasto'];
		}
        ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="2" align="right">Gasto Total: </td>
            <td align="right"><strong><?php echo $suma; ?></strong></td>
        </tr>
    </tfoot>
    </table>
</fieldset>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>