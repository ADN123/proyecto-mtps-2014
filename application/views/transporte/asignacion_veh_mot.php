
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
                                       <select name="motorista">
                                       <?php
                                       foreach ($motoristas as $fila2)
                                       {
									   ?>
                                       		<option value="<?php echo $fila2->NR; ?>">
											<?php echo $fila2->nombre." ".$fila2->apellido; ?>
                                            </option>
                                       <?php
									   }
									   ?>
                                       </select>
                                        </p>
                                    </fieldset>
                                    <p>
                                    <button id="asignar" name="asignar">Asignar</button>
                                    </p>


</div>
<script language="javascript" >

function dialogo(id){

		$.ajax({
		async:	true, 
		url:	"<?=base_url()?>/index.php/transporte/verificar_fecha_hora/"+id,
		dataType:"json",
		success: function(data){
		
			 json = data;

			for(i=0;i<json.length;i++){
				$('#vehiculo').append('<option value="'+json[i].id_vehiculo+'">'+json[i].id_vehiculo+'</option>');
				
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
		url:	"<?=base_url()?>/index.php/transporte/verificar_fecha_hora/"+id,
		dataType:"json",
		success: function(data){
//				alert("ok"); console.log();


			},
			
		error:function(data){
			 alert('Error al cargar los datos de los vehículos');
		
			}
		});	
	}
</script>