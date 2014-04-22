<script>
	var permiso=<?php echo $id_permiso?>;
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='La requisición se ha guardado correctamente';
	estado_incorrecto='Error al intentar guardar la requisición: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<script src="<?php echo base_url()?>js/views/solicitud.js" type="text/javascript"></script>
<section>
    <h2>Ingreso de Requisición</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post" action="<?php echo base_url()?>index.php/transporte/guardar_solicitud">
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
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de acompa&ntilde;antes</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Ingreso de datos de Vales</h2>
            <p> 
            <label for="cantidad" id="lcantidad">Cantidad Solicitada</label>
             <input type="text" tabindex="3" id="cantidad" name="cantidad"/>
            </p>
            <p> <label for="cantidad" id="lnumInicial">Numero inicial</label>
              <input type="text" tabindex="4"  id="numInicial" name="numInicial"/>

                <label for="hora_regreso" id="lhora_regreso">Numero final	</label>
                <input type="text" tabindex="5" id="numFinal" name="numFinal"/>
            </p>
            <p style="text-align: center;">
            <span id="resultado_fecha" style="color: #F00; font-size: 12px;"></span></p>
            <p>Justificación
              <textarea class="tam-4" id="observaciones" tabindex="10" name="observaciones"/></textarea>
            </p>
      	</div>
        <div id="step-2">	
            <h2 class="StepTitle">Selecci&oacute;n los vehiculos </h2>
            <p style="margin-left: 5%; width:90%;">
            	Para agregar un nuevo destino de click  en la imagen <a title="Agregar destino" rel="leanModal" href="#ventana"><img src="<?php echo base_url()?>img/mapa.mini.png" /></a>
            </p>
            <p>
            	<table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            Municipio
                        </th>
                        <th>
                            Lugar de destino
                        </th>  
                        <th>
                            Direcci&oacute;n
                        </th>
                        <th>
                            Misi&oacute;n Encomendada
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
        <div id="step-3">	
            <h2 class="StepTitle">Selecci&oacute;n de las personas que ir&aacute;n en el veh&iacute;culo</h2>
            <p>
                <label for="acompanantes" id="lacompanantes" style="vertical-align: text-bottom;">Acompa&ntilde;antes</label>
                <select name="acompanantes[]" id="acompanantes" class="multi" multiple="multiple" tabindex="9" placeholder="[Seleccione...]" style="width:350px;">
                <?php
                     foreach($acompanantes as $val) {
                         echo '<option value="'.$val['NR'].'">'.ucwords($val['nombre']).'</option>';
                     }
                ?>
                </select>
            </p> 
            <p>
                <label for="acompanantes2" id="lacompanantes2" class="label_textarea">Otros acompa&ntilde;antes</label>
                <textarea class="tam-4" id="acompanantes2" tabindex="10" name="acompanantes2"/></textarea>
            </p>
        </div>
    </div>
</form>
<div id="ventana" style="height:390px">
	<div id="signup-header">
        <h2>Agregar Destino</h2>
        <a class="modal_close"></a>
    </div>
    <form id="formu_destino" name="formu_destino" method="post">
        <fieldset>
            <legend align="left">Información del Destino</legend>
            <p>
            	<label for="mision_encomendada" id="lmision_encomendada">Misi&oacute;n </label>
				<input type="text" tabindex="2"  style="width:263px;" id="mision_encomendada" name="mision_encomendada"/>
          	</p> 
            <p>
                <label for="lugar_destino" id="llugar_destino">Lugar de destino </label>
             	<input type="text" tabindex="7" class="tam-2" id="lugar_destino" name="lugar_destino"/>
            </p>
            <p>
                <label for="direccion_empresa" id="ldireccion_empresa" class="label_textarea">Direcci&oacute;n</label>
                <textarea class="tam-4" id="direccion_empresa" tabindex="10" name="direccion_empresa"/></textarea>
            </p>
            <p>
                <label for="municipio" id="lmunicipio">Municipio</label>
                <select name="municipio" id="municipio" class="select" tabindex="6" placeholder="[Seleccione...]" style="width:275px;">
                <?php
                     foreach($municipios as $val) {
                         echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
                     }
                ?>
                </select>
         	</p>
		</fieldset>
        <p style="text-align: center;">
            <button type="button" id="agregar" class="boton_validador">Agregar</button>
        </p>
  	</form>
</div>