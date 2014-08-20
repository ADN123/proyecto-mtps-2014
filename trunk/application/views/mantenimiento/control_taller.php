<section>
    <h2>Vehículos en Taller Interno</h2>
</section>
<button type="button" id="ingresoTaller" class="button tam-1">
<a href="<?php echo base_url(); ?>index.php/vehiculo/controlMtto" target="_parent">Ingresar Vehículo</a>
</button>
<button type="button" id="Taller" class="button tam-1">
<a href="<?php echo base_url(); ?>index.php/vehiculo/tallerMTPS" target="_parent">Reparación de Vehículo</a>
</button>
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
                <a rel="leanModal" title="Dar de Alta" href="<?php echo base_url()."index.php/vehiculo/alta_tallerMTPS/".$fila->id ?>" ><img src="<?php echo base_url()?>img/alta.png"/></a>
                <a rel="leanModal" title="Enviar a Taller Externo" href="<?php echo base_url()."index.php/vehiculo/ingresar_taller_externo/".$fila->id ?>" ><img src="<?php echo base_url()?>img/taller.png"/></a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>


<div id="ventana" style="height:600px; width:650px">
    <div id='signup-header'>
        <h2>Información del Vehículo</h2>
        <a class="modal_close"></a>
    </div>
    <div id='contenido-ventana'>
    </div>
</div>