<section>
    <h2>Asignación de Vehículo y Motorista</h2>
</section>
<table  class="grid">

<thead>
  <tr>
    <th>Fecha y Hora</th>
    <th>Sección</th>
    <th>Persona Solicitante</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php    

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?php echo $fila->fecha?>&nbsp;&nbsp;<?php echo $fila->salida?></td>
    <td><?php echo $fila->seccion?></td>
    <td><?php echo ucwords($fila->nombre)?></td>
    <td><a rel="leanModal" title="Asignar Vehículo" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana">
</div>

<script language="javascript" >
function dialogo(id)
{
	$('#ventana').load('cargar_datos_solicitud/'+id);
				
	return false;
}

function motoristaf(id,id2){
		
		$('#motorista').empty();
		$.ajax({
		async:	true, 
		url:	"<?php echo base_url()?>/index.php/transporte/verificar_motoristas/"+id+"/"+id2,
		dataType:"json",
		success: function(data)
		{
			json = data;
			
			for(i=0;i<json.length;i++)
			{			
				$('#motorista').append('<option value="'+json[i].id_empleado+'">'+json[i].nombre.capitalize()+'</option>');
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