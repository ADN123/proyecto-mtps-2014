<?php
extract($articulo);
?>
<section>
    <h2>Cargar Artículo</h2>
</section>
<form name="form_presupuesto" method="post" action="<?php echo base_url()."index.php/vehiculo/surtir_articulo"; ?>" enctype="multipart/form-data" accept-charset="utf-8">
<input type="hidden" name="id_articulo" value="<?php echo $id_articulo ?>" >
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del Artículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Adquisición del Artículo</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">
        	<h2 class="StepTitle">Ingreso de la informaci&oacute;n del artículo a bodega</h2>
            <p>
            	<label>Nombre: </label>
                <input type="text" name="nombre" <?php echo "value='".$nombre."'"; ?> readonly size="20">
            </p>
            <p>
            	<label>Cantidad Disponible: </label>
                <input type="text" name="cantidad2" <?php echo "value='".$cantidad."' readonly "; ?> size="10">
            </p>
            <p>
            	<label class="label_textarea">Descripción: </label>
                <textarea name="descripcion" style="resize:none; width:200px" readonly><?php echo $descripcion; ?></textarea>
            </p>
        </div>
       <div id="step-2">
        	<h2 class="StepTitle">Información de adquisición del artículo a bodega</h2>
            <p>
            	<label>Cantidad de Artículos Adquiridos: </label>
                <input type="text" name="cantidad" size="10"> <strong><?php echo $unidad_medida; ?></strong>
                <input type="hidden" name="unidad_medida" value="<?php echo $unidad_medida; ?>" />
            </p>
            <p>
            	<label>Adquisición de el(los) Artículo(s): </label>
                <select style="width:150px" class="select" name="adquisicion" id="adquisicion" placeholder="Seleccione...">
                	<option value="comprado">Comprado(s)</option>
                    <option value="donado">Donado(s)</option>
                </select>
                <div id="compra"></div>
            </p>
        </div>
	</div>
</form>
<script>
$(document).ready(function()
{
	$('#wizard').smartWizard();
	
	$('#adquisicion').change(
		function()
		{
			if(document.getElementById('adquisicion').value=='comprado')
			{
				cont='<p><label>Precio artículos($):&nbsp;</label><input type="text" name="gasto" size="10"></p>';
				$("#compra").html(cont); 
			}
			else
			{
				cont="";
				$("#compra").html(cont);
			} 
		}
	);
	$('#cantidad').validacion({
		req:true,
		num: true
	});
	$('#adquisicion').validacion({
		req: true
	})
	$('#gasto').validacion({
		req:true,
		num: true
	});
});
</script>