
<section>
    <h2>Asignación de Vehículo y Motorista</h2>
</section>


<table  id="grid">

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
    <td><?=$fila->fecha?>&nbsp;&nbsp;<?=$fila->salida?></td>>
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
                                       <select name="vehiculo">
                                       <?php
                                       foreach ($vehiculos as $fila1)
                                       {
									   ?>
                                       		<option value="<?php echo $fila1->placa; ?>">
											<?php echo $fila1->marca." - ".$fila1->modelo." - ".$fila1->tipo_vehiculo." - ".$fila1->condicion; ?>
                                            </option>
                                       <?php
									   }
									   ?>
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
		url:	"<?=base_url()?>/index.php/transporte/datos_de_solicitudes/"+id,
		dataType:"json",
		success: function(data){
			 json2 = data;
			console.log(json2);				
			
			},
		error:function(data){
			 alert('Error al cargar datos de alumnos');
			console.log(data);
			}
		});	
	}
	
	$("#grid").kendoGrid({
		height: 225,
		width: 800,
		sortable: true,
		dataSource: {
			type: "odata",
			pageSize: 5
		},
		pageable: {
			pageSizes: true,
			buttonCount: 5
		},
	});
	
		$(function() {
			$('a[rel*=leanModal]').leanModal({ top : 50 });		
		});

</script>