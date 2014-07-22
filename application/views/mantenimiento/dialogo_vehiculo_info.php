<form id='form' action="<?php echo base_url()?>index.php/vehiculo/modificar_datos_vehiculo" method='post'>
    <input type='hidden' id='resp' name='resp' />

    <fieldset>      
        <legend align='left'>Generalidades del Vehículo</legend>
            <?php 
                foreach($datos as $v)
                {
					$id_vehiculo=$v->id_vehiculo;
                    $placa=$v->placa;
					$marca=$v->marca;
					$id_marca=$v->id_marca;
					$modelo=$v->modelo;
					$id_modelo=$v->modelo;
					$condicion=$v->condicion;
					$id_condicion=$v->id_condicion;
					$clase=$v->clase;
					$id_clase=$v->id_clase;
					$kilometraje=$v->kilometraje;
					$motorista=ucwords($v->motorista);
					$id_motorista=$v->id_empleado;
					$anio=$v->anio;
					$fuente_fondo=$v->fuente_fondo;
					$id_fuente_fondo=$v->id_fuente_fondo;
                    $seccion=ucwords($v->seccion);
					$id_seccion=$v->id_seccion;
					$imagen=$v->imagen;
					$estado=$v->estado;
                }
            
                echo "Placa: <strong>".$placa."</strong> <br>
                Marca: <strong>".$marca."</strong> <br>
                Modelo: <strong>".$modelo."</strong> <br>
				</fieldset>
    <br />";
	?>
    	<fieldset>
        <legend align='left'>Asignaciones</legend>
		<?php
			 echo "Sección: <strong>".$seccion."</strong> <br>
                Motorista: <strong>".$motorista."</strong> <br>
                Fuente de Fondo: <strong>".$fuente_fondo."</strong> <br></fieldset>
    <br />";
		?>
        </fieldset>

    <fieldset>
        <legend align='left'>Estado</legend>
        <?php
			 echo "Condición del vehículo: <strong>".$condicion."</strong> <br>
                Estado Actual: <strong>".$estado."</strong> <br>
                Kilometraje Recorrido: <strong>".$kilometraje." km</strong> <br></fieldset>
    <br />";
		?>
    </fieldset>
    <p style='text-align: center;'>
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador" name="Modificar" onclick="Enviar(2)">Modificar Información</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador" name="Aceptar">Aceptar</button>
    </p>
</form>
<script>
	$("#observacion").validacion({
		req: false,
		lonMin: 10
	});
</script>