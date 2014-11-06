<section>
    <h2>Presupuestos</h2>
</section>
<table  class="grid">
    <thead>
      <tr>
        <th>ID</th>
        <th>Presupuesto</th>
        <th>Cantidad Actual</th>
        <th>Cantidad Usada</th>
        <th>Fecha Inicial</th>
        <th>Fecha Final</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php    
        foreach ($datos as $fila) {
    ?>
        <tr>
            <td><?php echo $fila->id_presupuesto?></td>
            <td><?php echo ucwords($fila->presupuesto)?></td>
            <td><?php echo ucwords($fila->cant_actual)?></td>
            <td><?php echo ucwords(($fila->presupuesto)-($fila->cant_actual))?></td>
            <td><?php echo ucwords($fila->fecha_inicial)?></td>
            <td><?php echo ucwords($fila->fecha_final)?></td>
            <td>
            	<a rel="leanModal" title="Ver información del Vehículo" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
                <a rel="leanModal" title="Modificar información del Vehículo" href="<?php echo base_url()."index.php/vehiculo/nuevo_vehiculo/".$fila->id ?>" ><img src="<?php echo base_url()?>img/editar.png"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Vehículo</h2>
        <a id="cerrar" class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>