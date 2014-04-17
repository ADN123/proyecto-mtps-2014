<section>
    <h2>Control de Solicitudes</h2>
</section>

<?php  //print_r($datos); ?>
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


	foreach ($datos as $fila)
	{
										
?>
  <tr>
    <td><?php echo $fila->fecha?></td>
    <td><?php echo $fila->seccion?></td>
    <td><?php echo ucwords($fila->nombre)?></td>
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
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

function dialogo(id){

	$('#contenido-ventana').load('datos_de_solicitudes/'+id);
				
	return false;
}	
	function Enviar(v){
		document.getElementById('resp').value=v;
	}
</script>