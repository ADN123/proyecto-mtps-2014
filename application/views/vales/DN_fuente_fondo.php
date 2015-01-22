<?php
	

		$dir="guardar_fuente_fondo";
		$label="Guardar";
?>
<style>
	.k-multiselect {
		display: inline-block;
	}
</style>
<form name="formu" id="formu" style="max-width: 600px;" method="post" action="<?php echo base_url(); ?>index.php/vales/<?php echo $dir;?>" >
  	<input type="hidden" id="id" name="id" value="<?=$id?>"/>

<br><br><br>
	<fieldset>      
        <legend align='left'>Información de la fuente de fondo</legend>
        <p>
            <label for="nombre" id="lnombre_completo">Nombre </label>
             <input type="text" tabindex="1" id="nombre" name="nombre" value="<?=$nombre?>" class="tam-2"/>

        </p>
           <p>
            <label for="descripcion" id="ldescripcion" class="label_textarea">Descripción </label>
             <textarea type="text" tabindex="2" id="descripcion" name="descripcion" class="tam-4" ><?php echo $descripcion; ?></textarea>

        </p>                
	</fieldset>
    
    <p style='text-align: center;'>
        <button type="submit" id="aprobar" class="button tam-1 boton_validador" name="aprobar"><?=$label?></button>
    </p>
</form>
<script>
			$("#nombre").validacion({
				lonMin: 2,
				lonMax: 40

			});
			$("#descripcion").validacion({
				lonMin: 6,
				req:false
			});
</script>