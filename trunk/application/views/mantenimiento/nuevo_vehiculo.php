<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha registrado un nuevo vehículo exitosamente.';
	estado_incorrecto='Error al registrar un nuevo vehículo: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Nuevo Vehículo</h2>
</section>
<form name="form_vehiculo" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_vehiculo" >
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información de los vehículos</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Adquisición de los vehículos</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Asignación de los vehículos</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de los vehículos</h2>
			<p>
                <label>Número de Placa:</label>
                <input type="text" name="placa" size="10" />
            </p>
            <p>
                <label>Marca:</label>
                 <select name="marca">
                <?php
                
                foreach($marca as $mar)
                {
                    echo "<option value='".$mar->id_vehiculo_marca."'>".ucwords($mar->nombre)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Modelo:</label>
                 <select name="modelo">
                <?php
                
                foreach($modelo as $model)
                {
                    echo "<option value='".$model->id_vehiculo_modelo."'>".ucwords($model->modelo)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Clase:</label>
                 <select name="clase">
                <?php
                
                foreach($clase as $cla)
                {
                    echo "<option value='".$cla->id_vehiculo_clase."'>".ucwords($cla->nombre_clase)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Fotografía:</label>
                <input type="file" name="imagen" />
            </p>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de adquisición de los vehículos</h2>
            <p>
                <label>Tipo:</label>
                <select name="tipo">
                    <option>Propio</option>
                    <option>Donado por Banco Mundial</option>
                </select>
            </p>
            <p>
                <label>Condición:</label>
                 <select name="condicion">
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
            <h2 class="StepTitle">Informaci&oacute;n de asignación de motorista y sección de los vehículos</h2>
            <p>
                <label>Sección:</label>
                <select name="seccion">
                <?php
                
                foreach($seccion as $sec)
                {
                    echo "<option value='".$sec->id_seccion."'>".ucwords($sec->nombre_seccion)."</option>";
                }
                ?>
                </select>
            </p>
            <p>
                <label>Motorista:</label>
                <select name="motorista">
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
});
</script>