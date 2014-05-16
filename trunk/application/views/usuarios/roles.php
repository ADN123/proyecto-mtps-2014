<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='El rol se han almacenado exitosamente.';
	estado_incorrecto='Error al intentar guardar el rol: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Creación de Rol</h2>
</section>
<form name="formu" id="formu" style="max-width: 600px;" method="post" action="<?php echo base_url()?>index.php/usuarios/guardar_rol">
	<p>
        <label for="nombre_rol" id="lnombre_rol">Nombre del rol </label>
        <input type="text" tabindex="1" id="nombre_rol" name="nombre_rol"/>
    </p>
    <p>
        <label for="descripcion_rol" id="ldescripcion_rol" class="label_textarea">Descripción </label>
        <textarea class="tam-4" id="descripcion_rol" tabindex="2" name="descripcion_rol"/></textarea>
    </p>
   <!-- <ul id="treeview" style="max-width: 600px; width: 100%; margin: 0 auto;">
        <li data-expanded="true">-->
            <?=$menu?>
       <!-- </li>
    </ul>-->
    <p style='text-align: center;'>
        <button type="submit" id="aprobar" class="button tam-1 boton_validador" name="aprobar">Guardar</button>
    </p>
</form>
<script>
	$(document).ready(function() {
		$(".treeview").kendoTreeView();
		$(".treeview li").hover(function(){
			
		});
		$("#nombre_rol").validacion({
			valNombre: true
		});
		$("#descripcion_rol").validacion({
			req: false,
			lonMin: 10
		});
	});
</script>