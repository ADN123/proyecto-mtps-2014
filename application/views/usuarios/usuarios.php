<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
		estado_correcto='El usuario se ha <?php echo $accion?>do exitosamente.';
		estado_incorrecto='Error al intentar <?php echo $accion?>r el usuario: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Control de Usuarios</h2>
</section>
<button type="button" id="nuevo_usuario1" class="button tam-1">Nuevo Usuario</button>
<a id="nuevo_usuario2" rel="leanModal" href="#ventana"></a>
<table  class="grid">
<colgroup>
	<col />
	<col />
	<col style="width:100px"/>
</colgroup>
<thead>
  <tr>
    <th>Nombre del Empleado</th>
    <th>Usuario</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($usuarios as $val) {
?>
  <tr>
    <td><?php echo ucwords($val['nombre_completo'])?></td>
    <td><?php echo $val['usuario']?></td>
    <td>
    	<a class="modificar_usuario" title="Modificar Usuario" rel="leanModal" href="#ventana" data-id_usuario="<?php echo $val['id_usuario']?>" data-nombre_completo="<?php echo $val['usuario']?>"><img src="<?php echo base_url()?>img/usu_editar.png"/></a>
    	<a class="eliminar_usuario" title="Eliminar Usuario" data-id_usuario="<?php echo $val['id_usuario']?>" data-nombre_completo="<?php echo $val['usuario']?>"><img src="<?php echo base_url()?>img/usu_borrar.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>
<div id="ventana" style="height:400px">
    <div id='signup-header'>
        <h2 id="titulo-ventana"></h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$(".modificar_usuario").click(function(){
			id=$(this).data("id_usuario");
			nom=$(this).data("nombre_completo");
			$("#titulo-ventana").html("Modificar Usuario - "+nom);
			$('#contenido-ventana').load(base_url()+'index.php/usuarios/datos_de_usuario/'+id);
			return false;
		});
		$("#nuevo_usuario1").click(function(){
			$("#nuevo_usuario2").click();
		});
		$("#nuevo_usuario2").click(function(){
			$("#titulo-ventana").html("Nuevo Usuario");
			$('#contenido-ventana').load(base_url()+'index.php/usuarios/datos_de_usuario');
			return false;
		});
		$(".eliminar_usuario").click(function(){
			id=$(this).data("id_usuario");
			nom=$(this).data("nombre_completo");
			alertify.confirm("Realmente desea eliminar el usuario '<i>"+nom+"</i>'? Este cambio no lo podrá revertir.", function (e) {
				if (e) {
					$('#contenido-ventana').load(base_url()+'index.php/usuarios/eliminar_usuario/'+id);
				} else {
					return false;
				}
			});
			
		});
	});
</script>