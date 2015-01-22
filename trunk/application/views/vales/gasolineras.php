<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	<?php if($accion!="") {?>
		estado_correcto='La <?php echo $titulo?> se ha <?php echo $accion?>do exitosamente.';
		estado_incorrecto='Error al intentar <?php echo $accion?>r la <?php echo $titulo?>: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
	<?php }?>
</script>
<section>
    <h2>Control de <?php echo $titulo?>s</h2>
</section>
<button type="button" id="nuevo" class="button tam-1">Nueva <?php echo $titulo?></button>
<a id="nuevo2" rel="leanModal" href="#ventana"></a>
<table  class="grid" >
<colgroup>
	<col style="width:100px"/>
	<col />
	<col />
	<col style="width:100px"/>
</colgroup>
<thead>
  <tr>
    <th>ID </th>
    <th>Nombre</th>
    <th>Telefono</th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
	foreach ($d as $val) {
?>
  <tr>
    <td><?php echo $val['id_gasolinera']?></td>
    <td><?php echo $val['nombre']?></td>
    <td><?php echo $val['telefono']?></td>
    <td>
    	<a class="modificar" title="Modificar <?php echo $titulo?>" rel="leanModal" href="#ventana" data-id_gasolinera="<?php echo $val['id_gasolinera']?>" data-nombre="<?php echo ucwords($val['nombre'])?>"><img src="<?php echo base_url()?>img/lupa.gif"/></a>
    	<a class="eliminar" title="Eliminar <?php echo $titulo?>" data-id_gasolinera="<?php echo $val['id_gasolinera']?>" data-nombre="<?php echo $val['nombre']?>"><img src="<?php echo base_url()?>img/ico_basura.png"/></a>
	</td>
  </tr>
<?php } ?>
</tbody>
</table>
<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2 id="titulo-ventana"></h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$("#nuevo").click(function(){
			$("#nuevo2").click();
		});
		$("#nuevo2").click(function(){
			$("#titulo-ventana").html("Nueva gasolinera");
			$('#contenido-ventana').load(base_url()+'index.php/vales/nuevo_gasolinera');
			return false;
		});

		$(".modificar").click(function(){
			id=$(this).data("id_gasolinera");
			$("#titulo-ventana").html("Modificar <?php echo $titulo?> - ");
			$('#contenido-ventana').load(base_url()+'index.php/vales/modificar_gasolinera/'+id);
			return false;
		});
		$(".eliminar").click(function(){
			id=$(this).data("id_gasolinera");
			nom=$(this).data("nombre");
			alertify.confirm("Realmente desea eliminar la <?php echo $titulo?> '<i>"+nom+"</i>'? Este cambio no lo podrá revertir.", function (e) {
				if (e) {
					window.location.href = base_url()+'index.php/vales/eliminar_gasolinera/'+id;
				} else {
					return false;
				}
			});
		});
	});
</script>