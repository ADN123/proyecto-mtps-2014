<form name="form_vehiculo" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_taller" >
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
            	<label>Oficina: </label>
                <select name="oficina" class="select" style="width:350px">
                	<option value="6">Oficina Central (San Salvador)</option>
                    <option value="12">Oficina Regional de Oriente (San Miguel)</option>
                    <option value="2">Oficina Regional de Occidente (Santa Ana)</option>
                    <option value="8">Oficina Paracentral (Zacatecoluca, La Paz)</option>
                	<option value="1">Oficina Departamental de Ahuachapán</option>
                    <option value="9">Oficina Departamental de Sensuntepeque, Cabañas</option>
                    <option value="4">Oficina Departamental de Chalatenango</option>
                    <option value="7">Oficina Departamental de Cojutepeque, Cuscatlán</option>
                    <option value="5">Oficina Departamental de Santa Tecla, La Libertad</option>
                    <option value="14">Oficina Departamental de La Unión</option>
                    <option value="13">Oficina Departamental de Morazán</option>
                    <option value="10">Oficina Departamental de San Vicente</option>
                    <option value="3">Oficina Departamental de Sonsonate</option>
                    <option value="11">Oficina Departamental de Usulután</option>
                </select>
            </p>
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