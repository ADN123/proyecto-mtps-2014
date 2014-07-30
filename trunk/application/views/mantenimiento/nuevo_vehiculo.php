<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha registrado un nuevo vehículo exitosamente.';
	estado_incorrecto='Error al registrar un nuevo vehículo: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Nuevo Vehículo</h2>
</section>
<form name="form_vehiculo" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_vehiculo" enctype="multipart/form-data" accept-charset="utf-8">
<?php

if($bandera=='true')
{
	foreach($vehiculo_info as $v)
	{
		$id_vehiculo=$v->id_vehiculo;
		$placa=$v->placa;
		$marca2=$v->marca;
		$id_marca=$v->id_marca;
		$modelo2=$v->modelo;
		$id_modelo=$v->modelo;
		$condicion2=$v->condicion;
		$id_condicion=$v->id_condicion;
		$clase2=$v->clase;
		$id_clase=$v->id_clase;
		$kilometraje=$v->kilometraje;
		$motorista=ucwords($v->motorista);
		$id_motorista=$v->id_empleado;
		$anio=$v->anio;
		$fuente_fondo2=$v->fuente_fondo;
		$id_fuente_fondo=$v->id_fuente_fondo;
		$seccion2=ucwords($v->seccion);
		$id_seccion=$v->id_seccion;
		$imagen=$v->imagen;
		$estado=$v->estado;	
		$tipo_combustible=$v->tipo_combustible;
	}
}
?>
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del vehículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Adquisición del vehículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Asignación del vehículo</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n del vehículo</h2>
			<p>
                <label>Número de Placa: </label>
                <input type="text" name="placa" size="10" <?php if($bandera=='true') echo "value='".$placa."'" ?> />
               
            </p>
            <p>
                <label>Marca: </label>
                 <select name="marca" id="marca" class="select" style="width:150px">
                <?php
                foreach($marca as $mar)
                {
					if($bandera=='true')
					{
						if($mar->id_vehiculo_marca==$id_marca)
						{
							echo "<option value='".$mar->id_vehiculo_marca."' selected='selected'>".ucwords($mar->nombre)."</option>";
						}
						else echo "<option value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
					}
					else echo "<option value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
                }
				
                ?>
                <option value="0">Otra</option>
                </select>
                <input type="text" name="nmarca" id="nmarca" disabled="disabled"/>
            </p>
            <p>
                <label>Modelo: </label>
                 <select name="modelo" id="modelo" class="select" style="width:200px">
                <?php
                
                foreach($modelo as $model)
                {
					if($bandera=='true')
					{
						if($model->id_vehiculo_modelo==$id_modelo)
						{
							echo "<option value='".$model->id_vehiculo_modelo."' selected='selected'>".ucwords($model->modelo)."</option>";
						}
						else echo "<option value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";
					}
					else echo "<option value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";                    
                }
                ?>
                <option value="0">Otro</option>
                </select>
                <input type="text" name="nmodelo" id="nmodelo" disabled="disabled"/>
            </p>
            <p>
                <label>Clase: </label>
                 <select name="clase" id="clase" class="select" style="width:150px">
                <?php
                
                foreach($clase as $cla)
                {
					if($bandera=='true')
					{
						if($cla->id_vehiculo_clase==$id_clase)
						{
							echo "<option value='".$cla->id_vehiculo_clase."' selected='selected'>".ucwords($cla->nombre_clase)."</option>";
						}
						else echo "<option value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
					}
					else echo "<option value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
                }
                ?>
                <option value="0">Otra</option>
                </select>
                <input type="text" name="nclase" id="nclase" disabled="disabled"/>
            </p>
            <p>
            	<label>A&ntilde;o: </label>
                <input type="text" name="anio" size="10" <?php if($bandera=='true') echo "value='".$anio."'"; ?> />
            </p>
            <p>
                <label>Fotografía: </label>
                <input type="file" name="userfile" id="userfile" disabled="disabled" />
                <?php if($bandera=='true') {?>
                	<label>Mantener imagen</label>
                    <input type="checkbox" name="img_df" id="img_df" value="si" checked="checked" />
                    <input type="text" name="imagen" value='<?php echo $imagen ?>' disabled="disabled" ?/>
                <?php }else{ ?>
                <label>Imagen por defecto</label>
                <input type="checkbox" name="img_df" id="img_df" value="si" checked="checked"  />
                <?php }?>
            </p>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de adquisición del vehículo</h2>
            <p>
                <label>Fuente de Fondo: </label>
                <select name="fuente" id="fuente" class="select" style="width:250px"onChange="asignacion(this.value)">
                <?php                
					foreach($fuente_fondo as $fue)
					{
						if($bandera=='true')
						{
							if($fue->id_fuente_fondo==$id_fuente_fondo)
							{
								echo "<option value='".$fue->id_fuente_fondo."' selected='selected'>".ucwords($fue->fuente)."</option>";
							}
							else echo "<option value='".$fue->id_fuente_fondo."'>".ucwords($fue->fuente)."</option>";
						}
						echo "<option value='".$fue->id_fuente_fondo."'>".ucwords($fue->fuente)."</option>";
					}
                ?>
                <option value="0">Otra</option>
                </select>
                <input type="text" name="nfuente" id="nfuente" disabled="disabled"/>
            </p>
            <p>
                <label>Condición: </label>
                 <select name="condicion" id="condicion" class="select" style="width:175px">
                <?php
                foreach($condicion as $con)
                {
					if($bandera=='true')
					{
						if($con->id_vehiculo_condicion==$id_condicion)
						{
							echo "<option value='".$con->id_vehiculo_condicion."' selected='selected'>".ucwords($con->condicion)."</option>";
						}
						else echo "<option value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
					}
					echo "<option value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
            	<label>Tipo de Combustible</label>
                <select name="tipo_combustible" class="select" style="width:150px">
                	<option value="Diesel" <?php if($bandera=='true'){ if(strcmp($tipo_combustible,'Diesel')==0) echo "selected='selected'";} ?>>Diesel</option>
                    <option value="Gasolina" <?php if($bandera=='true'){ if(strcmp($tipo_combustible,'Gasolina')==0) echo "selected='selected'";} ?>>Gasolina</option>
                </select>
            </p>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de asignación de motorista, oficina y sección del vehículo</h2>
            <p>
                <label>Sección: </label>
                <select name="seccion" class="select" style="width:350px">
                <?php
                
                foreach($seccion as $sec)
                {
					if($bandera=='true')
					{
						if($sec->id_seccion==$id_seccion)
						{
							echo "<option value='".$sec->id_seccion."' selected='selected'>".ucwords($sec->seccion)."</option>";
						}
						else echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
					}
					echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
                    
                }
                ?>
                </select>
            </p>
            <p>
                <label>Motorista: </label>
                <select name="motorista" class="select" style="width:300px">
				<?php
                
                foreach($motoristas as $mot)
                {
					if($mot->id_empleado==$id_empleado)
							{
								echo "<option value='".$mot->id_empleado."' selected='selected'>".ucwords($mot->nombre)."</option>";
							}
							else echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
                    echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
                }
                ?>
                <option value="0">Sin asignación</option>
                </select>
            </p>
        </div>
    </div>
</form>

<script>
$(document).ready(function(){
	$('#wizard').smartWizard();
	$('#marca').change(
		function()
		{
			if(Number($(this).val())==0)
			{
				$("#nmarca").attr("disabled",false);
			}
			else
			{
				$("#nmarca").attr("disabled",true);
				$("#nmarca").val("");
			}
		}
	);
	$('#marca').kendoComboBox({
		index:34
	});
	$('#modelo').change(
		function()
		{
			if(Number($(this).val())==0)
			{
				$("#nmodelo").attr("disabled",false);
			}
			else
			{
				$("#nmodelo").attr("disabled",true);
				$("#nmodelo").val("");
			}
		}
	);
	$('#clase').change(
		function()
		{
			if(Number($(this).val())==0)
			{
				$("#nclase").attr("disabled",false);
			}
			else
			{
				$("#nclase").attr("disabled",true);
				$("#nclase").val("");
			}
		}
	);
	$('#fuente').change(
		function()
		{
			if(Number($(this).val())==0)
			{
				$("#nfuente").attr("disabled",false);
			}
			else
			{
				$("#nfuente").attr("disabled",true);
				$("#nfuente").val("");
			}
		}
	);
	$('#img_df').change(
		function()
		{
			if($("#img_df").is(':checked'))
			{  
				$("#userfile").attr("disabled",true); 
			}
			else
			{  
				$("#userfile").attr("disabled",false);
			} 
		}
	);
    function asignacion (id_fuente_fondo) {
        
            $('#seccion_vales').empty();

    }
});


</script>