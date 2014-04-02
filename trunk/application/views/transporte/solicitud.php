<script>
	 var permiso=<?php echo $id_permiso?>;
</script>
<script src="<?php echo base_url()?>js/views/solicitud.js" type="text/javascript"></script>
<section>
    <h2>Nueva solicitud para Misi&oacute;n Oficial</h2>
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
                        <small>&nbsp;Datos de destino</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <span class="stepNumber">4<small>to</small></span>
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
                <label>Fecha</label>
                <strong><?php echo date('d/m/Y')?></strong>
            </p>
            <p>
                <label for="nombre" id="lnombre">Solicitante</label>
                <?php 
					if($id_permiso>1) {
				?>
                    <select name="nombre" id="nombre" tabindex="1" placeholder="[Seleccione...]" class="select" style="width:40%">
                    <?php
                        foreach($empleados as $val) {
							if($val['NR']==$solicitud['id_empleado_solicitante'])
							 	$sel='selected="selected"';
							else
								$sel="";
                            echo '<option '.$sel.' value="'.$val['NR'].'">'.ucwords($val['nombre']).'</option>';
                        }
                    ?>
                    </select>
             	<?php 
					} 
					else {
						foreach($empleados as $val) {
							echo '<strong>'.ucwords($val['nombre']).'</strong>';
				?>
                			<input type="hidden" id="nombre" name="nombre" value="<?php echo $val['NR']; ?>" />
                <?php
						}
					}
				?>
            </p> 
            <p>
            	<div id="info_adicional">
                	<?php
						if($id_permiso==1) {
							echo	"<p><label>NR</label> <strong>".$info['nr']."</strong></p>".
									"<p><label>Cargo</label> <strong>".$info['funcional']."</strong></p>".
									"<p><label>Departamento</label> <strong>".$info['nivel_2']."</strong></p>".
									"<p><label>Secci&oacute;n</label> <strong>".$info['nivel_1']."</strong></p>";
						}
					?>
                </div>
            </p> 
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Ingreso de datos del viaje</h2>
            <p>
                <label for="fecha_mision" id="lfecha_mision">Fecha Misi&oacute;n </label>
                <input type="text" tabindex="3" id="fecha_mision" name="fecha_mision" value="<?php echo $solicitud['fecha_mision']; ?>"/>
            </p>
            <p>
                <label for="hora_salida" id="lhora_salida">Hora de salida </label>
                <input type="text" tabindex="4" class="inicio" id="hora_salida" name="hora_salida" value="<?php echo $solicitud['hora_salida']; ?>"/>

                <label for="hora_regreso" id="lhora_regreso">Hora de regreso </label>
                <input type="text" tabindex="5" class="fin" id="hora_regreso" name="hora_regreso" value="<?php echo $solicitud['hora_entrada']; ?>"/>
            </p>
            <p style="text-align: center;">
                <span id="resultado_fecha" style="color: #F00; font-size: 12px;"></span>
            </p>
            <p>
				<label for="requiere_motorista" id="lrequiere_motorista">Requiere motorista </label>
          		<input type="checkbox" tabindex="8" id="requiere_motorista" name="requiere_motorista" value="1" title="S&iacute;"/>
            </p> 
            <p>
                <label for="observaciones" id="lobservaciones" class="label_textarea">Observaciones</label>
                <textarea class="tam-4" id="observaciones" tabindex="10" name="observaciones"/></textarea>
            </p>
      	</div>
        <div id="step-3">	
            <h2 class="StepTitle">Selecci&oacute;n de los destinos que tendr&aacute; el viaje</h2>
            <p>
            	Para agregar un nuevo destino de click <a title="Agregar destino" rel="leanModal" href="#ventana">aqu&iacute;</a>
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
                        <th width="40">
                            Acci&oacute;n
                        </th>
                    </thead>
                    <tbody id="content_table">
                        
                    </tbody>
                </table>
            </p>
        </div>
        <div id="step-4">	
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
                <textarea class="tam-4" id="acompanantes2" tabindex="10" name="acompanantes2"/><?php echo $solicitud['acompanante']; ?></textarea>
            </p>
        </div>
    </div>
</form>
<div id="ventana" style="height:390px">
	<div id="signup-header">
        <h2>Agregar destino</h2>
        <a class="modal_close"></a>
    </div>
    <form id="formu_destino" name="formu_destino" method="post">
        <fieldset>
            <legend align="left">Información del Destino</legend>
            <p>
            	<label for="mision_encomendada" id="lmision_encomendada">Misi&oacute;n </label>
				<input type="text" tabindex="2"  style="width:263px;" id="mision_encomendada" name="mision_encomendada" value="<?php echo $solicitud['mision_encomendada']; ?>"/>
          	</p> 
            <p>
                <label for="lugar_destino" id="llugar_destino">Lugar de destino </label>
             	<input type="text" tabindex="7" class="tam-2" id="lugar_destino" name="lugar_destino" value="<?php echo $solicitud['lugar_destino']; ?>"/>
            </p>
            <p>
                <label for="direccion_empresa" id="ldireccion_empresa" class="label_textarea">Direcci&oacute;n</label>
                <textarea class="tam-4" id="direccion_empresa" tabindex="10" name="direccion_empresa"/><?php echo $solicitud['acompanante']; ?></textarea>
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