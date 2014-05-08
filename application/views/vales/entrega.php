<script>
	var permiso=<?php echo $id_permiso;?>;
	estado_transaccion='<?php echo $estado_transaccion;?>';
	estado_correcto='La requisición se ha guardado correctamente';
	estado_incorrecto='Error al intentar guardar la requisición: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
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
<form name="form_mision" method="post" action="<?php echo base_url()?>index.php/vales/guardar_requisicion">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos vales</small>
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
                <label for="seccion" id="lseccion">Unidad o Sección: </label>
                
          	</p>
            <p> 
                <label for="cantidad_solicitada" id="lcantidad_solicitada">Cantidad Solicitada </label>
                <input style="width:100px;" type="text" tabindex="1" id="cantidad_solicitada" name="cantidad_solicitada"/>
                 
                <label for="tipo_requisicion" id="ltipo_requisicion">Tipo de vehiculo </label>
                <select class="select" style="width:200px;" tabindex="2" id="tipo_requisicion" name="tipo_requisicion">
                    <option value="1">Uso General</option>
                    <option value="2">Donado por Banco</option>
                </select>
            </p>
            <p>
            	<label for="justificacion" id="ljustificacion" class="label_textarea">Justificación </label>
              	<textarea class="tam-4" id="justificacion" tabindex="3" name="justificacion"/></textarea>
            </p>
            <p>
            	<label for="servicio_de" id="lservicio_de">Al servicio de </label>
                <?php 
					if($id_permiso==3) {
				?>
                    <select class="select" style="width:300px;" tabindex="4" id="servicio_de" name="servicio_de">
                        <?php
							foreach($oficinas as $val) {
						?>
                        		<option value="<?php echo $val['id_ofi'] ?>"><?php echo $val['nom_ofi'] ?></option>
                        <?php	
							}
						?>
                    </select>
             	<?php 
					} 
					else {
						foreach($oficinas as $val) {
							echo '<strong>'.ucwords($val['nom_ofi']).'</strong>';
				?>
                			<input type="hidden" id="servicio_de" name="servicio_de" value="<?php echo $val['id_ofi']; ?>" />
                <?php
						}
					}
				?>
            </p>
      	</div>
        <div id="step-2">	
            <h2 class="StepTitle">Selecci&oacute;n los vehiculos a los que se aplicarán los vales</h2>
            <p>
            	<table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            Placa
                        </th>
                        <th>
                            Marca
                        </th>  
                        <th>
                            Modelo
                        </th>                  
                        <th width="40">
                            Acci&oacute;n
                        </th>
                    </thead>
                    <tbody id="content_table">
                        
                    </tbody>
                </table>
            </p>
        </div>
    </div>
</form>
