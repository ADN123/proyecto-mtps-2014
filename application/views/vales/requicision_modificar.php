<script>


	var permiso=<?php echo $id_permiso;?>;
	estado_transaccion='<?php echo $estado_transaccion;?>';
	estado_correcto='La requisición se ha guardado correctamente';
	estado_incorrecto='Error al intentar guardar la requisición: No se pudo conectar al servidor. Por favor vuelva a intentarlo.';

<?php if($accion==0) {  ?>
    estado_correcto='La requisición ya fue procesada';
<?php } ?>

function chekear(k, clase){
var obj = $('.'+clase);
var ban= $(k).prop('checked');

    for(i=0;i<obj.length;i++){
        obj[i].checked=ban;
    }
    marcados();
}


</script>
<script src="<?php echo base_url()?>js/views/modificar_requiscion.js" type="text/javascript"></script>
<section>
    <h2>Ingreso de Requisición de Combustible</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<?php print_r($requisicion); extract($requisicion)?> 
<form name="form_mision" method="post" id="form_mision" action="<?php echo base_url()?>index.php/vales/guardar_requisicion">
    <?=llaveform()?>
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
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Otros</small>
                    </span>
                </a>
            </li>
            
        </ul>                 

        <div id="step-1">	
            <h2 class="StepTitle">Ingrese los datos de la requisición</h2>
           

                <p>
                <label for="id_seccion" id="lservicio_de">Al servicio de </label>
                <input type="hidden" id="id_requisicion" name="id_requision" value="<?php echo $id_requision; ?>" />
                <input type="hidden" id="id_seccion" name="id_seccion" value="<?php echo $id_seccion; ?>" />
                <input type="hidden" id="nombre" name="nombre" value="<?php echo $nombre_seccion; ?>" />
                <strong style="width:300px;" ><?php echo $nombre_seccion;?></strong>

                <label for="cantidad_solicitada" id="lcantidad_solicitada">Cantidad Solicitada </label>
                <?php
                if ($estado==1) { ?>
                
                    <input style="width:100px;" type="text" tabindex="1" id="cantidad_solicitada" name="cantidad_solicitada"
                    value="<?php echo $cantidad_solicitada;?>"                />
                
                <?php }else{ ?>
                    <input style="width:100px;" type="hidden" tabindex="1" id="cantidad_solicitada" name="cantidad_solicitada"
                    value="<?php echo $cantidad_solicitada;?>"                />               
                    <strong style="width:300px;" ><?php echo $cantidad_solicitada;?></strong>
                <? } ?>


               
                </p>
                
                 <p>

                <label for="mes" id="lmes">Para el mes de </label>
                <select  style="width:200px;" tabindex="5" id="mes" name="mes" onChange="cargar_vehiculo()">
                    <?php
                        foreach($m as $val) {
                    ?>

                      <option value="<?php echo $val['mes'] ?>"><?php echo strtoupper($val['mes_nombre']) ?></option>
                    <?php   
                        }
                    ?>
                </select>
            
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Financiamento </label>
                <select style="width:200px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo" onChange="cargar_vehiculo()">

                    <?php
                        foreach($fuente as $val) {
                    ?>
                       <option value="<?php echo $val['id_fuente_fondo'] ?>"><?php echo $val['nombre_fuente'] ?></option>
                    <?php   
                        }
                    ?>
                </select>

            </p>
                        <br>
            <p>
            	<label for="justificacion" id="ljustificacion" class="label_textarea">Justificación </label>
              	<textarea class="tam-4" id="justificacion" tabindex="3" name="justificacion"/><?php echo $justificacion;?></textarea>
            </p>
                        <br>
            <p>
                 <label for="cantidad_entregado" id="lcantidad_entregada">Cantidad Autorizada </label>
                <?php
                if ($estado>2) { ?>
                    <input style="width:100px;" type="hidden" tabindex="1" id="cantidad_entregado" name="cantidad_entregado"
                    value="<?php echo $cantidad_entregado;?>"                />               
                    <strong style="width:300px;" ><?php echo $cantidad_entregado;?></strong>
                
                <?php }else{
                    if ($estado==2) { ?>
    
                        <input style="width:100px;" type="text" tabindex="1" id="cantidad_entregado" name="cantidad_entregado"
                        value="<?php echo $cantidad_entregado;?>"                />
                    <?php }else{ ?>

                        <input style="width:100px;" type="hidden" tabindex="1" id="cantidad_entregado" name="cantidad_entregado"
                        value="<?php echo $cantidad_entregado;?>"                />               

                <? }

            } ?>

            </p>    

            <p>
                <div style="display:none">

                <label for="lbl" id="lrefuezo" >Refuerzo: </label>
                <input  id="refuerzo"  name="refuerzo" type="hidden" />
                <input type="hidden" name="restante" id="restante">
                <strong id="lbl"></strong> 
                <label for="lbl2" id="lrefuezo" >Cuota Asignada: </label>
                <strong id="lbl2"></strong> 
                <label for="lbl3" id="lrestante" >Restantes: </label>
                <strong id="lbl3"></strong> 
                 </div>


            </p>
      	</div>
        <div id="step-2">	
            <h2 class="StepTitle">Selecci&oacute;n los vehiculos a los que se aplicarán los vales</h2>
                 Seleccionar/Deseleccionar todo <input type="checkbox"  onchange="chekear(this, 'cheke1')" >
            <p ><div id="divVehiculos">
                    
                    <br/><br/><br/>Debe seleccionar <strong>Fuente de Fondo, Sección </strong> y <strong>Mes </strong>...
            </div>


                <div style="display:none;">   
            <label for="verificando" id="lverificando" class="label_textarea">Cantidad de Vehiculos</label>
                    <input type="text" id="verificando" name="verificando"  >  </div>
            	
            </p>

        </div>
        <div id="step-3">   
            <h2 class="StepTitle">Seleccione las herramientas u otro tipo de articulo  en el que se aplicarán los vales</h2>

                 Seleccionar/Deseleccionar todo <input type="checkbox"  onchange="chekear(this,'cheke2')" >
            <p ><div id="divHerramientas">
                        <br/><br/><br/>Debe seleccionar <strong>Fuente de Fondo, Sección </strong> y <strong>Mes </strong>...
            </div>

        </div>

    </div>
</form>

<script>


var estado_requisicion=<?php echo $estado; ?>;

function iniciar () {
    //iniciar valores
    $("#mes").val(<?php echo $mes;?>);   
    $("#id_fuente_fondo").val(<?php echo $id_fuente_fondo;?>);

    //constructores
    $("#mes").kendoDropDownList({
        value:<?php echo $mes;?>
    });
    $("#id_fuente_fondo").kendoDropDownList({
        value:<?php echo $id_fuente_fondo;?>
    });
    //destrucores de validaciones
    $('#mes').destruirValidacion();
    $('#id_fuente_fondo').destruirValidacion();
    
    cargar_vehiculo();

}

setTimeout ("iniciar()", 1000);
</script>