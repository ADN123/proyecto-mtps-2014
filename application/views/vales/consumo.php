<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='El registro de consumo de vales se ha almacenado exitosamente.';
	estado_incorrecto='Error al intentar guardar el registro de consumo de vales: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Ingreso de comsumo de vales</h2>
</section>
<form name="formu" id="formu" action="<?=base_url()?>index.php/vales/guardar_consumo" method="post" autocomplete="off">
	<?=llaveform()?>

    <div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de la factura</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Detalle de consumo </small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1" style="text-align: center;">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de la factura</h2>
            <br />
            <div style="width: 40%; display: inline-block; margin-left: 9%; text-align: left;">
                <p>
                    <label for="id_gasolinera" id="lid_gasolinera" style="width:35%;">Proveedor</label>
                    <select tabindex="1" class="select" id="id_gasolinera" name="id_gasolinera" style="width:175px">
						<?php
                             foreach($gasolineras as $val) {
                                 echo '<option value="'.$val['id_gasolinera'].'">'.$val['nombre'].'</option>';
                             }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="fecha_factura" id="lfecha_factura" style="width:35%;">Fecha Factura </label>
                    <input type="text" tabindex="2" id="fecha_factura" name="fecha_factura"/>
                </p>
                <p>
                    <label for="numero_factura" id="lnumero_factura" style="width:35%;">N&deg; Factura </label>
                    <input type="text" size="15" tabindex="3" id="numero_factura" name="numero_factura"/> 
                </p>

           	</div>
            <div style="width: 40%; display: inline-block; margin-right: 9%; text-align: left;">
                <p>
                    <label for="valor_super" id="lvalor_super" style="width:35%;">Precio Super </label>
                    $ <input tabindex="4" id="valor_super" name="valor_super" type="text" size="5"/> US
                </p>
                <p>
                    <label for="valor_regular" id="lvalor_regular" style="width:35%;">Precio Regular </label>
                    $ <input tabindex="5" id="valor_regular" name="valor_regular" type="text" size="5"/> US
                </p>
                <p>
                    <label for="valor_diesel" id="lvalor_diesel" style="width:35%;">Precio Diesel </label>
                    $ <input tabindex="6" id="valor_diesel" name="valor_diesel" type="text" size="5"/> US
                </p>
            </div>
            <?php  if (sizeof($seccion)!=1) {  ?>

                  <p align="left">
                    <label for="seccion" id="lseccion" style="width:20%;">Sección </label>
                   <select tabindex="7" class="select" id="id_seccion" name="id_seccion" style="width:275px">
                        <?php
                             foreach($seccion as $val) {
                                 echo '<option value="'.$val['id_seccion'].'">'.$val['seccion'].'</option>';
                             }
                        ?>
                    </select>
            </p>
            <?php }else{ ?>    
            
                    <input  id="id_seccion" name="id_seccion" type="hidden" value="<?php echo $seccion; ?>"/> US

            <?php } ?>    
        </div>
        <div id="step-2" style="text-align: center;">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de la cantidad suministrada a cada veh&iacute;culo</h2>
            
            <p >
            	<div id="divVehiculos"><br/><br/><br/>Debe seleccionar una <strong>gasolinera</strong> e ingresar la <strong>fecha de la factura</strong>...</div>
      		</p>
			<input type="hidden" name="total" id="total" />
        </div>
    </div>
</form>
<script src="<?php echo base_url()?>js/views/consumo_vales.js" type="text/javascript"></script>