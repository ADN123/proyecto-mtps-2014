<section>
    <h2>Control de Solicitudes</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>Fecha y Hora</th>
    <th>Destino</th>
    <th>Mision Encomendada</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?php echo $fila->fecha?></td>
    <td><?php echo $fila->lugar?></td>
    <td><?php echo $fila->mision?></td>
    <td><a title="Ver solicitud" title="Asignar Vehículo" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
	<div id="signup-header">
        <h2>Solicitud de Misi&oacute;n Oficial</h2>
        <a class="modal_close"></a>
    </div>
   <form action="<?php echo base_url()?>index.php/transporte/aprobar_solicitud" id="form" method="post">
       <input type="hidden"   id="resp" name="resp"/>
       <input type="hidden"   id="ids" name="ids"/>
       
        <fieldset  >
                <legend align="left">Información del  Solicitante</legend>
                <div id="empleado" style="font-size:14px;"> </div>        
         </fieldset>
         <br />
         <fieldset>      
              <legend align="left">Información de la Solicitud</legend>
               <div  id="mision" style="font-size:14px;"></div>
         </fieldset>
    <p>
        <label for="observacion" id="lobservacion">Observacion</label>
        <textarea class="tam-4" id="observacion" tabindex="2" name="observacion"/></textarea>
    </p>
    <p style="text-align: center;">
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador" name="aprobar" onclick="Enviar(2)">Aprobar</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador" name="Denegar" onclick="Enviar(0)">Denegar</button>
	</p>
    <form>
</div>
<script language="javascript" >

function dialogo(id){

		$.ajax({
		async:	true, 
		url:	"<?php echo base_url()?>/index.php/transporte/datos_de_solicitudes/"+id,
		dataType:"json",
		success: function(data){
			console.log(data);
			 document.getElementById('ids').value=id;

 	var echo1="Nombre: <strong>"+data[0].nombre+"</strong> <br>" +
		       "Sección: <strong>"+data[0].seccion+"</strong> <br>";
			   
	var echo2="Misión: <strong>"+data[0].mision+"</strong> <br>"+
		       "Fecha de Solicitud: <strong>"+data[0].fechaS+"</strong> <br>"+
   		       "Fecha de Misión: <strong>"+data[0].fechaM+"</strong> <br>"+
		       "Hora de Salida: <strong>"+data[0].salida+"</strong> <br>"+
		       "Hora de Regreso: <strong>"+data[0].entrada+"</strong> <br>"+
			   "Municipio: <strong>"+data[0].municipio+"</strong> <br>"+
			   "Lugar: <strong>"+data[0].lugar+"</strong> <br>";
			
			document.getElementById('empleado').innerHTML=echo1;
			document.getElementById('mision').innerHTML=echo2;
						
			},
		error:function(data){
			 alert('Error al cargar datos');
			console.log(data);
			}
		});	
	}
	
	function Enviar(v){
		document.getElementById('resp').value=v;
	}
	
	$("#observacion").validacion({
			req: false,
			lonMin: 10
		});
</script>