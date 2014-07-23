<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha registrado un nuevo vehículo exitosamente.';
	estado_incorrecto='Error al registrar un nuevo vehículo: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Nuevo Vehículo</h2>
</section>
<form name="form_vehiculo" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_vehiculo" enctype="multipart/form-data" accept-charset="utf-8">

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
                <input type="text" name="placa" size="10" />
            </p>
            <p>
                <label>Marca: </label>
                 <select name="marca" id="marca" class="select" style="width:150px">
                <?php
                
                foreach($marca as $mar)
                {
                    echo "<option value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
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
                    echo "<option value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";
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
                    echo "<option value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
                }
                ?>
                <option value="0">Otra</option>
                </select>
                <input type="text" name="nclase" id="nclase" disabled="disabled"/>
            </p>
            <p>
            	<label>A&ntilde;o: </label>
                <input type="text" name="anio" size="10" />
            </p>
            <p>
                <label>Fotografía: </label>
                <input type="file" name="userfile" id="userfile" disabled="disabled" />
                <label>Imagen por defecto</label>
                <input type="checkbox" name="img_df" id="img_df" value="si" checked="checked"  />
            </p>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de fuente de fondo del vehículo</h2>
            <p>
                <label>Fuente de Fondo: </label>
                <select name="fuente" id="fuente" class="select" style="width:250px">
                <?php                
					foreach($fuente_fondo as $fue)
					{
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
                    echo "<option value='".$con->id_vehiculo_condicion."'>".ucwords($con->condicion)."</option>";
                }
                ?>
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
                    echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Sección de Asignación de vales: </label>
                <select name="seccion_vales" class="select" style="width:350px">
                <?php
                
                foreach($seccion as $sec)
                {
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
                    echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
                }
                ?>
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
});


</script>