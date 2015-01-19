<section>
    <h2>Hoja de Mantenimiento Preventivo</h2>
</section>

<table  class="grid">
    <thead>
      <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Clase</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Entrega</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php   
	foreach ($vehiculos as $fila) {
    ?>
        <tr align="center">
            <td><?php echo $fila['placa']?></td>
            <td><?php echo ucwords($fila['marca'])?></td>
            <td><?php echo ucwords($fila['modelo'])?></td>
            <td><?php echo ucwords($fila['clase'])?></td>
            <td><?php echo ucwords($fila['fecha_recepcion'])?></td>
            <td><?php echo $fila['fecha_entrega']?></td>
            <td>
            	<a rel="leanModal" title="Imprimir Hoja de Control de Ingreso al Taller"
                href="<?php echo base_url()."index.php/vehiculo/hoja_ingreso_taller/".$fila['id_ingreso_taller'] ?>" target="_blank" >
                <img src="<?php echo base_url()?>img/ico_pdf.png" height="23px"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>