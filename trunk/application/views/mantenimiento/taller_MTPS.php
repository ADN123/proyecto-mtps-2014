<form name="form_taller" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_taller" >
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
                        <small>&nbsp;Mantenimiento Realizado</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Inspección/Chequeo Realizado</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Datos Generales del Vehículo</h2>
			<p>
                <label>Número de Placa: </label>
                <select>
                	<?php
					foreach($vehiculos as $v)
					{
						echo "<option value='".$v->id_vehiculo."'>".$v->placa."</option>";
					}
                    ?>
                </select>
            </p>
            <p>
            </p>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Informaci&oacute;n del mantenimiento realizado al vehículo</h2>
            <p>
                <label>Cambio de Aceite y Filtro</label><input type="checkbox" name="aceite">
            </p>
            <p>
                <label>Ajuste/Limpieza de Frenos</label><input type="checkbox" name="frenos">
            </p>
            <p>
                <label>Sistema Eléctrico y Luces</label><input type="checkbox" name="electricidad">
            </p>
            <p>
                <label>Amortiguadores</label><input type="checkbox" name="amortiguadores">
            </p>
            <p>
                <label>Llantas</label><input type="checkbox" name="llantas">
            </p>
            <p>
                <label>Limpieza General de Motor</label><input type="checkbox" name="motor">
            </p>
            <p>
                <label>Limpieza de Bornes de Batería</label><input type="checkbox" name="bateria">
            </p>
            <p>
            	<label>Otros (Especifíque)</label>
                <textarea name="otros"></textarea>
            </p>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de inspección o chequeo realizado al vehículo</h2>
            <p>
            </p>
        </div>
    </div>
</form>