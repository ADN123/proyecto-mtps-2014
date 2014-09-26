<section>
    <h2>Generar Informes de Solicitudes de Transporte</h2>
</section>

<form name="form_informes" id="form_informes" method="post" action="<?php echo base_url()?>index.php/transporte/informes_solicitudes_pdf">
<table align="center" width="1080px">
    <tr>
    	<td width="350px">
            <p>
                <label style="width:120px">Solicitante: </label>
                <select class="select" name="id_empleado" style="width:280px">
                <option value="0">[Todo]</option>
                <?php
                foreach($empleado as $emp)
				{
					echo "<option value='".$emp['NR']."'>".ucwords($emp['nombre'])."</option>";
				}
				?>
                </select>
            </p>
            <p>
                <label style="width:120px">Usuario Autorizador: </label>
                <select class="select" name="id_usuario" style="width:280px">
                <option value="0">[Todo]</option>
                <?php
                foreach($usuario as $user)
				{
					echo "<option value='".$user->id_usuario."'>".ucwords($user->usuario)."</option>";
				}
				?>
                </select>
            </p>
            <p>
                <label style="width:120px">Oficina o Sección: </label>
                <select class="select" name="id_seccion" style="width:350px">
                <option value="-1">[Todo]</option>
                <option value="0">Oficina Central (San Salvador)</option>
				<?php
                foreach($seccion as $sec)
				{
					echo "<option value='".$sec->id_seccion."'>".ucwords($sec->seccion)."</option>";
				}
				?>
                </select>
            </p>
            <p>
            	<label style="width:120px">Estado de Solicitud: </label>
                <select class="select" name="estado_solicitud" style="width:230px">
                <option value="-1">[Todo]</option>
                <option value="0">Denegada</option>
                <option value="1">Creada</option>
                <option value="2">Aprobada</option>
                <option value="3">Asignada con vehículo/motorista</option>
                <option value="4">En Misión</option>
                <option value="5">Finalizada</option>
                </select>
            </p>
            <p>
            	<label style="width:120px">Motorista: </label>
                <select class="select" name="motorista" style="width:280px">
                <option value="0">[Todo]</option>
                <option value="-1">[Sin Motorista]</option>
                <?php
                 foreach($empleado as $emp) //////////////todos porque en misión cualquiera puede ser motorista
				{
					echo "<option value='".$emp['NR']."'>".ucwords($emp['nombre'])."</option>";
				}
				
				/*foreach($motorista as $mot) /////////////solo motoristas
				{
					echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
				}*/
				?>
                </select>
            </p>
            <p>
            	<label style="width:120px">Placa de Vehículo: </label>
                <select class="select" name="id_vehiculo" style="width:120px">
                <option value="0">[Todo]</option>
                <?php
                 foreach($vehiculo as $v)
				{
					echo "<option value='".$v->id."'>".$v->placa."</option>";
				}
				?>
                </select>
            </p>
        </td>
        <td width="285px">
        	<p>
                <label style="width:85px">Fecha Inicial: </label>
                <input type="text" name="fecha_inicial" id="fecha_inicial">
            </p>
            <p>
            	<label style="width:85px">Fecha Final: </label>
                <input type="text" name="fecha_final" id="fecha_final">
            </p>
        	<p>
            	<label style="width:85px">Hora Inicial: </label>
                <input type="text" name="hora_inicial" id="hora_inicial">
            </p>
            <p>
            	<label style="width:85px">Hora Final: </label>
                <input type="text" name="hora_final" id="hora_final">
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p align="center">
                <button type="button" id="filtrar" class="button tam-1" >Filtrar</button>                    
                <button id="imp" class="button tam-1" >Imprimir</button>
            </p>
        </td>
    </tr>
</table>
</form>
<br>
<table cellspacing='0' align='center' class='table_design' id="datos" >
</table>

<script language="javascript">

$('#filtrar').click(function(){             
	var form = $('#form_informes').serializeArray();
	//console.log(form); 
	reporte(form);
});

function reporte(form)
{  
	$.ajax({
		async:  true, 
		url:    base_url()+"index.php/transporte/informes_json",
		dataType:"json",
		type: "POST",
		data: formu,
		success: function(data)
		{
			console.log(data);
			tabla(data) 
		},
		error:function(data)
		{
			//alertify.alert('Error al cargar datos');
			console.log(data);
		}
	});          
}

setTimeout ("reporte();", 2000);

function tabla (json)
{
	$('#datos').html("");
	var fila;
	for (i=0;i<json.length;i++)
	{
		fila= "<tr>" +
		"<td align='center'>" + json[i].row_number + "</td>" +
		"<td align='center'>" + json[i].seccion + "</td>" +
		"<td align='center'>" + json[i].asignado + "</td>" +
		"<td align='center'>" + json[i].consumido + "</td>" +
		"<td align='center'>$" + n.toFixed(2) + "</td>" +
		"</tr>";    
		$('#datos').append(fila)    
	}  
}

$(document).ready(function(){
	
	function startChange()
	{
		var startDate = start.value(),
		endDate = end.value();
	
		if (startDate) 
		{
			//startDate = new Date(2014,07,01);
			startDate.setDate(startDate.getDate());
			end.min(startDate);
		}
		else if (endDate)
		{
			start.max(new Date(endDate));
		}
		else
		{
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	
	function endChange()
	{
		var endDate = end.value(),
		startDate = start.value();
	
		if (endDate)
		{
			endDate = new Date(endDate);
			endDate.setDate(endDate.getDate());
			start.max(endDate);
		}
		else if (startDate)
		{
			end.min(new Date(startDate));
		}
		else
		{
			endDate = new Date();
			start.max(endDate);
			end.min(endDate);
		}
	}
	
	var start = $("#fecha_inicial").kendoDatePicker({
		change: startChange,
		format: "dd-MM-yyyy" 
	}).data("kendoDatePicker");

	var end = $("#fecha_final").kendoDatePicker({
		change: endChange,
		format: "dd-MM-yyyy" 
	}).data("kendoDatePicker");

	start.max(end.value());
	end.min(start.value());
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	var tiempo = new Date();
	newfec=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours(), tiempo.getMinutes());
	
	function startChange2() {
		var startTime = start2.value();
		
		var hor_rea = new Date(startTime);
		
		startTime = start2.value();
		if (startTime!="" &&  this.options.interval) {
			startTime = new Date(startTime);
			startTime.setMinutes(startTime.getMinutes() + this.options.interval);
			end2.min(startTime);
			end2.value(startTime);
		}
	}
	var start2 = $("#hora_inicial").kendoTimePicker({
		change: startChange2
	}).data("kendoTimePicker");
	var end2 = $("#hora_final").kendoTimePicker().data("kendoTimePicker");
	//start2.min(newfec);
	start2.max("5:30 PM");
	end2.min("5:30 AM");
	end2.max("6:00 PM");
	
});
</script>