<script>
	estado_transaccion='<?php echo $estado_transaccion?>';
	estado_correcto='Se ha registrado un nuevo vehículo exitosamente.';
	estado_incorrecto='Error al registrar un nuevo vehículo: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
</script>
<section>
    <h2>Nuevo Vehículo</h2>
</section>
<form name="form_vehiculo" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_vehiculo">

<div style="width:600px">
    <p>
        <label>Número de Placa:</label>
        <input type="text" name="placa" size="10" />
    </p>
    <p>
        <label>Marca:</label>
        <input type="text" name="marca" />
    </p>
    <p>
        <label>Modelo:</label>
        <input type="text" name="modelo" />
    </p>
    <p>
        <label>Clase:</label>
        <input type="text" name="clase" />
    </p>
    <p>
        <label>Condición:</label>
        <input type="text" name="condicion" />
    </p>
    <p>
        <label>Sección:</label>
        <input type="text" name="seccion" />
    </p>
    <p>
        <label>Motorista:</label>
        <select name="motorista">
        <?php
        
        foreach($motoristas as $mot)
        {
            echo "<option value='".$mot->id_empleado."'>".ucwords($mot->nombre)."</option>";
        }
        ?>
	    </select>
	</p>
    <p>
        <label>Tipo:</label>
        <select name="tipo">
            <option>Propio</option>
            <option>Donado por Banco Mundial</option>
        </select>
    </p>
    <p>
        <label>Fotografía:</label>
        <input type="file" name="imagen" />
	</p>
    <p align="center">
    	<input type="submit" name="btnRegistrar" value="Guardar" />
    </p>
</div>
</form>