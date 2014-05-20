<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
		estado_correcto='El rol se ha <?php echo $accion?>do exitosamente.';
		estado_incorrecto='Error al intentar <?php echo $accion?>r el rol: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Control de Roles</h2>
</section>
<button type="button" id="nuevo_rol1" class="button tam-1">Nuevo Rol</button>
<a id="nuevo_rol2" rel="leanModal" href="#ventana"></a>
<table  class="grid">
<colgroup>
	<col />
	<col />
	<col style="width:100px"/>
</colgroup>
<thead>
  <tr>
    <th>Nombre del Rol</th>
    <th>Descripción de Rol</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($roles as $val) {
?>
  <tr>
    <td><?php echo ucwords($val['nombre_rol'])?></td>
    <td><?php echo $val['descripcion_rol']?></td>
    <td>
    	<a class="modificar_rol" title="Modificar Rol" rel="leanModal" href="#ventana" data-id_rol="<?php echo $val['id_rol']?>" data-nombre_rol="<?php echo ucwords($val['nombre_rol'])?>"><img src="<?php echo base_url()?>img/rol_editar.png"/></a>
    	<a class="eliminar_rol" title="Eliminar Rol" data-id_rol="<?php echo $val['id_rol']?>" data-nombre_rol="<?php echo ucwords($val['nombre_rol'])?>"><img src="<?php echo base_url()?>img/rol_borrar.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>
<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2 id="titulo-ventana"></h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$(".modificar_rol").click(function(){
			id=$(this).data("id_rol");
			nom=$(this).data("nombre_rol");
			$("#titulo-ventana").html("Modificar Rol - "+nom);
			$('#contenido-ventana').load(base_url()+'index.php/usuarios/datos_de_rol/'+id);
			return false;
		});
		$("#nuevo_rol1").click(function(){
			$("#nuevo_rol2").click();
		});
		$("#nuevo_rol2").click(function(){
			$("#titulo-ventana").html("Nuevo Rol");
			$('#contenido-ventana').load(base_url()+'index.php/usuarios/datos_de_rol');
			return false;
		});
		$(".eliminar_rol").click(function(){
			id=$(this).data("id_rol");
			nom=$(this).data("nombre_rol");
			alertify.confirm("Realmente desea eliminar el rol '<i>"+nom+"</i>'? Este cambio no lo podrá revertir.", function (e) {
				if (e) {
					$('#contenido-ventana').load(base_url()+'index.php/usuarios/eliminar_rol/'+id);
				} else {
					return false;
				}
			});
			
		});
	});
</script>