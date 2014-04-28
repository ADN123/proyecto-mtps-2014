<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='El registro de vales se ha almacenado exitosamente.';
	estado_incorrecto='Error al intentar guardar el registro de vales: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<script src="<?php echo base_url()?>js/views/ingreso_vales.js" type="text/javascript"></script>
<section>
    <h2>Ingreso de vales de combustible</h2>
</section>
<form name="formu" id="formu" action="<?=base_url()?>/index.php/vales/guardar_vales" method="post">
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Datos de los vales</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1" style="text-align: center;">	
            <h2 class="StepTitle">Ingreso de la informaci&oacute;n de los vales de combustible</h2>
            <br />
            <div style="width: 40%; display: inline-block; margin-left: 9%; text-align: left;">
                <p>
                    <label for="fecha_recibido" id="lfecha_recibido" style="width:35%;">Fecha recibidos </label>
                    <input type="text" id="fecha_recibido" name="fecha_recibido"/>
                </p>
                <p>
                    <label for="cantidad" id="lcantidad" style="width:35%;">Cantidad de vales </label>
                    <input type="text"  size="5" tabindex="1" id="cantidad" name="cantidad"/> 
                </p>
                <p>
                    <label for="inicio" id="linicio" style="width:35%;">N&uacute;mero inicial </label>
                    <input  id="inicio" name="inicio" type="text" size="5"/>
                </p>
                <p>
                    <label for="tipo_vehiculo" id="ltipo_vehiculo" style="width:35%;">Desingnacion</label>
                    <select class="select" id="tipo_vehiculo" name="tipo_vehiculo" style="width:175px">
                    
                    </select>
                </p>
           	</div>
            <div style="width: 40%; display: inline-block; margin-right: 9%; text-align: left;">
            	<p style="height:34px">&nbsp;</p>
                <p>
                    <label for="valor_nominal" id="lvalor_nominal" style="width:35%;">Valor nominal </label>
                    $ <input type="text" size="5" id="valor_nominal" name="valor_nominal"/> US
            
                </p>
                <p style="height:34px">
                    <label for="final" id="lfinal" style="width:35%;">N&uacute;mero final</label>
                    <span><strong id="final"></strong></span>
                </p>
                <p>
                    <label for="id_gasolinera" id="lid_gasolinera" style="width:35%;">Proveedor</label>
                    <select class="select" id="id_gasolinera" name="id_gasolinera" style="width:175px">
    
                    </select>
                </p>
            </div>
        </div>
    </div>
</form>