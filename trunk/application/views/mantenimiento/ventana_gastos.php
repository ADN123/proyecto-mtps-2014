<?php
extract($presupuesto_info)
?>
<form name="form_presupuesto_info" method="post">

<fieldset>
	<legend>Información del Presupuesto</legend>
    Presupuesto ($): <strong><?php echo number_format($presupuesto,2); ?></strong><br />
    Cantidad Actual ($): <strong><?php echo number_format($cantidad_actual,2); ?></strong><br />
    Cantidad Usada ($): <strong><?php echo number_format($gasto,2); ?></strong><br />
    Período: <strong><?php echo "DESDE: ".$fecha_inicial." HASTA: ".$fecha_final; ?></strong><br />
</fieldset>
<fieldset>
	<legend>Información de los gastos</legend>
    <table align="center" class="table_design" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
	        <th>Descripción</th>
            <th width="100px">Fecha</th>
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
			echo "<td align='right'>".number_format($g['gasto'],2)."</td>";
			echo "</tr>";
			$suma=$suma+$g['gasto'];
		}
        ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="2" align="right">Gasto Total ($): </td>
            <td align="right"><strong><?php echo number_format($suma,2); ?></strong></td>
        </tr>
    </tfoot>
    </table>
</fieldset>
<?php
if(!empty($refuerzos))
{
?>
<fieldset>
	<legend>Información de los refuerzos</legend>
    <table align="center" class="table_design" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
	        <th>Justificación</th>
            <th width="100px">Fecha</th>
            <th>Cantidad Reforzada($)</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$suma=0;
		foreach($refuerzos as $r)
		{
			echo "<tr>";
			echo "<td>".$r['justificacion']."</td>";
			echo "<td>".$r['fecha_creacion']."</td>";
			echo "<td align='right'>".number_format($r['refuerzo'],2)."</td>";
			echo "</tr>";
			$suma=$suma+$r['refuerzo'];
		}
        ?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="2" align="right">Refuerzo Total ($): </td>
            <td align="right"><strong><?php echo number_format($suma,2); ?></strong></td>
        </tr>
    </tfoot>
    </table>
</fieldset>
<?php } ?>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>