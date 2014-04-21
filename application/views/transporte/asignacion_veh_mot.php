<section>
    <h2>Asignación de Vehículo y Motorista</h2>
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
        foreach ($datos as $fila) {
    ?>
        <tr>
            <td><?php echo $fila->fecha?>&nbsp;&nbsp;<?php echo $fila->salida?></td>
            <td><?php echo ucwords($fila->seccion)?></td>
            <td><?php echo ucwords($fila->nombre)?></td>
            <td><a rel="leanModal" title="Ver solicitud" href="#ventana" onclick="dialogo(<?php echo $fila->id?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div id="ventana" style="height:600px">
    <div id='signup-header'>
        <h2>Asignación de Vehículo y Motorista para Misión Oficial</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>

<script language="javascript" >
	function dialogo(id)
	{
		$('#contenido-ventana').load('cargar_datos_solicitud/'+id);
		return false;
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