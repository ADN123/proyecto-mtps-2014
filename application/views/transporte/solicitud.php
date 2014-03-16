<script src="<?php echo base_url()?>js/views/solicitud.js" type="text/javascript"></script>
<section>
    <h2>Nueva solicitud para Misi&oacute;n Oficial</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post" action="controller.php">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos del solicitante</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de la Misi&oacute;n Oficial</small>
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
            <h2 class="StepTitle">Selecci&oacute;n de la persona que requiere el transporte</h2>
            <p>
                <label>Fecha:</label>
                <?php echo date('d/m/Y'); ?>
            </p>
            <p>
                <label for="nombre" id="lnombre">Solicitante:</label>
                <select name="nombre" id="nombre" tabindex="1" placeholder="[Seleccione...]" class="select" style="width:75%">
                <?php
                     foreach($empleados as $val) {
                         echo '<option value="'.$val['NR'].'">'.$val['nombre'].'</option>';
                     }
                ?>
                </select>
            </p>  
            <!--<p>
                <label for="seccion" id="lseccion">Secci&oacute;n</label>
                <select name="seccion" id="seccion" tabindex="3" placeholder="[Seleccione...]" class="select" style="width:75%">
                <?php
                     foreach($secciones as $val) {
                         echo '<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
                     }
                ?>
                </select>
            </p>--> 
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Ingreso de datos del viaje</h2>
             <p>
                 <label for="mision_encomendada" id="lmision_encomendada">Mision encomendada </label>
                 <input type="text" tabindex="2" class="tam-3" id="mision_encomendada" name="mision_encomendada"/>
            </p>
            <p>
                <label for="fecha_mision" id="lfecha_mision">Fecha Misi&oacute;n</label>
                <input type="text" class="fec_hoy" tabindex="3" id="fecha_mision" name="fecha_mision"/>
            </p>
            <p>
                <label for="hora_salida" id="lhora_salida">Hora de salida </label>
                <input type="text" tabindex="4" class="hora" id="hora_salida" name="hora_salida"/>

                <label for="hora_regreso" id="lhora_regreso">Hora de regreso </label>
                <input type="text" tabindex="5" class="hora" id="hora_regreso" name="hora_regreso"/>
            </p>
             <p>
                <label for="municipio" id="lmunicipio">Municipio</label>
                <select name="municipio" id="municipio" class="select" tabindex="6" placeholder="[Seleccione...]" style="width:50%;">
                <?php
                     foreach($municipios as $val) {
                         echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                     }
                ?>
                </select>
            </p> 
            <p>
             <label for="lugar_destino" id="llugar_destino">Lugar de destino </label>
             <input type="text" tabindex="7" class="tam-3" id="lugar_destino" name="lugar_destino"/>
            </p>
      	</div>
        <div id="step-3">	
            <h2 class="StepTitle">Selecci&oacute;n de las personas que ir&aacute;n en el veh&iacute;culo</h2>
            <p>
                <label for="acompanantes" id="lacompanantes">Acompa&ntilde;antes</label>
                <select name="acompanantes" id="acompanantes" class="multi" multiple="multiple" tabindex="8" placeholder="[Seleccione...]" style="width:400px;">
                <?php
                     foreach($acompanantes as $val) {
                         echo '<option value="'.$val['NR'].'">'.$val['nombre'].'</option>';
                     }
                ?>
                </select>
            </p> 
            <p>
                <label for="acompanantes2" id="lacompanantes2">Otros acompa&ntilde;antes</label>
                <textarea class="tam-4" id="acompanantes2" tabindex="9" name="acompanantes2"/></textarea>
            </p>
        </div>
    </div>
</form>