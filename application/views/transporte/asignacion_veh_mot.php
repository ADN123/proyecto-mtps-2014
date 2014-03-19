
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
    <td><a rel="leanModal" href="#ventana" onclick="dialogo(<?=$fila->id?>)"><img  src="<?=base_url()?>img/lupa.gif"/></a>
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
    <legend align="left">Vehículos</legend>
        <p>
        <label>Información</label>
       <select  name="vehiculo" id="vehiculo" onchange="motorista(this.value)">    
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
    <button type="submit" id="asignar" name="asignar" onclick="enviar(3)">Asignar</button>
    </p>


</div>
<script language="javascript" >

function dialogo(id){
		
		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/verificar_fecha_hora/"+id,
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
	
function motorista(id){

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