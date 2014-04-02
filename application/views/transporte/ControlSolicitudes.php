<section>
    <h2>Control de Solicitudes</h2>
</section>

<?php  //print_r($datos); ?>
<table  class="grid">
<thead>
  <tr>
    <th>Fecha y Hora</th>
    <th>Seccion</th>
    <th>Nombre</th>
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
    <td><a title="Ver solicitud" title="Asignar Vehículo" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">

</div>
<script language="javascript" >

function dialogo(id){

	$('#ventana').load('datos_de_solicitudes/'+id);
				
	return false;
}	
	function Enviar(v){
		document.getElementById('resp').value=v;
	}
	
	$("#observacion").validacion({
			req: false,
			lonMin: 10
		});
</script>