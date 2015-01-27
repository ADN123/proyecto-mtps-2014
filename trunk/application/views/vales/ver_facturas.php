

<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2 >Facturas</h2>
</section>
<table  class="grid">
<thead>
  <tr>
    <th>ID consumo</th>
    <th>Fecha </th>
    <th>Sección Solicitante</th>
    <th>Numero </th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($d as $fila) {

?>
  <tr>
    <td><?php echo $fila['id_consumo']?></td>
    <td><?php echo $fila['fecha']?></td>
    <td><?php echo ucwords($fila['seccion'])?></td>
    <td><?php echo $fila['factura']?></td>

    <td><a title="Ver Factura" rel="leanModal" href="#ventana" onclick="dialogo(<?php echo $fila['id_consumo']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
        <?php if($fila['eliminable']==1 && $id_permiso==4){  ?>
            <a title="Eliminar Factura" href="javascript:enviar(<?php echo $fila[id_consumo]; ?>)"><img  src="<?php echo base_url()?>img/ico_basura.png"/></a>
        <?php }?>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Informacion de Factura</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function dialogo(id)
	{  
		$('#contenido-ventana').load(base_url()+'index.php/vales/dialogo_factura/'+id);
		return false;
	}	
	function enviar(v)
    {
        alertify.confirm("¿Está seguro de eliminar esta factura ? Este cambio no lo podrá revertir.", function (e) {
                if (e) {

                    //$('form').submit();
                        //return false;
                        //console.log('Entro '+ v);
                    window.location.href = base_url()+'index.php/vales/eliminar_factura/'+v;

                } else {

                    return false;
                }
            });
        
    }
</script>

