<script>
	var permiso=<?php echo $id_permiso?>;
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='La solicitud se ha almacenado exitosamente.';
	estado_incorrecto='Error al intentar guardar la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php if($solicitud['id_solicitud_transporte']!="") {?>
		id='<?php echo $solicitud['id_empleado_solicitante'];?>';
	<?php }?>
</script>
<section>
    <h2>Nueva solicitud para Misi&oacute;n Oficial</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post" action="<?php echo base_url()?>index.php/transporte/guardar_solicitud">
	<?php if($solicitud['id_solicitud_transporte']!="") {?>
		<input type="hidden" name="id_solicitud_old" id="id_solicitud_old" value="<?php echo $solicitud['id_solicitud_transporte'];?>" />
    <?php }?>
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
					if($id_permiso>1 && $solicitud['id_solicitud_transporte']=="") {
				?>
                    <select name="nombre" id="nombre" tabindex="1" placeholder="[Seleccione...]" class="select" style="width:40%">
                    <?php
                        foreach($empleados as $val) {
                            echo '<option value="'.$val['NR'].'">'.ucwords($val['nombre']).'</option>';
                        }
                    ?>
                    </select>
             	<?php 
					} 
					else {
						if($solicitud['id_solicitud_transporte']=="") {
							foreach($empleados as $val) {
								echo '<strong>'.ucwords($val['nombre']).'</strong>';
				?>
                				<input type="hidden" id="nombre" name="nombre" value="<?php echo $val['NR']; ?>" />
                <?php
							}
						}
						else {
								echo '<!--<strong style="font-size: 11px;">'.ucwords($solicitud['nombre']).'</strong>-->';
				?>
                				<!--<input type="hidden" id="nombre" name="nombre" value="<?php echo $solicitud['id_empleado_solicitante']; ?>" />-->
                                <select name="nombre" id="nombre" tabindex="1" placeholder="[Seleccione...]" class="select" style="width:40%">
                                <?php
                                    foreach($empleados as $val) {
                                        echo '<option value="'.$val['NR'].'">'.ucwords($val['nombre']).'</option>';
                                    }
                                ?>
                                </select>
				
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
									"<p><label>Cargo Nominal</label> <strong>".$info['nominal']."</strong></p>".
									"<p><label>Cargo Funcional</label> <strong>".$info['funcional']."</strong></p>".
									"<p><label>Departamento</label> <strong>".$info['nivel_2']."</strong></p>".
									"<p><label>Secci&oacute;n</label> <strong>".$info['nivel_1']."</strong></p>";
						}else
						if($solicitud['id_solicitud_transporte']!="") {
							echo	"<p><label>NR</label> <strong>".$info['nr']."</strong></p>".
									"<p><label>Cargo Nominal</label> <strong>".$info['nominal']."</strong></p>".
									"<p><label>Cargo Funcional</label> <strong>".$info['funcional']."</strong></p>".
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
          		<input type="checkbox" tabindex="8" id="requiere_motorista" name="requiere_motorista" value="1" title="S&iacute;" <?php if($solicitud['requiere_motorista']==1) echo 'checked="checked"'; ?>/>
            </p> 
            <p>
                <label for="observaciones" id="lobservaciones" class="label_textarea">Observaciones</label>
                <textarea class="tam-4" id="observaciones" tabindex="10" name="observaciones"/><?php echo $solicitud['observacion']; ?></textarea>
            </p>
      	</div>
        <div id="step-3">	
            <h2 class="StepTitle">Selecci&oacute;n de los destinos que tendr&aacute; el viaje</h2>
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
                        <?php
							 foreach($solicitud_destinos as $val) {
						?>
                        		<tr>
                                	<td><?php echo $val['lugar']; ?></td>
                                    <td><?php echo $val['lugar_destino']; ?></td>
                                    <td><?php echo $val['direccion_destino']; ?></td>
                                    <td><?php echo $val['mision_encomendada']; ?></td>
                                    <td align="center">
                                    	<a onClick="borrar_item(this)">
                                        	<img src="<?php echo base_url();?>img/ico_basura.png" width="25" height="25" align="absmiddle" title="Borrar item"/>
                                    	</a>
                                  	</td>
                                    <input type="hidden" name="values[]" value="<?php echo $val['id_municipio'].'**'.$val['lugar_destino'].'**'.$val['direccion_destino'].'**'.$val['mision_encomendada'];?>"/>
                             	</tr>
                        <?php
							 }
						?>
                    </tbody>
                </table>
            </p>
        </div>
        <div id="step-4">	
            <h2 class="StepTitle">Selecci&oacute;n de las personas que ir&aacute;n en el veh&iacute;culo</h2>
            <p>
                <label for="acompanantes" id="lacompanantes" style="vertical-align: text-bottom;">Acompa&ntilde;antes</label>
                   
                <select name="acompanantes[]" id="acompanantes"  multiple="multiple" tabindex="9" placeholder="[Seleccione...]" style="width:350px;">
                <?php
                     foreach ($solicitud_acompanantes as $val) {
                            
                    echo '<option value="'.$val->id_empleado.'" selected>'.ucwords($val->nombre).'</option>';
                        
                    }


                     foreach($acompanantes as $val) {
						 /*if(in_array($rs->fields['NR'], $solicitud_acompanantes))*/
                         	echo '<option value="'.$val['NR'].'">'.ucwords($val['nombre']).'</option>';   //aqui el nr es un nombre,  porque en realidad se esta trabajando con el id
                     }
                ?>
                </select>

            </p> 
            <p>
                <label for="acompanantes2" id="lacompanantes2" class="label_textarea">Personal Externo</label>
                <textarea class="tam-4" id="acompanantes2" tabindex="10" name="acompanantes2"/><?php echo $solicitud['acompanante']; ?></textarea>
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
<script src="<?php echo base_url()?>js/views/solicitud.js" type="text/javascript"></script>

<script type="text/javascript">
$('#acompanantes').kendoMultiSelect({
        filter: "contains"  
    });
</script>