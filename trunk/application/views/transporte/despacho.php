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
<?php

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?php echo $fila->nombre?></td>
    <td><?php echo $fila->salida?></td>
    <td><?php echo $fila->entrada?></td>
    <td><?php echo $fila->placa?></td>
	<td><?php echo $fila->municipio?></td>
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila->id?>,<?php echo $fila->estado?>)"><img  src="<?php echo base_url()?>img/vehiculo<?php echo $fila->estado?>.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table> 

<div id="ventana">
	<div id="signup-header">
        <h2>Control de Entradas y Salidas</h2>
        <a class="modal_close"></a>
    </div>
    <form name="datos" method="post" action="<?php echo base_url()?>index.php/transporte/guardar_despacho">
    <div id="formulario"> 
    	<div id="izq"  style=" width:50%; float:left;" type="text"> 
                 <input type="hidden" name="estado" id="estado" />
				<input type="hidden" name="id" id="id" />

    	           <div id="InfoMision" style="font-size:12px;">
                   
                  </div> 
                  <p>
                     Kilometraje actual:
                    <input id="km"  name="km"   class="tam-2"  autofocus="autofocus"/>
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
           <button type="submit"  id="aprobar" class="button tam-1 boton_validador">Guardar</button>
  </form>

</div>
<script>
function info(id){
$.ajax({
		async:	true, 
		url:	"<?php echo base_url()?>/index.php/transporte/infoSolicitud/"+id,
		dataType:"json",
		success: function(data){
			

	 	var echo1="Solicitud numero:<strong>"+id+"</strong><br />"+
                   " Solicitante:<strong> "+data[0].nombre+"</strong><br />"+
                    "Hora de Salida:<strong>"+data[0].salida+"</strong><br />"+
                    "Hora de Regreso:<strong>"+data[0].regreso+"</strong><br />"+
                   " Vehiculo:<strong>"+data[0].modelo+"</strong><br />"+
                    "Placa:<strong>"+data[0].placa+"</strong><br /> ";
			  
			  			console.log(echo1);
			document.getElementById('InfoMision').innerHTML=echo1;

			},
		error:function(data){
			 alert('Error al cargar datos');
			console.log(data);
			}
		});	
	
}

function dialogo(id, val){
	$('#id').val(id);
	$('#estado').val(val);

	if(val==3){
		$('#dere').hide();
			}else{
		$('#dere').show();
	}
	info(id);	
}


function tanque(val){
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
