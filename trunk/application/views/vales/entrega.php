<script>
	var permiso=<?php echo $id_permiso;?>;
	estado_transaccion='<?php echo $estado_transaccion;?>';
	estado_correcto='La requisición se ha guardado correctamente';
	estado_incorrecto='Error al intentar guardar la requisición: No se pudo conectar al servidor. Por favor vuelva a intentarlo.';
</script>
<script src="<?php echo base_url()?>js/views/entrega_vales.js" type="text/javascript"></script>
<section>
    <h2>Ingreso de Requisición de Combustible</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post" id="form_mision" action="<?php echo base_url()?>index.php/vales/guardar_requisicion">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de vales</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Selección de vehículos</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingrese los de datos de los vales de combustible</h2>
           
            <p> 
                <label for="cantidad_solicitada" id="lcantidad_solicitada">Cantidad Solicitada </label>
                <input style="width:100px;" type="text" tabindex="1" id="cantidad_solicitada" name="cantidad_solicitada"/>
                 
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                <select class="select" style="width:200px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo" onChange="cargar_vehiculo()">
                    <?php
                        foreach($fuente as $val) {
                    ?>
                       <option value="<?php echo $val['id_fuente_fondo'] ?>"><?php echo $val['nombre_fuente'] ?></option>
                    <?php   
                        }
                    ?>
                </select>
            </p>
            <p>
            	<label for="justificacion" id="ljustificacion" class="label_textarea">Justificación </label>
              	<textarea class="tam-4" id="justificacion" tabindex="3" name="justificacion"/></textarea>
            </p>
            <p>
            	<label for="id_seccion" id="lservicio_de">Al servicio de </label>
                <?php 
					if($id_permiso==3) {
				?>
                    <select class="select" style="width:300px;" tabindex="4" id="id_seccion" name="id_seccion" onChange="cargar_vehiculo()">
                        <?php
							foreach($oficinas as $val) {
						?>
                        		<option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
                        <?php	
							}
						?>
                    </select>
             	<?php 
					} else {
                        if(sizeof($oficinas)==0)
                            echo '<strong> La seccion no cuenta con vehiculos </strong>';

						foreach($oficinas as $val) {
							echo '<strong>'.ucwords($val['nombre_seccion']).'</strong>';
				?>
                			<input type="hidden" id="id_seccion" name="id_seccion" value="<?php echo $val['id_seccion']; ?>" />
                <?php
						}
					}
				?>
            </p>
      	</div>
        <div id="step-2">	
            <h2 class="StepTitle">Selecci&oacute;n los vehiculos a los que se aplicarán los vales</h2>
            <p ><div id="divVehiculos"></div>
            	
            </p>
        </div>
    </div>
</form>
