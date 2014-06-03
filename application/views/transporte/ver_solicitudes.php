<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='La solicitud se ha eliminado exitosamente.';
	estado_incorrecto='Error al intentar eliminar la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
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
            	<?php if($val['estado']<=1) {?>
            		<a title="Editar solicitud" href="<?php echo base_url()?>index.php/transporte/solicitud/m/<?php echo $val['id']?>"><img  src="<?php echo base_url()?>img/editar.png"/></a>
                <?php
            		} 
                	 
                	 if($val['estado']<=3){
                ?>
                <a class="eliminar" title="Eliminar solicitud" href="<?php echo base_url()?>index.php/transporte/eliminar_solicitud/<?php echo $val['id']?>"><img src="<?php echo base_url()?>img/ico_basura.png"/></a>
                	
                <?php }?>
            </td>
  		</tr>
	<?php
		} 
	?>
	</tbody>
</table>
<script language="javascript" >
	$(document).ready(function(){
		$('.eliminar').click(function(){
			if(!(confirm("Realmente desea eliminar esta solicitud? Se perderán todos los datos relacionados a la misma. Este proceso no se puede revertir.")))
				return false;
		});
	});
</script>