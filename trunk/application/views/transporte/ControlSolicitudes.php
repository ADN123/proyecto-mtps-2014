<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Control de Solicitudes</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>Fecha y Hora de Misi&oacute;n</th>
    <th>Sección del Solicitante</th>
    <th>Persona Solicitante</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php    
	$array = json_decode(json_encode($datos), true);
        for($i=0;$i<$n;$i++) {
			if($i==0)
			{
	?>
		<tr>
			<td><?php echo $array[$i]['fecha']?>&nbsp;&nbsp;<?php echo $array[$i]['salida']?></td>
			<td><?php echo ucwords($array[$i]['seccion'])?></td>
			<td><?php echo ucwords($array[$i]['nombre'])?></td>
			<td><a rel="leanModal" title="Ver solicitud" href="#ventana" onclick="dialogo(<?php echo $array[$i]['id']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a></td>
		</tr>
	<?php
			}
			else if($array[$i]['id']!=$array[($i-1)]['id'])
			{
	?>
		<tr>
			<td><?php echo $array[$i]['fecha']?>&nbsp;&nbsp;<?php echo $array[$i]['salida']?></td>
			<td><?php echo ucwords($array[$i]['seccion'])?></td>
			<td><?php echo ucwords($array[$i]['nombre'])?></td>
			<td><a rel="leanModal" title="Ver solicitud" href="#ventana" onclick="dialogo(<?php echo $array[$i]['id']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a></td>
		</tr>
	<?php
			}
	} ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Aprobacion de solicitud de Misión Oficial</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function dialogo(id)
	{
		$('#contenido-ventana').load(base_url()+'index.php/transporte/datos_de_solicitudes/'+id);
		return false;
	}	
	
	function Enviar(v)
	{
		document.getElementById('resp').value=v;
	}
</script>