<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='El usuario se han almacenado exitosamente.';
	estado_incorrecto='Error al intentar guardar el usuario: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Creación de Usuario</h2>
</section>
<form name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/usuarios/guardar_usuario">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos del usuario</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n del usuario</h2>
            <br />
            <p>
                <label for="nombre_completo" id="lnombre_completo">Nombre </label>
                <select name="nombre_completo" id="nombre_completo" tabindex="1"  class="select" style="width:40%">
                    <?php
                        foreach($empleados as $val) {
                            echo '<option value="'.$val['id_empleado'].'">'.ucwords($val['nombre']).'</option>';
                        }
                    ?>
                </select>
            </p>
            <p>
            	<div id="info_adicional">
                </div>
           	</p>
            <p>
                <label for="password" id="lpassword">Contraseña </label>
                <input type="password" tabindex="2" id="password" name="password"/>
            </p>
            <p>
                <label for="id_rol" id="lid_rol">Rol </label>
                <select name="id_rol" id="id_rol" tabindex="3"  class="select" style="width:40%">
                    <?php
                        foreach($roles as $val) {
                            echo '<option value="'.$val['id_rol'].'">'.ucwords($val['nombre_rol']).'</option>';
                        }
                    ?>
                </select>
            </p>
       	</div>
  	</div>
</form>
<script>
	$(document).ready(function() {
		$('#wizard').smartWizard();
		$("#nombre_completo").validacion({
			men: "Debe seleccionar un item"
		});
		$("#password").validacion({
			lonMin: 5,
			lonMax: 25
		});
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

						var html="<br><p><label>Usuario</label> <strong>"+data['usuario']+"</strong></p>";
	
						$("#info_adicional").html(html);
					}
					else {	
						alertify.alert('Error al intentar buscar empleado: No se encuentra el registro');
						$("#info_adicional").html("");
					}
				},
				error:function(data) { 
					alertify.alert('Error al intentar buscar empleado: No se pudo conectar al servidor');
					$("#info_adicional").html("");
				}
			});
		});
	});
</script>