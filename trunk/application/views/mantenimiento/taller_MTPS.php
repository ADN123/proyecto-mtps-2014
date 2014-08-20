<section>
    <h2>Reparación y Mantenimiento en Taller MTPS</h2>
</section>
<form name="form_taller" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_taller" >
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del vehículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Mantenimiento Realizado</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Inspección Realizada</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <span class="stepNumber">4<small>to</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Descripción</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Datos Generales del Vehículo</h2>
             <p>
                <label>Fecha</label>
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
            <h2 class="StepTitle">Informaci&oacute;n del mantenimiento realizado al vehículo</h2>
            <table width="500px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Mantenimiento</th>
                        <th width="250">Realizado</th>
                    </tr>
                </thead>
            	<tbody>
                <tr>
                    <td align="right">Cambio de Aceite y Filtro</td>
                    <td><input type="checkbox" name="aceite"></td>
                </tr>
                <tr>
                    <td align="right">Ajuste/Limpieza de Frenos</td>
                    <td><input type="checkbox" name="frenos"></td>
                </tr>
                <tr>
                    <td align="right">Limpieza de Bornes de Batería</td>
                    <td><input type="checkbox" name="bateria"></td>
                </tr>
                <tr>
                    <td align="right">Sistema Eléctrico y Luces</td>
                    <td><input type="checkbox" name="electricidad"></td>
                </tr>
                <tr>
                    <td align="right">Amortiguadores</td>
                    <td><input type="checkbox" name="amortiguadores"></td>
                </tr>
                <tr>
                    <td align="right">Llantas</td>
                    <td><input type="checkbox" name="llantas"></td>
                </tr>
                <tr>
                    <td align="right">Limpieza General de Motor</td>
                    <td><input type="checkbox" name="motor"></td>
                </tr>
                <tr>
                    <td align="right">Otros (Especifíque)</td>
                    <td><textarea name="otros" class="tam-4" style="resize:none"></textarea></td>
                </tr>
               </tbody>
            </table></td></tr></table>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de inspección o chequeo realizado al vehículo</h2>
             <table width="600px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Inspección/Chequeo</th>
                        <th width="250px">Realizado</th>
                    </tr>
                </thead>
            	<tbody>
                <tr>
                    <td align="right">Niveles de aceite motor, refrigerante del radiador y fluido de frenos</td>
                    <td><input type="checkbox" name="naceite"></td>
                </tr>
                <tr>
                    <td align="right">Presión/Calibración de llantas</td>
                    <td><input type="checkbox" name="presion"></td>
                </tr>
                <tr>
                    <td align="right">Niveles de agua/Refrigerante</td>
                    <td><input type="checkbox" name="agua"></td>
                </tr>
                <tr>
                    <td align="right">Revisión y calibración de llantas</td>
                    <td><input type="checkbox" name="rllantas"></td>
                </tr>				
                <tr>
                    <td align="right">Caja de velocidades</td>
                    <td><input type="checkbox" name="caja_velocidades"></td>
                </tr>
                <tr>
                    <td align="right">Revisión de clutch, mangueras</td>
                    <td><input type="checkbox" name="clutch"></td>
                </tr>
                <tr>
                    <td align="right">Refrigerante del motor, líquido de frenos y clutch, líquido de timón hidráulico, batería</td>
                    <td><input type="checkbox" name="r_motor"></td>
                </tr>
                <tr>
                    <td align="right">Limpieza exterior de vehículo (lavado)</td>
                    <td><input type="checkbox" name="lavado"></td>
            	</tr>
                <tr>
                    <td align="right">Observaciones (Especifíque)</td>
                	<td><textarea name="observaciones" class="tam-4" style="resize:none"></textarea></td>
                </tr>
              </tbody>
            </table>
          </td>
         </tr>
        </table>
        </div>
    </div>
</form>

<script>
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