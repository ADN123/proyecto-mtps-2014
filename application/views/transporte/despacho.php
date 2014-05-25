<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
	estado_correcto='La <?php echo $accion?> de la Misión Oficial se ha almacenado exitosamente.';
	estado_incorrecto='Error al intentar almacenar la <?php echo $accion?> de la Misión Oficial: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<script type="text/javascript" src="<?php echo base_url()?>js/prettify.js"></script>
<script src="<?php echo base_url()?>js/gauge.js"></script>
<script src="<?php echo base_url()?>/js/views/despacho.js"></script>

<section>
    <h2>Control de Entradas y Salidas</h2>
</section>
<table  class="grid">
	<thead>
  		<tr>
    		<th>Salida</th>
    		<th>Regreso</th>
            <th>Vehiculo</th>
            <th>Empleado</th>
            <th>Opción</th>
  		</tr>
 	</thead>
 	<tbody>
		<?php
            foreach ($datos as $fila) {
				if($fila->estado==3)
					$mensaje="Dar salida a Misi&oacute;n Oficial";
				else
					$mensaje="Dar entrada a Misi&oacute;n Oficial";
        ?>
  		<tr>
            <td><?=$fila->salida?></td>
            <td><?=$fila->entrada?></td>
            <td><?=$fila->placa?></td>
            <td><?php echo ucwords($fila->nombre)?></td>
            <td><a title="<?=$mensaje?>" rel="leanModal" href="#ventana" onclick="dialogo(<?=$fila->id?>,<?=$fila->estado?>)"><img  src="<?=base_url()?>img/vehiculo<?=$fila->estado?>.png"/></a></td>
  		</tr>
		<?php }?>
	</tbody>
</table> 

<div id="ventana" style="height: 600px;">
	<div id="signup-header">
        <h2>Control de Entradas y Salidas</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
        <form name="datos" method="post" action="<?php echo base_url()?>index.php/transporte/guardar_despacho" id="datos">
            <input type="hidden" name="estado" id="estado" />
            <input type="hidden" name="id" id="id" />
            <input type="hidden" id="kmi" />
            <fieldset>
                <legend align='left'>Información de la Misión Oficial</legend>
                <div id="InfoMision"></div>
            </fieldset>
            <br />
            <fieldset>
                <legend align='left'>Información del veh&iacute;culo</legend>
                <div style="width: 48%; float:left; vertical-align: top;">
                    <p>
                        <label for="km" id="lkm" style="min-width: 120px;">Kilometraje actual </label>
                        <input type="text" id="km"  name="km"  class="tam-2"  autofocus="autofocus" />
                    </p>
                    <p>
                        <label for="timepicker" id="ltimepicker" style="min-width: 120px;">Hora </label>
                        <input id="timepicker" name="hora"/>
                    </p>  
                    <p>
                        <label for="gas" id="lgas" style="min-width: 120px;">Porcentaje Gasolina </label>
                		<input id="gas" name="gas"  onchange="tanque(this.value)" type="range" min="0" max="100" step="5" value="50" style="vertical-align: middle;"/>  
                    </p>  
              	</div>   
                <div id="preview" style="text-align: center; width: 48%; float: right; min-width: 245px;">
                    <canvas id="canvas-preview" style="margin: 0 auto; display: block;"></canvas>
                    <div id="preview-textfield" style="display:inline-block"></div><div style="display:inline-block">% Combustible</div>
                </div>  
            </fieldset>   
            <br />       
            <fieldset>
                <legend align='left'>Accesorios</legend>  
                <div id="divAccesorios">
                </div>
                Seleccionar/Deseleccionar todo <input type="checkbox"  onchange="chekear(this)" >
          	</fieldset>
            <br />
   	 		<p align="center"> 
            	<button type="submit" id="aprobar" class="boton_validador">Guardar</button>
           	</p>    
      	</form>
	</div>
</div>

<script type="text/javascript" language="javascript">
	$("#timepicker").kendoTimePicker({
  		animation: {
			close: {
				effects: "zoom:out",
				duration: 300
			}
		}
	});
	
	var timepicker = $("#timepicker").data("kendoTimePicker");
	timepicker.min("5:00 AM");
	timepicker.max("8:00 PM");

	$("#timepicker").validacion({
		men: "Porfavor ingrese la Hora"
 	});
	
 	$("#km").validacion({
		men: "Por Ingrese el kilometraje",
		numMin: 0
	});
</script>
