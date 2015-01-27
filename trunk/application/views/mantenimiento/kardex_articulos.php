<section>
    <h2>Kardex de Artículos</h2>
</section>
<p>
	<label style="width:100px">Artículo: </label>
    <select class="select" style="width:350px" name="id_articulo">
    	<option value="*" selected>[Todos]</option>
		<?php
			foreach($articulos as $art)
			{
				echo "<option value='".$art['id_articulo']."'>".$art['nombre']."</option>";
			}
        ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Vehículo: </label>
    <select class="select" style="width:100px" name="id_vehiculo">
    	<option value="*" selected='selected'>[Todos]</option>
    	<?php
			foreach($vehiculos as $v)
			{
				echo "<option value='".$v->id."'>".$v->placa."</option>";
			}
        ?>
    </select>
</p>
<p>
    <label style="width:100px">Fecha Inicial: </label>
    <input type="text" name="fecha_inicial" id="fecha_inicial" <?php if($bandera=='true') echo "value='".$fecha_inicial."'"; ?>>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <label>Fecha Final: </label>
    <input type="text" name="fecha_final" id="fecha_final" <?php if($bandera=='true') echo "value='".$fecha_final."'"; ?>>
</p>

<script language="javascript">
$(document).ready(function()
{
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
});
</script>