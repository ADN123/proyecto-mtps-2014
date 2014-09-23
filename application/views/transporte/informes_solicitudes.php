<form name="form_informes" method="post" action="<?php echo base_url()?>index.php/transporte/filtrar">
<table align="center" width="1080px">
	<tr>
    	<td colspan="2"><h2>Generar Informes de Solicitudes de Transporte</h2></td>
    </tr>
    <tr>
    	<td>
            <p>
                <label>Empleado: </label>
                <select class="select" name="id_empleado" style="width:350px">
                <option value="0">*</option>
                <?php
                foreach($empleado as $emp)
				{
					echo "<option value='".$emp['NR']."'>".ucwords($emp['nombre'])."</option>";
				}
				?>
                </select>
            </p>
            <p>
                <label>Sección o Departamento: </label>
                <select class="select" name="id_seccion" style="width:350px">
                <option value="-1">*</option>
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
                <label>Fecha Misión (incial): </label>
                <input type="text" name="fecha_inicial" id="fecha_inicial">
            </p>
            <p>
            	<label>Fecha Misión (final): </label>
                <input type="text" name="fecha_final" id="fecha_final">
            </p>
        </td>
        <td>
        	<p>
            	<label>Hora Salida: </label>
                <input type="text" name="hora_inicial" id="hora_inicial">
            </p>
            <p>
            	<label>Hora Entrada: </label>
                <input type="text" name="hora_final" id="hora_final">
            </p>
            <p>
            	<label>Estado Solicitud: </label>
                <select class="select" name="estado_solicitud" style="width:250px">
                <option value="0">Denegada</option>
                <option value="1">Creada</option>
                <option value="2">Aprobada</option>
                <option value="3">Asignada con vehículo/motorista</option>
                <option value="4">En Misión</option>
                <option value="5">Finalizada</option>
                </select>
            </p>
            <p>
            	<label>Motorista: </label>
                <select class="select" name="motorista" style="width:350px">
                <option value="0">*</option>
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
        </td>
    </tr>
</table>
</form>
<script language="javascript">
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
	
	function startChange2() {
		var startTime = start.value();
		
		var hor_rea = new Date(startTime);
		fec_min=new Date(tiempo.getFullYear(), tiempo.getMonth(), tiempo.getDate(), tiempo.getHours()+24, tiempo.getMinutes());
		var fec = fec_soli.value();
		fec = new Date(fec);
		fec_rea=new Date(fec.getFullYear(), fec.getMonth(), fec.getDate(), hor_rea.getHours(), hor_rea.getMinutes());
		
		if(newfec>=fec_rea) {
				start.min(newfec);
		}
		else {
			start.min("5:00 AM");
		}
		startTime = start2.value();
		if (startTime!="" &&  this.options.interval) {
			startTime = new Date(startTime);
			startTime.setMinutes(startTime.getMinutes() + this.options.interval);
			end2.min(startTime);
			end2.value(startTime);
		}
	}
	var start2 = $("hora_inicial").kendoTimePicker({
		change: startChange2
	}).data("kendoTimePicker");
	
	var end2 = $("hora_final").kendoTimePicker().data("kendoTimePicker");
	start2.min(newfec);
	start2.max("5:30 PM");
	end2.min("5:30 AM");
	end2.max("6:00 PM");
});
</script>