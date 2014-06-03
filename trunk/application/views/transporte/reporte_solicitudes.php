<section>
    <h2>Solicitudes</h2>
</section>
<table class="grid">
	<colgroup>
    	<col />
    	<col width="175" />
    	<col />
    	<col />
    	<col />
    	<col width="100" />
    </colgroup>
<thead>
  		<tr>
            <th>ID Solicitud</th>
          	<th>Fecha y hora</th>
            <th>Solicitante</th>
            <th>Sección</th>
            <th>Estado Solicitud</th>
            <th>Opción</th>
  		</tr>
 	</thead>
 	<tbody>
	<?php
		foreach ($solicitudes as $val) {
			switch($val['estado']){
				case 0:
					$estado="Rechazada";
					break;
				case 1:
					$estado="Creada";
					break;
				case 2:
					$estado="Aprobada";
					break;
				case 3:
					$estado="Asignada con veh&iacute;culo";
					break;
				case 4:
					$estado="En Misi&oacute;n";
					break;
				case 5:
					$estado="Finalizada";
			}									
	?>
  		<tr>
            <td><?php echo $val['id']?></td>
            <td><?php echo $val['fecha']." ".$val['salida']?></td>
            <td><?php echo  ucwords($val['nombre'])?></td>
            <td><?php echo  ucwords($val['seccion'])?></td>
            <td><?php echo $estado ?></td>
            <td>
            	<a title="Crear .pdf de solicitud" target="_blank" href="<?php echo base_url()?>index.php/transporte/solicitud_pdf/<?php echo $val['id']?>"><img  src="<?php echo base_url()?>img/ico_pdf.png"/></a>
            </td>
  		</tr>
	<?php
		} 
	?>
	</tbody>
</table>