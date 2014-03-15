<section>
    <h2>Nueva solicitud para Misi&oacute;n Oficial</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}
</style>
<form name="form_mision" method="post">
    <p>
        <label>Fecha:</label>
        <?php echo date('d/m/Y'); ?>
    </p>
	<p>
        <label for="nombre" id="lnombre">Solicitante:</label>
        <select name="nombre" id="nombre" tabindex="1" placeholder="[Seleccione...]" class="select" style="width:400px">
        <?php
			 foreach($empleados as $val) {
				 echo '<option value="'.$val['NR'].'">'.$val['nombre'].'</option>';
			 }
		?>
        </select>
    </p>  
    <p>
        <label for="fecha_mision" id="lfecha_mision">Fecha Misi&oacute;n</label>
        <input type="text" class="fec_hoy" tabindex="2" id="fecha_mision" name="fecha_mision"/>
    </p>
    <p>
        <label for="hora_salida" id="lhora_salida">Hora de salida </label>
        <input type="text" tabindex="3" class="hora" id="hora_salida" name="hora_salida"/>
   	</p>
    <p>
        <label for="hora_regreso" id="lhora_regreso">Hora de regreso </label>
        <input type="text" tabindex="3" class="hora" id="hora_regreso" name="hora_regreso"/>
    </p>
	<p>
        <label for="seccion" id="lseccion">Secci&oacute;n</label>
        <select name="seccion" id="seccion" tabindex="3" placeholder="[Seleccione...]" class="select" style="width:650px">
        <?php
			 foreach($secciones as $val) {
				 echo '<option value="'.$val['id_seccion'].'">'.$val['nombre_seccion'].'</option>';
			 }
		?>
        </select>
    </p> 
	<p>
        <label for="acompanantes" id="lacompanantes">Acompa&ntilde;antes</label>
        <select name="acompanantes" id="acompanantes" class="multi" multiple="multiple" tabindex="3" placeholder="[Seleccione...]" style="width:400px;">
        <?php
			 foreach($acompanantes as $val) {
				 echo '<option value="'.$val['NR'].'">'.$val['nombre'].'</option>';
			 }
		?>
        </select>
    </p> 
     <p>
        <label for="municipio" id="lmunicipio">Municipio</label>
        <select name="municipio" id="municipio" class="select" tabindex="3" placeholder="[Seleccione...]" style="width:400px;">
        <?php
			 foreach($municipios as $val) {
				 echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
			 }
		?>
        </select>
    </p> 
    <p>
     <label for="lugar_destino" id="llugar_destino">Lugar de destino </label>
     <input type="text" tabindex="3" class="tam-4" id="lugar_destino" name="lugar_destino"/>
    </p>

     <p>
     <label for="mision_encomendada" id="lmision_encomendada">Mision encomendada </label>
     <input type="text" tabindex="3" class="tam-3" id="mision_encomendada" name="mision_encomendada"/>
    </p>
    <p>
        <button type="submit" class="button tam-1 boton_validador" tabindex="8" id="guardar" name="guardar"><img src="<?=base_url()?>img/guardar.png" width="12" height="12"> Guardar</button>
    </p>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fecha_mision").validacion({
			valFecha: true
		});
		$("#nombre").validacion({
			men: "Debe seleccionar un item"
		});
		$("#seccion").validacion({
			men: "Debe seleccionar un item"
		});
		$("#guardar").click(function(){
			if($("#formu").data("ok"))
				alert("Se va");			
		});
	});
</script>
