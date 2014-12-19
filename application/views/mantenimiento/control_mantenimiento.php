<?php
foreach($vehiculos as $v)
{
	$id_vehiculo=$v->id;
	$placa=$v->placa;
}
?>
<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha ingresado el vehículo a taller interno, éxitosamente';
	estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
</script>
<section>
    <h2>Ingreso de Vehículo al Taller Interno</h2>
</section>
<form name="form_mtto" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_mantenimiento" >
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del Vehículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Revisión Interna</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Revisión Externa</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
           <h2 class="StepTitle">Datos Generales del Vehículo</h2>
            <table>
            <tr>
            <td width="300px">
			<p>
                <label style="width:150px">Fecha de Recepción: </label>
                <strong><?php echo date('d/m/Y')?></strong>
            </p>
            <?php if($bandera=='false'){ ?>
            <p>
                <label style="width:100px">Seleccione un número de placa: </label>
                <select class="select" style="width:100px" onchange="cargar(this.value)" name="id_vehiculo" id="id_vehiculo">
                	<?php
					foreach($vehiculos as $v)
					{
						echo "<option value='".$v->id."'>".$v->placa."</option>";
					}
                    ?>
                </select>
            </p>
            <?php }else{ ?>
            <p>
            	<input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo; ?>" />
                <label style="width:150px">Número de placa: </label>
                <strong><?php echo $placa; ?></strong>
            </p>
			<?php } ?>
            </td>
            <td width="700px">
            <p>
            	<label class="label_textarea" style="width:100px">Trabajo solicitado: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado"></textarea>
                <label class="label_textarea" style="width:100px">Trabajo solicitado en carrocería: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado_carroceria"></textarea>
            </p>
            </td>
            </tr>
            <tr>
            <td colspan="2" valign="bottom">
			<div id="info_vehiculo">
            </div>
            </td>
            </tr>
            </table>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Revisión Interna del Vehículo</h2>
            <table width="600px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Interno</th>
                        <th>Si/No</th>
                        <th>Interno</th>
                        <th>Si/No</th>
                    </tr>
                </thead>
            	<tbody>
                <?php
					$aux=0;
					foreach($revision as $rev)
					{
						if($rev['tipo']=='interno')
						{
							if($aux==0)
							{
								if($rev['cantidad']==1)
								{
									echo "<tr>";
									echo "<td>".$rev['revision']." - Número: <input type='text' name='".$rev['id_revision']."' size='1px'></td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."' onchange='numero()' ></td>";
								}
								else
								{
									echo "<tr>";
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'> </td>";
								}
								$aux=1;
							}
							else
							{
								if($rev['cantidad']==1)
								{
									echo "<td>".$rev['revision']." - Número: <input type='text' name='".$rev['id_revision']."' size='1px'></td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
									echo "</tr>";
								}
								else
								{
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'> </td>";
									echo "</tr>";
								}
								$aux=0;
							}
						}
					}
					
					if($aux==1)
					{
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
					}
				?>
               </tbody>
            </table></td></tr></table>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Revisión Externa del vehículo</h2>
            <table width="600px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0" cellpadding="0">
            	<thead>
                	<tr>
                    	<th>Externo</th>
                        <th>Si/No</th>
                        <th>Externo</th>
                        <th>Si/No</th>
                    </tr>
                </thead>
            	<tbody>
                <?php
					$aux=0;
					foreach($revision as $rev)
					{
						if($rev['tipo']=='externo')
						{
							if($aux==0)
							{
								if($rev['cantidad']==1)
								{
									echo "<tr>";
									echo "<td>".$rev['revision']." - Número: <input type='text' name='".$rev['id_revision']."' size='1px'></td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";	
								}
								else
								{
									echo "<tr>";
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
								}
								$aux=1;
							}
							else
							{
								if($rev['cantidad']==1)
								{
									echo "<td>".$rev['revision']." - Número: <input type='text' name='".$rev['id_revision']."' size='1px'></td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
									echo "</tr>";
								}
								else
								{
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
									echo "</tr>";
								}
								$aux=0;
							}
						}
					}
					
					if($aux==1)
					{
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
					}
				?>
               </tbody>
            </table></td></tr></table>
        </div>
    </div>
</form>
<script>
$(document).ready(function(){
	$('#wizard').smartWizard(); 
	$('#alfombras').change(
		function()
		{
			if($("#alfombras").is(':checked'))
			{  
				$("#nalfombras").attr("disabled",false); 
			}
			else
			{  
				$("#nalfombras").attr("disabled",true);
				$("#nalfombras").val("");
			} 
		}
	);
	$('#copas').change(
		function()
		{
			if($("#copas").is(':checked'))
			{  
				$("#ncopas").attr("disabled",false); 
			}
			else
			{  
				$("#ncopas").attr("disabled",true);
				$("#ncopas").val("");
			} 
		}
	);
	$('#vidrios').change(
		function()
		{
			if($("#vidrios").is(':checked'))
			{  
				$("#nvidrios").attr("disabled",false); 
			}
			else
			{  
				$("#nvidrios").attr("disabled",true);
				$("#nvidrios").val("");
			} 
		}
	);
	
});

function cargar(id)
	{
		$('#info_vehiculo').html("");
		var  dur = "<?php echo base_url()?>index.php/vehiculo/vehiculo_info/"+id+"/1";
		console.log(dur);
		$.ajax({
			async:	true, 
			url:	dur,
			dataType:"json",
			success: function(data) {
				console.log(data);
				json = data;
				var cont="<br><br><table align='center' cellspacing='0' cellpadding='0' class='table_design'>";
				/*cont=cont+"<thead><tr><td>Datos Generales del Vehículo</td></tr></thead>";*/
				cont=cont+"<tr><td>Marca: <strong>"+json[0]['marca']+"</strong></td><td>Motorista Asignado: <strong>"+json[0]['motorista'].capitalize()+"</strong></td>";
				cont=cont+'</tr><tr>'
				cont=cont+'<td>Modelo: <strong>'+json[0]['modelo']+'</strong></td> <td>Oficina Asiganada: <strong>'+json[0]['seccion']+'</strong></td>';
				cont=cont+'</tr><tr>'
				cont=cont+'<td>Clase: <strong>'+json[0]['clase']+'</strong></td><td>Kilometraje Actual: <strong>'+json[0]['kilometraje']+' km</strong></td>';
				cont=cont+'</tr><tr>'
				cont=cont+'<td>Año: <strong>'+json[0]['anio']+'</strong></td><td>Tipo de Combustible: <strong>'+json[0]['tipo_combustible']+'</strong></td>';
				cont=cont+'</tr>'
				cont=cont+'</table>';
				$('#info_vehiculo').html(cont);
			},
			error:function(data) {
				 alertify.alert('Error al cargar los datos de los vehiculos');
			}
		})
		
	}
</script>
<?php
if($bandera=='true')
{
?>
	<script>
		var id_v=<?php echo $id_vehiculo; ?>;
		cargar(id_v);
    </script>
<?php
}
?>

