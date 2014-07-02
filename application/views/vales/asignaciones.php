
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Asignaciones de Vales</h2>
</section>
<button type="button" id="nuevo1" class="button tam-1">Nueva Asignación</button>
<a id="nuevo2" rel="leanModal" href="#ventana"></a>

<table  class="grid" >
<thead>
  <tr>
    <th>Seccion</th>
    <th>Fuente de Fondo</th>
    <th>Cantidad </th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
foreach ($datos as $fila) {

?>
<tr>
    <td><?php echo ucwords($fila['seccion'])?></td>
    <td><?php echo $fila['fuente']?></td>    
    <td><?php echo $fila['cantidad']?></td>
    <td><a title="Modificar" rel="leanModal" href="#ventana" onclick="Modificar(<?php echo $fila['id_seccion']?>, <?php echo $fila['id_fuente_fondo']?>)"><img  src="<?php echo base_url()?>img/editar.png"/></a>
        <a title="Eliminar"  onclick='Eliminar(<?php echo $fila['id_seccion']?>, <?php echo $fila['id_fuente_fondo']?>,"<?php echo ucwords($fila['seccion'])?>")'><img  src="<?php echo base_url()?>img/ico_basura.png"/></a>
        
	</td>
  </tr>


<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Asignaciones de Vales</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function Modificar(id_seccion, id_fuente_fondo)
	{  
		$('#contenido-ventana').load(base_url()+'index.php/vales/dialogoM_asignacion/'+id_seccion+'/'+id_fuente_fondo);
		return false;
	}	
    
    $("#nuevo1").click(function(){
            $("#nuevo2").click();
        });
    
    $("#nuevo2").click(function(){
        $('#contenido-ventana').load(base_url()+'index.php/vales/dialogoN_asignacion');
        return false;
    });

	
	function Eliminar(id1, id2, nom)
	{
//        id=$(this).data("id_usuario");
  //      nom=$(this).data("nombre_completo");
        alertify.confirm("Realmente desea eliminar la asignación de vales de combustible a  '<i>"+nom+"</i>'?", function (e) {
            if (e) {
                location.href=base_url()+'index.php/vales/eliminar_asignacion/'+id1+'/'+id2;
            } else {
                return false;
            }
        });
	}
</script>