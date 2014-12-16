<?php
if($bandera=='true')
{
	extract($presupuesto);
	$action=base_url()."index.php/vehiculo/modificar_articulo";
}
else $action=base_url()."index.php/vehiculo/guardar_articulo";
?>
<section>
    <h2><?php if($bandera=='true')echo "Modificar Artículo"; else {?>Nuevo Artículo <?php } ?></h2>
</section>
<form name="form_presupuesto" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" accept-charset="utf-8">
<?php if($bandera=='true') echo '<input type="hidden" name="id_articulo" value="'.$id_articulo.'" >'; ?>
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
                <input type="text" name="nombre" <?php if($bandera=='true') echo "value='".$nombre."'"; ?> size="10">
            </p>
            <p>
            	<label>Cantidad: </label>
                <input type="text" name="cantidad" <?php if($bandera=='true') echo "value='".$cantidad."'"; ?> size="10">
            </p>
            <p>
            	<label class="label_textarea">Descripción: </label>
                <textarea name="descripcion"><?php if($bandera=='true') echo $descripcion; ?></textarea>
            </p>
        </div>
        <div id="step-2">
        	<h2 class="StepTitle">Información de adquisición del artículo a bodega</h2>
            <p>
            	<label>Adquisición de el(los) Artículo(s): </label>
                <select class="select" name="adquisicion" placeholder="Seleccione..." onchange="compra(this.value)">
                	<option value="comprado">Comprado(s)</option>
                    <option value="donado">Donado(s)</option>
                </select>
            </p>
            <p>
            	<label>Cantidad: </label>
                <input type="text" name="nombre" <?php if($bandera=='true') echo "value='".$nombre."'"; ?> size="10">
            </p>
            <div id="compra">
               
            </div>
            <p>
            	<label class="label_textarea">Descripción: </label>
                <textarea name="descripcion"><?php if($bandera=='true') echo $descripcion; ?></textarea>
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
			if($("#adquisicion").val('comprado'))
			{
				cont='<p><label>Precio artículos: </label><input type="text" name="cantidad" <?php if($bandera=='true') echo "value='".$cantidad."'"; ?> size="10"></p>';
				$("#compra").html(cont); 
			}
			else
			{  
				cont='';
				$("#compra").html(cont);
			} 
		}
	);
});
</script>