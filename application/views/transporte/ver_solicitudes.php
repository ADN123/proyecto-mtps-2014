<section>
    <h2>Solicitudes</h2>
</section>
<table class="grid">
	<colgroup>
    	<col width="175" />
    	<col />
    	<col />
    	<col />
    	<col width="100" />
    </colgroup>
	<thead>
  		<tr>
            <th>Fecha</th>
            <th>Salida</th>
            <th>Entrada</th>
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
            <td><?php echo $val['fecha']?></td>
            <td><?php echo $val['salida']?></td>
            <td><?php echo $val['entrada']?></td>
            <td><?php echo $estado?></td>
            <td>
            	<?php if($val['estado']<=1) {?>
            		<a title="Editar solicitud" href="<?php echo base_url()?>index.php/transporte/solicitud/<?php echo $val['id']?>"><img  src="<?php echo base_url()?>img/editar.png"/></a>
                <?php } ?>
                <a title="Eliminar solicitud" href="<?php echo base_url()?>index.php/transporte/eliminar_solicitud/<?php echo $val['id']?>"><img  id="eliminar"  src="<?php echo base_url()?>img/ico_basura.png"/></a>
            </td>
  		</tr>
	<?php
		} 
	?>
	</tbody>
</table>
<script language="javascript" >
	$(document).ready(function(){
		$('#eliminar').click(function(){
			if(!(confirm("Realmente desea eliminar esta solicitud? Se perderán todos los datos relacionados a esta solicitud. Este proceso no se puede revertir.")))
				return false;
		});
	});
</script>