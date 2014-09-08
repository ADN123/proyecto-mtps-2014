
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Herramientas y otros articulos que consumen combustible</h2>
</section>
<button type="button" id="nuevo1" class="button tam-1">Nueva Herramiena</button>
<a id="nuevo2" rel="leanModal" href="#ventana"></a>

<table  class="grid" >
<thead>
  <tr>
    <th>Seccion</th>
    <th>Nombre</th>
    <th>Fuente de Financiamiento</th>
    <th>Combustible/th>
    <th>Opción</th>
  </tr>
 </thead>
 <tbody>
<?php
foreach ($datos as $fila) {

?>
<tr>
    <td><?php echo ucwords($fila['seccion'])?></td>
    <td><?php echo $fila['nombre']?></td>    
    <td><?php echo $fila['fuente']?></td>    
    <td><?php echo $fila['combustible']?></td>    
    <td><a title="Modificar" rel="leanModal" href="#ventana" onclick="Modificar(<?php echo $fila['id_herramienta']?>)"><img  src="<?php echo base_url()?>img/editar.png"/></a>
        <a title="Eliminar"  onclick='Eliminar(<?php echo $fila['id_herramienta']?>,"<?php echo ucwords($fila['nombre'])?>")'><img  src="<?php echo base_url()?>img/ico_basura.png"/></a>
        
	</td>
  </tr>


<?php } ?>
</tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Heramientas y otros articulós consumidores de combustible</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function Modificar(id_herramienta)
	{  
		$('#contenido-ventana').load(base_url()+'index.php/vales/dialogoM_herramienta/'+id_herramienta);
		return false;
	}	
    
    $("#nuevo1").click(function(){
            $("#nuevo2").click();
        });
    
    $("#nuevo2").click(function(){
        $('#contenido-ventana').load(base_url()+'index.php/vales/dialogoN_herramienta');
        return false;
    });

	
	function Eliminar(id1,nom)
	{
//        id=$(this).data("id_usuario");
  //      nom=$(this).data("nombre_completo");
        alertify.confirm("Realmente desea eliminar este articulo'<i>"+nom+"</i>'?", function (e) {
            if (e) {
                location.href=base_url()+'index.php/vales/eliminar_herramienta/'+id1;
            } else {
                return false;
            }
        });
	}
</script>