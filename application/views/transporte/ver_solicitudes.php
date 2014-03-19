<section>
    <h2>Solicitudes</h2>
</section>
<table class="grid">
	<thead>
  		<tr>
            <th>Fecha y Hora</th>
            <th>Destino</th>
            <th>Mision Encomendada</th>
            <th>Opción</th>
  		</tr>
 	</thead>
 	<tbody>
	<?php
		foreach ($solicitudes as $val) {									
	?>
  		<tr>
            <td><?php echo $val['fecha']?></td>
            <td><?php echo $val['lugar']?></td>
            <td><?php echo $val['mision']?></td>
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