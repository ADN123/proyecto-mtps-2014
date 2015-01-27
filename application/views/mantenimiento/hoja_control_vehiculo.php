<section>
    <h2>Hoja Control por Vehículo</h2>
</section>

<table  class="grid">
    <thead>
      <tr>
      	<th>Fecha</th>
        <th>Placa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Clase</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php   
	foreach ($vehiculos as $fila) {
    ?>
        <tr align="center">
        	<td><?php echo $fila['fecha']?></td>
            <td><?php echo $fila['placa']?></td>
            <td><?php echo ucwords($fila['marca'])?></td>
            <td><?php echo ucwords($fila['modelo'])?></td>
            <td><?php echo ucwords($fila['clase'])?></td>
            <td>
            	<a rel="leanModal" title="Imprimir Hoja de Control por Vehículo"
                href="<?php echo base_url()."index.php/vehiculo/hoja_control_vehiculo_pdf/".$fila['id_mantenimiento_interno'] ?>" target="_blank" >
                <img src="<?php echo base_url()?>img/ico_pdf.png" height="23px"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>