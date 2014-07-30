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
             <p>
                <label>Fecha de Recepción</label>
                <strong><?php echo date('d/m/Y')?></strong>
            </p>
			<p>
                <label>Seleccione un Número de Placa: </label>
                <select class="select" style="width:100px" onchange="cargar(this.value)" name="placa" id="placa">
                	<?php
					foreach($vehiculos as $v)
					{
						echo "<option value='".$v->id."'>".$v->placa."</option>";
					}
                    ?>
                </select>
            </p>
			<div id="info_vehiculo">
            </div>
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
                <tr>
                    <td align="right">Llanta de repuesto</td>
                    <td><input type="checkbox" name="llanta_repo" value="si"></td>

                    <td align="right">Mica</td>
                    <td><input type="checkbox" name="mica" value="si"></td>
                </tr>
                <tr>
                    <td align="right">Triángulo</td>
                    <td><input type="checkbox" name="triangulo" value="si"></td>

                    <td align="right">Herramientas</td>
                    <td><input type="checkbox" name="herramientas" value="si"></td>
                </tr>
                <tr>
                    <td align="right">Extintor</td>
                    <td><input type="checkbox" name="extintor" value="si"></td>

                    <td align="right">Radio o CD player</td>
                    <td><input type="checkbox" name="radio" value="si"></td>
                </tr>
                <tr>
                    <td align="right">Encendedor</td>
                    <td><input type="checkbox" name="encendedor" value="si"></td>

                    <td align="right">Tarjeta de circulación</td>
                    <td><input type="checkbox" name="t_circulacion" value="si"></td>
                </tr>
                <tr>
                    <td align="right">Alfombras</td>
                    <td><input type="checkbox" name="alfombras" id="alfombras" value="si"></td>
                    <td align="right">Retrovisor interno</td>
                    <td><input type="checkbox" name="retrovisor" value="si"></td>
                </tr>
                <tr>
                	<td align="right">Cantidad</td>
                    <td><input type="text" name="nalfombras" id="nalfombras" size="2" maxlength="2" disabled="disabled" style="height:10px"></td>
                    <td align="right">Respaldo de asiento</td>
                    <td><input type="checkbox" name="respaldo" value="si"></td>                    
                </tr>
               </tbody>
            </table></td></tr></table>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Revisión Externa del vehículo</h2>
            <table width="600px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Externo</th>
                        <th>Si/No</th>
                        <th>Externo</th>
                        <th>Si/No</th>
                    </tr>
                </thead>
            	<tbody>
                <tr>
                    <td align="right">Tapón de gas</td>
                    <td><input type="checkbox" name="tapon"></td>

                    <td align="right">Retrovisor izquierdo</td>
                    <td><input type="checkbox" name="retrovisor_izq"></td>
                </tr>
                <tr>
                    <td align="right">Retrovisor derecho</td>
                    <td><input type="checkbox" name="retrovisor_der"></td>

                    <td align="right">Logos</td>
                    <td><input type="checkbox" name="logos"></td>
                </tr>
                <tr>
                    <td align="right">Emblemas</td>
                    <td><input type="checkbox" name="emblemas"></td>

                    <td align="right">Cricos y escobillas</td>
                    <td><input type="checkbox" name="cricos_escobillas"></td>
                </tr>
                <tr>
                    <td align="right">Copas</td>
                    <td><input type="checkbox" name="copas" id="copas"></td>
                    <td align="right">Vidrios de puertas</td>
                    <td><input type="checkbox" name="vidrios" id="vidrios"></td>
                    
                    
                </tr>
                <tr>
                    <td align="right">Cantidad</td>
                    <td><input type="text" name="ncopas" id="ncopas" size="2" maxlength="2" disabled="disabled" style="height:10px"></td>
					
                    <td align="right">Cantidad</td>
                    <td><input type="text" name="nvidrios" id="nvidrios" size="2" maxlength="2" disabled="disabled" style="height:10px"></td>
                </tr>
                <tr>
                    <td align="right">Parabrisas delantero</td>
                    <td><input type="checkbox" name="parabrisas_delantero"></td>
                    <td align="right">Antena</td>
                    <td><input type="checkbox" name="antena"></td>
                </tr>
                <tr>
                	<td align="right">Parabrisas trasero</td>
                    <td><input type="checkbox" name="parabrisas trasero"></td>
                    
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
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
			var cont="<br><br><table align='center' class='table_design'>";
			/*cont=cont+"<thead><tr><td>Datos Generales del Vehículo</td></tr></thead>";*/
			cont=cont+"<tr><td>Marca: <strong>"+json[0]['marca']+"</strong></td><td>Motorista Asignado: <strong>"+json[0]['motorista'].capitalize()+"</strong></td>";
			cont=cont+'</tr><tr>'
			cont=cont+'<td>Modelo: <strong>'+json[0]['modelo']+'</strong></td> <td>Oficina Asiganada: <strong>'+json[0]['seccion']+'</strong></td>';
			cont=cont+'</tr><tr>'
			cont=cont+'<td>Clase: <strong>'+json[0]['clase']+'</strong></td><td>Kilometraje Actual: <strong>'+json[0]['kilometraje']+' km</strong></td>';
			cont=cont+'</tr><tr>'
			cont=cont+'<td>Año: <strong>'+json[0]['anio']+'</strong></td><td>ID vehículo: <strong>'+json[0]['id_vehiculo']+'</strong></td>';
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