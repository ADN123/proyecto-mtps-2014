<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='<?php echo $mensaje; ?>';
	estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
</script>
<section>
    <h2>Presupuestos</h2>
</section>
<button style="width:200px" type="button" onclick="window.open('<?php echo base_url()."index.php/vehiculo/nuevo_presupuesto" ?>','_parent')" name="btnNuevo">Nuevo Presupuesto</button>
<table  class="grid">
    <thead>
      <tr>
        <th>ID</th>
        <th>Presupuesto($)</th>
        <th>Cantidad Actual($)</th>
        <th>Cantidad Usada($)</th>
        <th>Fecha Inicial</th>
        <th>Fecha Final</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php    
        foreach ($presupuesto as $fila) {
    ?>
        <tr align="center">
            <td><?php echo $fila['id_presupuesto']?></td>
            <td><?php echo number_format($fila['presupuesto'],2)?></td>
            <td><?php echo number_format($fila['cantidad_actual'],2)?></td>
            <td><?php echo number_format($fila['gasto'],2)?></td>
            <td><?php echo $fila['fecha_inicial']?></td>
            <td><?php echo $fila['fecha_final']?></td>
            <td>
            	<a rel="leanModal" title="Ver información detallada del presupuesto" href="#ventana" onclick="dialogo(<?php echo $fila['id_presupuesto']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
                <a rel="leanModal" title="Modificar información del presupuesto" href="<?php echo base_url()."index.php/vehiculo/nuevo_presupuesto/".$fila['id_presupuesto'] ?>" ><img src="<?php echo base_url()?>img/editar.png"/></a>
                <a rel="leanModal" title="Reforzar presupuesto" href="<?php echo base_url()."index.php/vehiculo/nuevo_refuerzo/".$fila['id_presupuesto'] ?>" ><img src="<?php echo base_url()?>img/dinero.png" width="25px"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Presupuesto</h2>
        <a id="cerrar" class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>

<script language="javascript" >
function dialogo(id)
{
	$('#contenido-ventana').load(base_url()+'index.php/vehiculo/ventana_presupuesto_gastos/'+id);
	return false;
}
function cerrar_vent()
{
	$('#cerrar').click();
}
</script>
