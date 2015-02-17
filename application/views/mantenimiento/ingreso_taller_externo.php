<?php
foreach($vehiculos as $v)
{
	$id_vehiculo=$v->id;
	$placa=$v->placa;
}
?>
<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha ingresado el vehículo a taller externo, éxitosamente';
	estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
</script>
<section>
    <h2>Ingreso de Vehículo al Taller Externo</h2>
</section>
<form name="form_taller_ext" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_taller_ext" >
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
            	<input type="hidden" name="id_vehiculo" id="id_vehiculo" value="<?php echo $id_vehiculo; ?>" />
                <label style="width:150px">Número de placa: </label>
                <strong><?php echo $placa; ?></strong>
            </p>
			<?php } ?>
            </td>
            <td width="700px">
            <p>
            	<label class="label_textarea" style="width:100px">Trabajo solicitado: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado" id="trabajo_solicitado"></textarea>
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
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#wizard').smartWizard();
	$('#id_vehiculo').validacion({
		req:true
	});
	$('#trabajo_solicitado').validacion({
		req:true,
		lonMin:5
	}); 	
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
