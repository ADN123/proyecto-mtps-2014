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
<?

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?=$fila->salida?></td>
    <td><?=$fila->entrada?></td>
    <td><?=$fila->placa?></td>
	<td><?php echo ucwords($fila->nombre)?></td>
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?=$fila->id?>,<?=$fila->estado?>)"><img  src="<?=base_url()?>img/vehiculo<?=$fila->estado?>.png"/></a>
	</td>
  </tr>
<? } ?>
</tbody>
</table> 

<div id="ventana">
	<div id="signup-header">
        <h2>Control de Entradas y Salidas</h2>
        <a class="modal_close"></a>
    </div>
    <form name="datos" method="post" action="<? echo base_url()?>index.php/transporte/guardar_despacho" id="datos">
    <div id="formulario"> 
    	<div id="izq"  style=" width:50%; float:left;" type="text"> 
                 <input type="hidden" name="estado" id="estado" />
				<input type="hidden" name="id" id="id" />
				<input type="hidden" id="kmi" />

    	           <div id="InfoMision" style="font-size:12px;">
                   
                  </div> 
                  <p>
                     Kilometraje actual:
                    <input id="km"  name="km"   class="tam-2"  autofocus="autofocus" />
                  </p>
                   <p>
                    Hora:
                    <input id="timepicker"  name="hora" />
	              </p>       

        </div>
     
     	<div id="dere" style="width:50%; float:left;">
			<div id="preview" >
        	    <canvas  id="canvas-preview"></canvas>
    			<div id="preview-textfield"></div>% Combustible
         	</div>    
			<input id="gas"  name="gas"  onchange="tanque(this.value)" type="range" min="10" max="100" step="10"   value="50"/>        
         </div>
     </div>
           <button type="submit"  id="aprobar">Guardar</button>
  </form>

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
			men: "Por Ingrese la Hora",
			req: true
			
 });
 $("#km").validacion({
			men: "Por Ingrese el kilometraje",
			req: true,
			numMin: 0
	});
	


</script>
