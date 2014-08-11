
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Asignaciones de Vehiculos a Secciones</h2>
</section>

<table  class="grid" >
<thead>
  <tr>
    <th>Placa</th>
    <th>Marca </th>
    <th>Fuente de Fondo </th>
    <th>Seccion de consumo</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
foreach ($datos as $fila) {

?>
<tr>
    <td><?php echo $fila['placa']?></td>    
    <td><?php echo $fila['marca']?></td>
    <td><?php echo $fila['fuente_fondo']?></td>    
    <td><?php echo ucwords($fila['seccion_vale'])?></td>
    <td><a title="Modificar" rel="leanModal" href="#ventana" onclick="Modificar(<?php echo $fila['id_vehiculo']?>,<?php echo $fila['id_fuente_fondo']?>)"><img  src="<?php echo base_url()?>img/editar.png"/></a>        
	</td>
  </tr>


<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Asignacione de Seccion de Consumo a Vehiculos</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function Modificar(id_vehiculo,id_fuente_fondo)
	{  
		$('#contenido-ventana').load(base_url()+'index.php/vales/dialogo_asignacion_vehiculo/'+id_vehiculo+'/'+ id_fuente_fondo);
		return false;
	}	
    

</script>