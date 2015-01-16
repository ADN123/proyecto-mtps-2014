<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='<?php echo $mensaje; ?>';
	estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo.';
</script>
<section>
    <h2>Catálogo de Vehículos</h2>
</section>
<button style="width:200px" type="button" onclick="window.open('<?php echo base_url()."index.php/vehiculo/nuevo_vehiculo" ?>','_parent')" name="btnNuevo">Nuevo Vehículo</button>
<table  class="grid">
    <thead>
      <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Clase</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php    
        foreach ($datos as $fila) {
    ?>
        <tr>
            <td><?php echo $fila->placa?></td>
            <td><?php echo ucwords($fila->marca)?></td>
            <td><?php echo ucwords($fila->modelo)?></td>
            <td><?php echo ucwords($fila->clase)?></td>
            <td>
            	<a rel="leanModal" title="Ver información del Vehículo" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
                <a rel="leanModal" title="Modificar información del Vehículo" href="<?php echo base_url()."index.php/vehiculo/nuevo_vehiculo/".$fila->id ?>" ><img src="<?php echo base_url()?>img/editar.png"/></a>
                 <a rel="leanModal" title="Reportar Anomalía del Vehículo" href="<?php echo base_url()."index.php/vehiculo/controlMtto/".$fila->id ?>" ><img src="<?php echo base_url()?>img/mantenimiento.png" height="20px"/></a>
                <a rel="leanModal" title="Reparar Vehículo" href="<?php echo base_url()."index.php/vehiculo/tallerMTPS/".$fila->id."/1" ?>" ><img src="<?php echo base_url()?>img/reparacion.png" height="23px"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Vehículo</h2>
        <a id="cerrar" class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>
<script language="javascript" >
	function dialogo(id)
	{
		$('#contenido-ventana').load(base_url()+'index.php/vehiculo/dialogo_vehiculo_info/'+id);
		return false;
	}
	function cerrar_vent()
	{
		$('#cerrar').click();
	}
	function motoristaf(id,id2)
	{
		$('#motorista').destruirValidacion();
		$('#cont-select').html("");
		$.ajax({
			async:	true, 
			url:	"<?php echo base_url()?>/index.php/transporte/verificar_motoristas/"+id+"/"+id2,
			dataType:"json",
			success: function(data) {
				json = data;
				var cont='';
				cont=cont+'<select name="motorista" id="motorista">';
				for(i=0;i<json.length;i++) {			
					cont=cont+'<option value="'+json[i].id_empleado+'">'+json[i].nombre.capitalize()+'</option>';
				}	
				cont=cont+'</select>';
				$('#cont-select').html(cont);
				$('#motorista').kendoComboBox({
					autoBind: false,
					filter: 'contains'
				});
				/*$('#motorista').validacion({
					men: 'Debe seleccionar un item'
				});*/
			},
			error:function(data) {
				 alertify.alert('Error al cargar los datos de los motoristas');
			}
		});	
	}
	
	function enviar(v)
	{
		document.getElementById('resp').value=v;
	}
</script>