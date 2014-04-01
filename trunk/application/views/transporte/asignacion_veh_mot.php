<script>
var requiere_motorista;
</script>
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
<?php    

	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?php echo $fila->fecha?>&nbsp;&nbsp;<?php echo $fila->salida?></td>
    <td><?php echo $fila->lugar?></td>
    <td><?php echo $fila->mision?></td>
    <td><a rel="leanModal" title="Asignar Vehículo" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana">
</div>

<script language="javascript" >
/*
function dialogo(id){

	$.ajax({
	async:	true,
	url:	"base_url()/index.php/transporte/datos_de_solicitudes/"+id,
	dataType:"json",
	success: function(data){
		console.log(data);
document.getElementById('id_solicitud').value=id;
var echo1="Nombre: <strong>"+data[0].nombre+"</strong> <br>" +
		   "Sección: <strong>"+data[0].seccion+"</strong> <br>";
		   
var echo2="Misión: <strong>"+data[0].mision+"</strong> <br>"+
		   "Fecha de Solicitud: <strong>"+data[0].fechaS+"</strong> <br>"+
		   "Fecha de Misión: <strong>"+data[0].fechaM+"</strong> <br>"+
		   "Hora de Salida: <strong>"+data[0].salida+"</strong> <br>"+
		   "Hora de Regreso: <strong>"+data[0].entrada+"</strong> <br>"+
		   "Municipio: <strong>"+data[0].municipio+"</strong> <br>"+
		   "Lugar: <strong>"+data[0].lugar+"</strong> <br>";
			requiere_motorista=data[0].req;
				document.getElementById('motorista').style("display: none");
			if(requiere_motorista==0)
			{
					alert()
			}
			
			//alert(requiere_motorista);
			//document.getElementById('requiere_motorista').value=require_motorista;
		//document.getElementById('empleado').innerHTML=echo1;
		document.getElementById('mision').innerHTML=echo2;
		
		dialogo1(id);
					
		},
	error:function(data){
		 alert('Error al cargar datos');
		console.log(data);
		}
	});	
}

/*function carga_select(id_s,re_mot)
{
	if(re_mot==0)
	{
		$('#motorista').attr("disabled", true);
		$('#motorista').append('<option value="3">Oscar</option>');
	}
	dialogo(id_s);
}

function dialogo1(id1){
		$.ajax({
		async:	true, 
		url:	"base_url()/index.php/transporte/verificar_fecha_hora/"+id1,
		dataType:"json",
		success: function(data){
		document.getElementById('id_solicitud').value=id1;
			 json = data;

			for(i=0;i<json.length;i++){
				
				$('#vehiculo').append('<option value="'+json[i].id_vehiculo+'">'+json[i].placa+' - '+json[i].nombre+' - '+json[i].modelo+'</option>');
				
				}
				
				//////$('#vehiculo').kendoCombobox();
				
			},
			
		error:function(data){
			 alert('Error al cargar los datos de los vehículos');
		
			}
		});
}*/
	
function motoristaf(id){
		
		$('#motorista').empty();
		
		$.ajax({
		async:	true, 
		url:	"<?php echo base_url()?>/index.php/transporte/verificar_motoristas/"+id,
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