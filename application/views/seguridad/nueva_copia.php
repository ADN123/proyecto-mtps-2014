<?php echo form_open('index.php/Seguridad/crear_nueva_copia', array('id' => 'agregaform', 'onsubmit' => 'return checkform();'));?>
<fieldset class="formulalios">
<legend class="tituloForm" align="center">Nueva Copia de Seguridad</legend>
<img   align="left"src="<? echo base_url();?>/imagenes/addExpediente.png"  width="64px" height="64px"/>
<table cellpadding="5" cellspacing="0" align="center">
<tr>
   <td class="texte" align="right">Nombre:</td>
   <td class="compont"><input type="text" name="nombreC" id="nombreC" size="24" maxlength="16"  /></td>
        <script type="text/javascript">
			var login = new LiveValidation('nombreC');
			login.add(Validate.Presence);
			login.add (Validate.Format, {pattern: /^([a-z]+[a-z|0-9]([\_]?))*$/i});
       </script>
    </tr>
</table>
 <br />
<button name="boton" id="boton" type="submit"><img src="/siscliden/imagenes/guardar.png" width="20" height="20" align="top"> Guardar </button>
   <button name="cancelar" id="cancelar" type="reset" ><img src="/siscliden/imagenes/cancelar.png" width="20" height="20" align="top"> Cancelar </button>