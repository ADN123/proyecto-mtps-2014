<?php echo form_open('index.php/Seguridad/registrar_usuario', array('id' => 'agregaform', 'onsubmit' => 'return checkform();'));?>
<fieldset class="formulalios">
<legend class="tituloForm" align="center">Registrar Usuario</legend>
<img   align="left"src="<? echo base_url();?>/imagenes/addExpediente.png"  width="64px" height="64px"/>
<table cellpadding="5" cellspacing="0" align="center">
<tr>
   <td class="texte" align="right">Login:</td>
   <td class="compont"><input type="text" name="loginC" id="loginC" size="24" maxlength="16"  /></td>
        <script type="text/javascript">
			var login = new LiveValidation('loginC');
			login.add(Validate.Presence);
			login.add( Validate.Length, { minimum: 6} );
       </script>
    </tr>
 <tr>
  <td class="texte" align="right">Nombre:</td>
  <td class="compont"><input type="text" name="nombreC" id="nombreC" size="30" /></td>
  		<script type="text/javascript">
			var nombre = new LiveValidation('nombreC');
			nombre.add(Validate.Presence);
			nombre.add( Validate.Length, { minimum: 3} );
       </script>
</tr>
<tr>
  <td class="texte" align="right">Apellido:</td>
  <td class="compont"><input type="text" name="apellidoC" id="apellidoC" size="30" /></td>
  		<script type="text/javascript">
			var apellido = new LiveValidation('apellidoC');
			apellido.add(Validate.Presence);
			apellido.add( Validate.Length, { minimum: 3} );
       </script>
</tr>
<tr>
  <td class="texte" align="right">Contrase&ntilde;a:</td>
  <td class="compont"><input type="password" name="claveC" id="claveC" size="24" maxlength="16" /></td>
  		<script type="text/javascript">
			var clave = new LiveValidation('claveC');
			clave.add(Validate.Presence);
			clave.add( Validate.Length, { minimum: 6} );
       </script>
</tr>
<tr>
  <td class="texte" align="right">Confirmar Contrase&ntilde;a:</td>
  <td class="compont"><input type="password" name="clave2C" id="clave2C" size="24" maxlength="16" /></td>
  		<script type="text/javascript">
			var clave2 = new LiveValidation('clave2C');
			clave2.add(Validate.Presence);
			clave2.add( Validate.Confirmation, {match: 'claveC'});
       </script>
</tr>
<tr>
  <td class="texte" align="right">Nivel:</td>
  <td class="compont">
  <select name="nivelN" id="nivelN">
  	<option value="0">Seleccione...</option>
    <option value="1">Doctor/a</option>
    <option value="2">Secretario/a</option>
  </select>
  </td>
  		<script type="text/javascript">
			var nivel = new LiveValidation('nivelN');
			nivel.add(Validate.Presence);
			nivel.add( Validate.Inclusion, { within: [ '1' , '2'] } );
        </script>
</tr>
<tr>
  <td class="texte" align="right">Contrase&ntilde;a (Usuario logeado):</td>
  <td class="compont"><input type="password" name="clave3C" id="clave3C" size="24" maxlength="16" /></td>
  		<script type="text/javascript">
			var clave3 = new LiveValidation('clave3C');
			clave3.add(Validate.Presence);
			clave3.add( Validate.Length, { minimum: 6} );
       </script>
</tr>
</table>
 <br />
<button name="boton" id="boton" type="submit"><img src="/siscliden/imagenes/guardar.png" width="20" height="20" align="top"> Guardar </button>
   <button name="cancelar" id="cancelar" type="reset" ><img src="/siscliden/imagenes/cancelar.png" width="20" height="20" align="top"> Cancelar </button>