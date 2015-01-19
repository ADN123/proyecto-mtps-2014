<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='<?php echo $mensaje?>';
	estado_incorrecto='Error de conexión al servidor. Por favor vuelva a intentarlo más tarde.';
</script>
<section>
    <h2>Vehículos en Taller Interno</h2>
</section>

<button style="width:200px" type="button" onclick="window.open('<?php echo base_url(); ?>index.php/vehiculo/controlMtto','_parent')" name="btnNuevo">
Ingresar Vehículo
</button>
<table  class="grid">
    <thead>
      <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Clase</th>
        <th>Fecha Ingreso</th>
        <th>Opción</th>
      </tr>
     </thead>
     <tbody>
    <?php   
	foreach ($ingreso_taller as $fila) {
    ?>
        <tr align="center">
            <td><?php echo $fila['placa']?></td>
            <td><?php echo ucwords($fila['marca'])?></td>
            <td><?php echo ucwords($fila['modelo'])?></td>
            <td><?php echo ucwords($fila['clase'])?></td>
            <td><?php echo ucwords($fila['fecha_recepcion'])?></td>
            <td>
            	<a rel="leanModal" title="Ver información del Vehículo" href="#ventana" onclick="dialogo(<?php echo $fila['id_ingreso_taller']?>,<?php echo $fila['id_vehiculo']?>)"><img  src="<?php echo base_url()?>img/lupa.gif"/></a>
                <a rel="leanModal" title="Reparar Vehículo" href="<?php echo base_url()."index.php/vehiculo/tallerMTPS/".$fila['id_vehiculo'] ?>" ><img src="<?php echo base_url()?>img/reparacion.png" height="23px"/></a>
                <a rel="leanModal" title="Enviar a Taller Externo" href="<?php echo base_url()."index.php/vehiculo/ingreso_taller_ext/".$fila['id_vehiculo'] ?>" ><img src="<?php echo base_url()?>img/taller.png" height="35px"/></a>
                <a rel="leanModal" title="Dar de Alta" href="<?php echo base_url()."index.php/vehiculo/alta_taller_MTPS/".$fila['id_ingreso_taller'] ?>" ><img src="<?php echo base_url()?>img/alta.png" height="23px"/></a>
                <a rel="leanModal" title="Imprimir Hoja de Control de Ingreso al Taller"
                href="<?php echo base_url()."index.php/vehiculo/hoja_ingreso_taller/".$fila['id_ingreso_taller'] ?>" target="_blank" >
                <img src="<?php echo base_url()?>img/ico_pdf.png" height="23px"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Vehículo</h2>
        <a class="modal_close" id="cerrar"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>

<script type="text/javascript">
function dialogo(id,id2)
{
	$('#contenido-ventana').load(base_url()+'index.php/vehiculo/ventana_mantenimientos/'+id+'/'+id2);
	return false;
}
function cerrar_vent()
{
	$('#cerrar').click();
}
</script>