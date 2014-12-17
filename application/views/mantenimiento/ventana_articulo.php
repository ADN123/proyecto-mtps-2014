<?php
extract($articulo);
?>
<form name="form_articulo" method="post">

<fieldset>
	<legend>Información del Artículo</legend>
    Nombre: <strong><?php echo $nombre; ?></strong><br />
    Descripción: <strong><?php echo $descripcion; ?></strong><br />
    Cantidad Disponible: <strong><?php echo $cantidad; ?></strong><br />
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
		foreach($tta as $t)
		{
			echo "<tr>";
			echo "<td>".$t['fecha']."</td>";
			echo "<td>".$t['tipo_transaccion']."</td>";
			echo "<td align='right'>".$t['cantidad']."</td>";
			echo "</tr>";
		}
        ?>
    </tbody>
    </table>
</fieldset>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>