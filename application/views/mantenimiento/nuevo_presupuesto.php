<?php
if($bandera=='true')
{
	extract($presupuesto);
	$action=base_url()."index.php/vehiculo/modificar_presupuesto";
}
else $action=base_url()."index.php/vehiculo/guardar_presupuesto";
?>
<section>
    <h2><?php if($bandera=='true')echo "Modificar Presupuesto"; else {?>Nuevo Presupuesto <?php } ?></h2>
</section>
<form name="form_presupuesto" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
<?php if($bandera=='true') echo '<input type="hidden" name="id_presupuesto" value="'.$id_presupuesto.'" >'; ?>
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del Presupuesto</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">
        	<h2 class="StepTitle">Ingreso de la informaci&oacute;n del presupuesto</h2>
            <p>
            	<label>Presupuesto($): </label>
                <input type="text" name="presupuesto" <?php if($bandera=='true') echo "value='".$presupuesto."'"; ?> size="10" id="presupuesto">
            </p>
            <p>
            	<label>Desde: </label>
                <input type="text" name="fecha_inicial" id="fecha_inicial" <?php if($bandera=='true') echo "value='".$fecha_inicial."'"; ?>>
            </p>
            <p>
            	<label>Hasta: </label>
                <input type="text" name="fecha_final" id="fecha_final" <?php if($bandera=='true') echo "value='".$fecha_final."'"; ?>>
            </p>
        </div>
	</div>
</form>
<script>
$(document).ready(function()
{
	$('#wizard').smartWizard();
	
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

$('#presupuesto').validacion({
num: true,
req: true
});
</script>