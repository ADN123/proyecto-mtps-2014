<?php
foreach($vehiculos as $v)
{
	$id_vehiculo=$v->id;
	$placa=$v->placa;
}
?>
<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='';
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
                        <small>&nbsp;Datos de Ingreso</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Revisión Interna</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <span class="stepNumber">4<small>to</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Revisión Externa</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
           <h2 class="StepTitle">Datos Generales del Vehículo</h2>
            <p>
            	<input type="hidden" name="km_actual" id="km_actual" value="0" />
                <label style="width:150px">Fecha de Recepción: </label>
                <strong><?php echo date('d/m/Y'); //$fecha=getdate(); echo $fecha[year]."-".$fecha[mon]."-".$fecha[mday]." ".$fecha[hour]." ".$fecha[minutes].":".$fecha[seconds]?></strong>
            </p>
            <?php if($bandera=='false'){ ?>
            <p>
            	<input type="hidden" name="pantalla" value="1" />
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
            	<input type="hidden" name="pantalla" value="2" />
            	<input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo; ?>" />
                <label style="width:150px">Número de placa: </label>
                <strong><?php echo $placa; ?></strong>
            </p>
			<?php } ?>
            <div id="info_vehiculo">
            </div>
        </div>
        <div id="step-2">
        	<h2 class="StepTitle">Información de ingreso del Vehículo</h2>
            <p>
            	<label style="width:100px">Mecánico que recibió el vehículo: </label>
                <select style="width:300px" class="select" name="id_usuario_recibe_taller" id="id_usuario_recibe_taller" placeholder="Seleccione..." multiple="multiple">
                	<?php foreach($mecanicos as $m){?>
                    <option value="<?php echo $m['id_empleado']; ?>"><?php echo ucwords($m['nombre']) ?></option>
                    <?php }?>
                </select>
            </p>
            <p>
            	<label class="label_textarea" style="width:100px">Trabajo solicitado: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado" id="trabajo_solicitado"></textarea>
                <label class="label_textarea" style="width:100px">Trabajo solicitado en la carrocería: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado_carroceria" id="trabajo_solicitado_carroceria"></textarea>
            </p>
            <p>
                <label style="width:100px">Kilometraje: </label>
                <input type="text" name="kilometraje_ingreso" id="kilometraje_ingreso" />
            </p>
        </div>
        <div id="step-3">	
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
									echo "<td>".$rev['revision']." - Número: <input type='text' name='cantidad[]' id='".$rev['id_revision']."_1' size='1px' disabled='disabled'></td>";
									echo "<td><input type='checkbox' name='revision1[]' value='".$rev['id_revision']."' onchange='habilitar(".$rev['id_revision'].",this.checked)' ></td>";
								}
								else
								{
									echo "<tr>";
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision1[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'> </td>";
								}
								$aux=1;
							}
							else
							{
								if($rev['cantidad']==1)
								{
									echo "<td>".$rev['revision']." - Número: <input type='text' name='cantidad[]' id='".$rev['id_revision']."_1' size='1px' disabled='disabled'></td>";
									echo "<td><input type='checkbox' name='revision1[]' value='".$rev['id_revision']."' onchange='habilitar(".$rev['id_revision'].",this.checked)'></td>";
									echo "</tr>";
								}
								else
								{
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision1[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'> </td>";
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
                <tr>
                	<td colspan="4">Seleccionar/Deseleccionar Todo: <input type="checkbox" name="select_all_int" onclick="select_all(this.checked)" /></td>
                </tr>
               </tbody>
            </table></td></tr></table>
        </div>
        <div id="step-4">	
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
									echo "<td>".$rev['revision']." - Número: <input type='text' id='".$rev['id_revision']."_1' name='cantidad[]' size='1px' disabled='disabled'></td>";
									echo "<td><input type='checkbox' name='revision2[]' value='".$rev['id_revision']."' onchange='habilitar(".$rev['id_revision'].",this.checked)'></td>";	
								}
								else
								{
									echo "<tr>";
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision2[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
								}
								$aux=1;
							}
							else
							{
								if($rev['cantidad']==1)
								{
									echo "<td>".$rev['revision']." - Número: <input type='text' id='".$rev['id_revision']."_1' name='cantidad[]' size='1px' disabled='disabled'></td>";
									echo "<td><input type='checkbox' name='revision2[]' value='".$rev['id_revision']."' onchange='habilitar(".$rev['id_revision'].",this.checked)'></td>";
									echo "</tr>";
								}
								else
								{
									echo "<td>".$rev['revision'].": </td>";
									echo "<td><input type='checkbox' name='revision2[]' id='".$rev['id_revision']."' value='".$rev['id_revision']."'></td>";
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
                <tr>
                	<td colspan="4">Seleccionar/Deseleccionar Todo: <input type="checkbox" name="select_all_ext" onclick="select_all2(this.checked)" /></td>
                </tr>
               </tbody>
            </table></td></tr></table>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#wizard').smartWizard();
	
	$('#id_vehiculo').validacion({
		req:true
	});
	$('#id_usuario_recibe_taller').validacion({
		req:true
	});
	$('#trabajo_solicitado').validacion({
		req:true,
		lonMin:5
	});
	$('#trabajo_solicitado_carroceria').validacion({
		req:false,
		lonMin:5
	});
	$('#kilometraje_ingreso').validacion({
		req:true,
		num:true
	});
});

function select_all(chk)
{
	var cb = document.getElementsByName('revision1[]');
	
	for (i=0; i<cb.length; i++)
	{
		if(chk == true)
		{
			cb[i].checked = true;
			habilitar(cb[i].value,cb[i].checked);
		}
		else
		{
			 cb[i].checked = false;
			 habilitar(cb[i].value,cb[i].checked);
		}
	}
}

function select_all2(chk)
{
	var cb = document.getElementsByName('revision2[]');
	
	for (i=0; i<cb.length; i++)
	{
		if(chk == true)
		{
			cb[i].checked = true;
			habilitar(cb[i].value,cb[i].checked);
		}
		else
		{
			cb[i].checked = false;
			habilitar(cb[i].value,cb[i].checked);
		}
	}
}

function habilitar(id,chk)
{
	var id2=id+'_1';
	var tf=document.getElementById(id2);
	
	if(chk==true && tf!=null) tf.disabled=false;
	else if(chk==false && tf!=null) tf.disabled=true;
}

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
				document.getElementById('km_actual').value=json[0]['kilometraje'];
				$('#kilometraje_ingreso').validacion({
					req:true,
					num:true,
					numMin:document.getElementById('km_actual').value
				});
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

