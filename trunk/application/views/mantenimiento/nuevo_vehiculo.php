<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha registrado un nuevo vehículo exitosamente.';
	estado_incorrecto='Error al registrar un nuevo vehículo: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Nuevo Vehículo</h2>
</section>
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
	
	$action=base_url()."index.php/vehiculo/modificar_vehiculo/".$id_vehiculo;
}
else $action=base_url()."index.php/vehiculo/guardar_vehiculo";
?>
<form name="form_vehiculo" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">

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
                 <select name="marca" id="marca" class="select" tabindex="1" placeholder="[Seleccione...]" style="width:150px">
                <?php
                foreach($marca as $mar)
                {
					if($bandera=='true')
					{
						print_r($mar->id_vehiculo_marca);
						if($mar->id_vehiculo_marca==$id_marca) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
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
                 <select name="modelo" id="modelo" class="select" placeholder="[Seleccione...]" style="width:200px">
                <?php
                
                foreach($modelo as $model)
                {
					if($bandera=='true')
					{
						if($model->id_vehiculo_modelo==$id_modelo) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";
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
                 <select name="clase" id="clase" class="select" placeholder="[Seleccione...]" style="width:150px">
                <?php
                
                foreach($clase as $cla)
                {
					if($bandera=='true')
					{
						if($cla->id_vehiculo_clase==$id_clase) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
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
                <select name="fuente" id="fuente" class="select" placeholder="[Seleccione...]" style="width:250px">
                <?php                
					foreach($fuente_fondo as $fue)
					{
						if($bandera=='true')
						{
							if($fue->id_fuente_fondo==$id_fuente_fondo) $s='selected="selected"';
							else $s='';
							echo "<option ".$s." value='".$fue->id_fuente_fondo."'>".ucwords($fue->fuente)."</option>";
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
                 <select name="condicion" id="condicion" class="select" placeholder="[Seleccione...]" style="width:175px">
                <?php
                foreach($condicion as $con)
                {
					if($bandera=='true')
					{
						if($con->id_vehiculo_condicion==$id_condicion) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
					}
					echo "<option value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
                }
                ?>
                </select>
            </p>
            <?php
			if($bandera=='true')
			{
				?>
				<p>
                    <label>Estado: </label>
                    <select name="estado" id="estado" class="select" placeholder="[Seleccione...]" style="width:150px">
                        <option value="0" <?php if($estado==0) echo "selected='selected'"; ?>>De Baja</option>
                        <option value="1" <?php if($estado==1) echo "selected='selected'"; ?>>Activo</option>
                        <option value="2" <?php if($estado==2) echo "selected='selected'"; ?>>En Taller Interno</option>
                        <option value="3" <?php if($estado==3) echo "selected='selected'"; ?>>En Taller Externo</option>
                        <option value="4" <?php if($estado==4) echo "selected='selected'"; ?>>Robado</option>
                    </select>
            	</p>
				<?php
			}
            ?>
            <p>
            	<label>Tipo de Combustible</label>
                <select name="tipo_combustible" class="select" placeholder="[Seleccione...]" style="width:150px">
                	<option value="Diesel" <?php if($bandera=='true'){ if(strcmp($tipo_combustible,'Diesel')==0) echo "selected='selected'";} ?>>Diesel</option>
                    <option value="Gasolina" <?php if($bandera=='true'){ if(strcmp($tipo_combustible,'Gasolina')==0) echo "selected='selected'";} ?>>Gasolina</option>
                </select>
            </p>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de asignación de motorista, oficina y sección del vehículo</h2>
            <p>
                <label>Sección: </label>
                <select name="seccion" class="select" placeholder="[Seleccione...]" style="width:350px">
                <?php
                
                foreach($seccion as $sec)
                {
					if($bandera=='true')
					{
						if($sec->id_seccion==$id_seccion) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
					}
					echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
                    
                }
                ?>
                </select>
            </p>
            <p>
                <label>Motorista: </label>
                <select name="motorista" class="select" placeholder="[Seleccione...]" style="width:300px">
				<?php
                
                foreach($motoristas as $mot)
                {
					if($bandera=='true')
					{
						if($mot->id_empleado==$id_motorista) $s='selected="selected"';
						else $s='';
						echo "<option ".$s." value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
					}
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