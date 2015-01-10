<?php
extract($articulo);
?>
<form name="form_articulo" method="post">

<fieldset>
	<legend>Información del Artículo</legend>
    Nombre: <strong><?php echo $nombre; ?></strong><br />
    Descripción: <strong><?php echo $descripcion; ?></strong><br />
    Cantidad Disponible: <strong><?php echo $cantidad; ?></strong><br />
    Unidad de Medida: <strong><?php echo $unidad_medida; ?></strong>
</fieldset>
<fieldset>
	<legend>Transacciones del Artículo</legend>
    <table align="center" class="table_design" cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
	        <th>Fecha</th>
            <th>Tipo de Transacción</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$total=0;
		foreach($tta as $t)
		{
			echo "<tr>";
			echo "<td>".$t['fecha']."</td>";
			echo "<td>".$t['tipo_transaccion']."</td>";
			echo "<td align='right'>".$t['cantidad']."</td>";
			echo "</tr>";
			if($t['tipo_transaccion']=='ENTRADA') $total=$total+$t['cantidad'];
			elseif($t['tipo_transaccion']=='SALIDA') $total=$total-$t['cantidad'];
		}
        ?>
        <tr>
        	<td colspan="2" align="right">Total: </td>
            <td align="right"><strong><?php echo $total; ?></strong></td>
        </tr>
    </tbody>
    </table>
</fieldset>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>