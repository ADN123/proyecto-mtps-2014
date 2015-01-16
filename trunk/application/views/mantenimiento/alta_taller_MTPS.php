<?php extract($vehiculo) ?>
<section>
    <h2>Dar de Alta a Vehículo</h2>
</section>
<form name="form_alta_taller_MTPS" method="post" action="<?php echo base_url()?>index.php/vehiculo/dar_alta_taller_MTPS" >
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
                        <small>&nbsp;Entrega del Vehículo</small>
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
                <label style="width:150px">Fecha de Entrega: </label>
                <strong><?php echo date('d/m/Y')?></strong>
            </p>
            <p>
            	<input type="hidden" name="id_vehiculo" value="<?php echo $id_vehiculo; ?>" />
                <input type="hidden" name="placa" value="<?php echo $placa; ?>" />
                <input type="hidden" name="id_ingreso_taller" value="<?php echo $id_ingreso_taller; ?>" />
                <label style="width:150px">Número de placa: </label>
                <strong><?php echo $placa; ?></strong>
            </p>
			</td>
            <td width="700px">
            <p>
            	<label class="label_textarea" style="width:100px">Trabajo solicitado: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado"><?php echo $trabajo_solicitado; ?></textarea>
                <label class="label_textarea" style="width:100px">Trabajo solicitado en la carrocería: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado_carroceria" readonly="readonly"><?php echo $trabajo_solicitado_carroceria; ?></textarea>
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
           <h2 class="StepTitle">Información de entrega del vehículo</h2>
           <p>
            	<label style="width:100px">Motorista o persona que recibe el vehículo: </label>
                <select style="width:300px" class="select" name="id_motorista_recibe" placeholder="Seleccione..." multiple="multiple">
                	<?php foreach($empleado as $e){ 
					if($e['NR']==$id_empleado) $selected='selected="selected"';
					else $selected="";
					?>
                    <option value="<?php echo $e['NR']; ?>" <?php echo $selected ?>><?php echo ucwords($e['nombre']) ?></option>
                    <?php }?>
                </select>
            </p>
            <p>
            	<label class="label_textarea" style="width:100px">Notas: </label>
                <textarea style="width:200px; resize:none;" name="notas"></textarea>
            </p>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#wizard').smartWizard();
 	
});

function cargar(id)
	{
		$('#info_vehiculo').html("");
		var  dur = "<?php echo base_url()?>index.php/vehiculo/vehiculo_info/"+id+"/2";
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
<script>
	var id_v=<?php echo $id_vehiculo; ?>;
	cargar(id_v);
</script>