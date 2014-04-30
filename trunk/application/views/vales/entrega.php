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
                        <small>&nbsp;Cantidad y justificación</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Vehiculos de destino</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingreso de datos de Vales</h2>
            <p> 
            <label for="cantidad" id="lcantidad">Cantidad Solicitada</label>
             <input type="text" tabindex="3" id="cantidad" name="cantidad" onchange="ultimoVale()"/>
             
                 <label for="select" id="lselect">Tipo de vehiculo</label>
            <select class="tam-1" tabindex="4" id="select" name="select"  onchange="ultimoVale()">
                <option value="1">Uso General</option>
                <option value="2">Donado por Banco</option>
            </select>
            </p>
             <p>
        
		    </p>
            <p> <label for="numInicial" id="lnumInicial">Numero inicial</label>
              <input type="text" tabindex="4"  id="numInicial" name="numInicial"  onchange="ultimoVale()"/>

                <label for="hora_regreso" id="lhora_regreso">Numero final	</label>
                <span id="numero final">0</span>
            </p>
            <p style="text-align: center;">
            <span id="resultado_fecha" style="color: #F00; font-size: 12px;"></span></p>
            <p><label for="observacion" class="label_textarea">Justificación</label>
              <textarea class="tam-4" id="observaciones" tabindex="10" name="observaciones"/></textarea>
            </p>
      	</div>
        <div id="step-2">	
            <h2 class="StepTitle">Selecci&oacute;n los vehiculos </h2>
            <p style="margin-left: 5%; width:90%;">
            	Chequee los vehículos a los cuales se aplicaran los vales solicitados   
            </p>
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
