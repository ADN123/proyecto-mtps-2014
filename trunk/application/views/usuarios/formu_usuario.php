<?php
	$id_usuario="";
	$nombre_completo="";
	$usuario="";
	$id_rol="";
	$dir="guardar_usuario";
	$label="Guardar";
	$op='selected="selected"';
	
	foreach ($usu as $val) {
		$id_usuario=$val['id_usuario'];
		$nombre_completo=ucwords($val['nombre_completo']);
		$usuario=$val['usuario'];
		$id_rol=$val['id_rol'];
		$dir="actualizar_usuario";
		$label="Actualizar";
		$op='';
	}
?>
<style>
	.k-multiselect {
		display: inline-block;
	}
</style>
<form name="formu" id="formu" style="max-width: 600px;" method="post" action="<?php echo base_url()?>index.php/usuarios/<?=$dir?>">
  	<input type="hidden" id="id_usuario" name="id_usuario" value="<?=$id_usuario?>"/>
	<fieldset>      
        <legend align='left'>Información del Usuario</legend>
        <p>
            <label for="nombre_completo" id="lnombre_completo">Nombre </label>
            <?php
				if($id_usuario=="") {
			?>
                <select name="nombre_completo" id="nombre_completo" tabindex="1"  class="select" style="width:60%">
                    <?php
                        foreach($empleados as $val) {
                            echo '<option value="'.$val['id_empleado'].'">'.ucwords($val['nombre']).'</option>';
                        }
                    ?>
                </select>
            <?php
				}
				else
					echo "<strong> ".$nombre_completo." </strong>";
			?>
        </p>
        <p>
            <label for="usuario" id="lusuario">Usuario </label>
            <?php
				if($id_usuario=="") {
			?>
            	<input type="text" tabindex="2" id="usuario" name="usuario"/>
            <?php
				}
				else
					echo "<strong> ".$usuario." </strong>";
			?>
        </p>
        <p>
            <label for="password" id="lpassword">Contraseña </label>
            <input type="password" tabindex="2" id="password" name="password"/>
        </p>
	</fieldset>
    <fieldset>      
        <legend align='left'>Información del Rol</legend>
        <p>
            <label for="id_rol" id="lid_rol" class="label_textarea">Rol </label>
            <select name="id_rol[]" id="id_rol" tabindex="3" multiple="multiple" class="multi" style="width:60%;">
                <?php
                    foreach($roles as $val) {
						if($val['id_rol']==$id_rol)
                        	echo '<option value="'.$val['id_rol'].'" selected="selected">'.ucwords($val['nombre_rol']).'</option>';
						else
                        	echo '<option value="'.$val['id_rol'].'">'.ucwords($val['nombre_rol']).'</option>';
                    }
                ?>
            </select>
        </p>    
	</fieldset>
    <p style='text-align: center;'>
        <button type="submit" id="aprobar" class="button tam-1 boton_validador" name="aprobar"><?=$label?></button>
    </p>
</form>
<script>
	$(document).ready(function() {
		$("select").prepend('<option value="" <?=$op?>></option>');
		$(".multi").kendoMultiSelect({
			filter: "contains"	
		}).data("kendoMultiSelect");
		$(".select").kendoComboBox({
			autoBind: false,
			filter: "contains"
		});
		<?php
			if($id_usuario=="") {
		?>
			$("#nombre_completo").validacion({
				men: "Debe seleccionar un item"
			});
			$("#usuario").validacion({
				patt: /^([a-z|A-Z])+[.]{1}([a-z|A-Z])+$/i,
				men: "Debe contener el formato <i>nombre.apellido</i> (sin acentos ni espacios en blanco)"
			});
			$("#password").validacion({
				lonMin: 5,
				lonMax: 25
			});
		<?php
			}
			else {
		?>
			$("#password").validacion({
				req: false,
				lonMin: 5,
				lonMax: 25
			});
		<?php
			}
		?>
		$("#id_rol").validacion({
			men: "Debe seleccionar un item"
		});
		$("#nombre_completo").change(function(){
			var id=$(this).val();
			$.ajax({
				type:  "post",  
				async:	true, 
				url:	base_url()+"index.php/usuarios/buscar_info_adicional_usuario",
				data:   {
						id_empleado: id
					},
				dataType: "json",
				success: function(data) { 
					if(data['estado']==1) {
						var html=data['usuario'];
						$("#usuario").val(html);
					}
					else {	
						alertify.alert('Error al intentar buscar empleado: No se encuentra el registro');
						$("#usuario").val("");
					}
				},
				error:function(data) { 
					alertify.alert('Error al intentar buscar empleado: No se pudo conectar al servidor');
					$("#usuario").val("");
				}
			});
		});
	});
</script>