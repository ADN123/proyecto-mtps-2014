<?php
if($bandera=='true')
{
	extract($articulo);
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
            <?php if($bandera!=NULL && $bandera!='true'){ ?>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Adquisición del Artículo</small>
                    </span>
                </a>
            </li>
            <?php } ?>
        </ul>
        <div id="step-1">
        	<h2 class="StepTitle">Ingreso de la informaci&oacute;n del artículo a bodega</h2>
            <p>
            	<label>Nombre: </label>
                <input type="text" id="nombre" name="nombre" <?php if($bandera=='true') echo "value='".$nombre."'"; ?> size="48">
            </p>
            <p>
            	<label>Unidad de Medida: </label>
                <select name="id_unidad_medida" id="id_unidad_medida" class="select" style="width:150px" multiple="multiple" placeholder="Seleccione...">
               	<?php
				foreach($unidades as $um)
				{
                ?>
                	<option value="<?php echo $um['id_unidad_medida'] ?>"  <?php if($bandera=='true') if($um['id_unidad_medida']==$id_unidad_medida) echo "selected='selected'"; ?> ><?php echo $um['unidad_medida']; ?></option>
                <?php
				}
				?>
                </select>
            </p>
            <p>
            	<label>Cantidad: </label>
                <input type="text" id="cantidad" name="cantidad" <?php if($bandera=='true') echo "value='".$cantidad."' disabled='disabled'"; ?> size="10">
            </p>
            <p>
            	<label class="label_textarea">Descripción: </label>
                <textarea name="descripcion" id="descripcion" style="resize:none; width:200px"><?php if($bandera=='true') echo $descripcion; ?></textarea>
            </p>
        </div>
        <?php if($bandera!=NULL && $bandera!='true'){ ?>
        <div id="step-2">
        	<h2 class="StepTitle">Información de adquisición del artículo a bodega</h2>
            <p>
            	<label>Adquisición de el(los) Artículo(s): </label>
                <select style="width:150px" class="select" name="adquisicion" id="adquisicion" placeholder="Seleccione...">
                	<option value="comprado">Comprado(s)</option>
                    <option value="donado">Donado(s)</option>
                </select>
                <div id="compra"></div>
            </p>
        </div>
         <?php } ?>
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
				cont='<p><label>Precio artículos($):&nbsp;</label><input type="text" id="gasto" name="gasto" size="10"></p>';
				$("#compra").html(cont); 
				$('#gasto').validacion({
					req:true,
					num: true
				});
			}
			else
			{
				cont="";
				$("#compra").html(cont);
				$('#gasto').validacion({
					req:false,
					num: true
				});
			}
		}
	);
	
	$('#nombre').validacion({
		req:true,
		lonMin: 3
	});
	$('#id_unidad_medida').validacion({
		req: true
	})
	$('#cantidad').validacion({
		req:true,
		num: true
	});
	$('#descripcion').validacion({
		req:false,
		lonMin: 10
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