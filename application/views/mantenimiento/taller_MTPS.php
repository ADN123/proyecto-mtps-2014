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
            <p>
                <label>Cambio de Aceite y Filtro</label><input type="checkbox" name="aceite">

                <label>Ajuste/Limpieza de Frenos</label><input type="checkbox" name="frenos">
                
                <label>Limpieza de Bornes de Batería</label><input type="checkbox" name="bateria">
			</p>
            <p>
                <label>Sistema Eléctrico y Luces</label><input type="checkbox" name="electricidad">
			
                <label>Amortiguadores</label><input type="checkbox" name="amortiguadores">
			</p>
            <p>
                <label>Llantas</label><input type="checkbox" name="llantas">

                <label>Limpieza General de Motor</label><input type="checkbox" name="motor">
            </p>
            <p>
            	<label class="label_textarea">Otros (Especifíque)</label>
                <textarea class="tam-4" name="otros"></textarea>
            </p>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de inspección o chequeo realizado al vehículo</h2>
            <p>
                <label>Niveles de aceite motor, refrigerante del radiador y fluido de frenos</label><input type="checkbox" name="naceite">

                <label>Presión/Calibración de llantas</label><input type="checkbox" name="presion">

                <label>Niveles de agua/Refrigerante</label><input type="checkbox" name="agua">

                <label>Revisión y calibración de llantas</label><input type="checkbox" name="rllantas">

                
			</p>
            <p>
            	<label>Caja de velocidades</label><input type="checkbox" name="caja_velocidades">
                <label>Revisión de clutch, mangueras</label><input type="checkbox" name="clutch">

                <label>Refrigerante del motor, líquido de frenos y clutch, líquido de timón hidráulico, batería</label><input type="checkbox" name="r_motor">

                <label>Limpieza exterior de vehículo (lavado)</label><input type="checkbox" name="lavado">
            </p>
            <p>
            	<label class="label_textarea">Observaciones (Especifíque)</label>
                <textarea name="observaciones" class="tam-4"></textarea>
            </p>
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
	var  dur = "<?php echo base_url()?>index.php/vehiculo/vehiculo_info/"+id;
	console.log(dur);
	$.ajax({
		async:	true, 
		url:	dur,
		dataType:"json",
		success: function(data) {
			console.log(data);
			json = data;
			var cont="<table align='center'><tr>";
			cont=cont+"<td><p><label>Modelo: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>"+json[0]['modelo']+"</strong></p></td><td width='600px'><p><label>Motorista asignado: </label>&nbsp;&nbsp;<strong>"+json[0].nombre.capitalize()+"</strong></p></td>";
			cont=cont+'</tr><tr>'
			cont=cont+'<td><p><label>Marca: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'+json[0]['marca']+'</strong></p></td> <td><p><label>Oficina en donde está asignado: </label>&nbsp;<strong>'+json[0]['seccion']+'</strong></p></td>';
			cont=cont+'</tr><tr>'
			cont=cont+'<td><p><label>Clase: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'+json[0]['clase']+'</strong></p></td><td><p><label>Kilometraje Actual: </label>&nbsp;<strong>'+json[0]['kilometraje']+' km</strong></p></td>';
			cont=cont+'</tr><tr>'
			cont=cont+'<td><p><label>Año: </label>&nbsp;&nbsp;&nbsp;<strong>'+json[0]['anio']+'</strong></p></td><td><p><label>Placa: </label>&nbsp;<strong>'+json[0]['placa']+'</strong></p></td>';
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