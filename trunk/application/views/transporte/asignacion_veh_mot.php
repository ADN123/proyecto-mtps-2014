
<section>
    <h2>Asignación de Vehículo y Motorista</h2>
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
<?    

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?=$fila->fecha?>&nbsp;&nbsp;<?=$fila->salida?></td>
    <td><?=$fila->lugar?></td>
    <td><?=$fila->mision?></td>
    <td><a rel="leanModal" title="Asignar Vehículo" href="#ventana" onclick="dialogo(<?=$fila->id?>)"><img  src="<?=base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<? } ?>
</tbody>
</table>

<div id="ventana">
    
    <div id="signup-header">
        <h2>Asignaci&oacute;n de Veh&iacute;culos y Motoristas</h2>
        <a class="modal_close"></a>
    </div>
    <form id="form" action="<?=base_url()?>index.php/transporte/asignar_veh_mot" method="post">
    <input type="hidden"   id="id_solicitud" name="id_solicitud"/>
    <input type="hidden" id="resp" name="resp" />
    
    <fieldset>      
        <legend align="left">Información de la Solicitud</legend>
        <div  id="mision" style="font-size:14px;"></div>
    </fieldset>
   
    <fieldset>
    <legend align="left">Vehículos</legend>
        <p>
        <label>Información</label>
       <select  name="vehiculo" id="vehiculo" onchange="motoristaf(this.value)">    
       </select>
        </p>   
    </fieldset>
    
    <fieldset>
    <legend align="left">Motorista</legend>
        <p>
        <label>Nombre</label>
       <select name="motorista" id="motorista">
       </select>
        </p>
    </fieldset>
     <p>
        <label for="observacion" id="lobservacion">Observación</label>
        <textarea class="tam-4" id="observacion" tabindex="2" name="observacion"/></textarea>
    </p>
    <br />
    <p>
    <button type="submit" id="asignar" name="asignar" onclick="enviar(3)">Asignar</button>
    </p>
	</form>

</div>
<script language="javascript" >

function dialogo(id){

	$.ajax({
	async:	true, 
	url:	"<?=base_url()?>/index.php/transporte/datos_de_solicitudes/"+id,
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
		
		dialogo1(id);
					
		},
	error:function(data){
		 alert('Error al cargar datos');
		console.log(data);
		}
	});	
}

function dialogo1(id1){
		
		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/verificar_fecha_hora/"+id1,
		dataType:"json",
		success: function(data){
		document.getElementById('id_solicitud').value=id;
			 json = data;

			for(i=0;i<json.length;i++){
				
				$('#vehiculo').append('<option value="'+json[i].id_vehiculo+'">'+json[i].placa+' - '+json[i].nombre+' - '+json[i].modelo+' - '+json[i].condicion+'</option>');
				
				}
			},
			
		error:function(data){
			 alert('Error al cargar los datos de los vehículos');
		
			}
		});	
	}
	
function motoristaf(id){


		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/verificar_motoristas/"+id,
		dataType:"json",
		success: function(data)
		{
			json = data;
			
			for(i=0;i<json.length;i++)
			{			
				$('#motorista').append('<option value="'+json[i].id_empleado+'">'+json[i].nombre+'</option>');
			}
		},
			
		error:function(data){
			 alert('Error al cargar los datos de los motoristas');
		
			}
		});	
	}
	
	function enviar(v){
		document.getElementById('resp').value=v;
	}
</script>