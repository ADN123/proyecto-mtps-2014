<form id='form' action="<?php echo base_url()?>index.php/vehiculo/modificar_datos_vehiculo" method='post'>
    <input type='hidden' id='resp' name='resp' />
    <input type='hidden' name='ids' value="<?php echo $id?>" />

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
					$kilimetraje=$v->kilometraje;
					$motorista=$v->motorista;
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
                Modelo: <strong>".$modelo."</strong> <br></fieldset>
    <br />";
	?>
    	<fieldset>
        <legend align='left'>Asignaciones</legend>
		<?php
           
		?>
        </fieldset>
	<?php
            
    echo "
	<br>
    <fieldset>
        <legend align='left'>Destinos</legend>
       
    </fieldset>
    <br>
    <fieldset>
        <legend align='left'>Acompañantes</legend>
        
        ";
           ?>	
    </fieldset>
    <br>
    <fieldset>
        <legend align='left'>Informaci&oacute;n  Adicional</legend>
        <label for="observacion" id="lobservacion" class="label_textarea">Observaciones</label>
        <textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
    </fieldset>
    <p style='text-align: center;'>
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador" name="aprobar" onclick="Enviar(2)">Aprobar</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador" name="Denegar" onclick="Enviar(0)">Denegar</button>
    </p>
</form>
<script>
	$("#observacion").validacion({
		req: false,
		lonMin: 10
	});
</script>