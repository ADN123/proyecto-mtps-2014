<script type="text/javascript" src="<?php echo base_url()?>js/prettify.js"></script>
<script src="<?php echo base_url()?>js/gauge.js"></script>


<section>
    <h2>Control de Entradas y Salidas</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>Empleado</th>
    <th>Salida</th>
    <th>Regreso</th>
    <th>Vehiculo</th>
    <th>Municipio</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?=$fila->nombre?></td>
    <td><?=$fila->salida?></td>
    <td><?=$fila->entrada?></td>
    <td><?=$fila->placa?></td>
	<td><?=$fila->municipio?></td>
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
    <form name="datos" method="post" action="<?base_url()?>index.php/transporte/guardar_despacho">
    <div id="formulario"> 
    	<div id="izq"  style="float:left; width:50%" type="text"> 
        	      <p>
                    <label for="timepicker" > Hora</label> 
                    <input id="timepicker"  name="hora" />
	              </p>
    	           <p>
                    <label for="km" >Kilometraje Inicial</label><br> 
                    <input id="km"  name="km"   class="tam-1"/>
                  </p>        
                   <p>
                    <label for="kmf" >Kilometraje Final </label><br> 
                    <input id="kmf"  name="kmf"   class="tam-1"/>
                  </p>        
        </div>
     
     	<div id="dere" style="float:left;  width:30%;";>
			<div id="preview" >
        	    <canvas  id="canvas-preview"></canvas>
    			<div id="preview-textfield" style="float:left;"></div>
                <label style=" float:left;">% Combustible</label>                    
         	</div>    
			<input id="km"  name="km"  onchange="gas(this.value)" type="range" min="10" max="100" step="10"   value="50"/>        
         </div>
     </div>
  </form>





</div>
<script>
function dialogo(id, val){
	if(val==3){
$('#dere').hide();
$('#kmf').hide();
	}else{
$('#dere').show();
$('#kmf').show();
	}

}


function gas(val){
      	demoGauge.set(parseInt(val));
     	AnimationUpdater.run();	
}
	
 $("#timepicker").kendoTimePicker();
 
 
  function update() {

    demoGauge.ctx.clearRect(0, 0, demoGauge.ctx.canvas.width, demoGauge.ctx.canvas.height);
    demoGauge.render(); 
  }
  
  function initGauge(){

    demoGauge = new Gauge(document.getElementById("canvas-preview"));
    demoGauge.setTextField(document.getElementById("preview-textfield"));
    demoGauge.maxValue = 100;
    demoGauge.set(50);
  };
 
  $(function() {
    var params = {};
    $('.opts input[min], #opts .color').each(function() {
      var val = params[this.name];
      if (val !== undefined) this.value = val;
      this.onchange = update;
    });
 
    initGauge();
    update();
    
  });
</script>
