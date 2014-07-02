<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Entrega de Vales de Combustible</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>ID Requisicion</th>
    <th>Fecha Solicitada</th>
    <th>Sección Solicitante</th>
    <th>Cantidad </th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($datos as $fila) {
?>
  <tr>
    <td><?php echo $fila['id_requisicion']?></td>
    <td><?php echo $fila['fecha']?></td>
    <td><?php echo ucwords($fila['seccion'])?></td>
    <td><?php echo $fila['cantidad']?></td>
    <td><a title="Ver solicitud" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila['id_requisicion']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Entrega de Vales de Combustible</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function dialogo(id)
	{  
		$('#contenido-ventana').load(base_url()+'index.php/vales/dialogo_entrega/'+id);
		return false;
	}	
	
	function Enviar(v)
	{
		document.getElementById('resp').value=v;
        if(v==0){
           $("#asignar").destruirValidacion();            
        }
	}
</script>