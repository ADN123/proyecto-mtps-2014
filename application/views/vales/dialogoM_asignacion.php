<form id='form' action="<?php echo base_url()?>index.php/vales/modificar_asignacion" method='post'>

    <fieldset>      
        <legend align='left'>Información  General</legend>
            <?php 

                foreach($d as $datos)
                {

                    $seccion=ucwords($datos['seccion']);
                    $id_seccion=$datos['id_seccion'];
                    $cantidad=$datos['cantidad'];
                    $fuente=$datos['fuente'];
                    $id_fuente_fondo= $datos['id_fuente_fondo']; 

                }
            
                echo "Sección: <strong>".$seccion."</strong> <br>
                Fuente de Fondo: <strong>".$fuente."</strong> <br>
                </fieldset>
    <br />";
	?>
    <input type='hidden' name='id_seccion' value="<?php echo $id_seccion?>" />
    <input type='hidden' name='id_fuente_fondo' value="<?php echo $id_fuente_fondo?>" />    	
<fieldset>      
        <legend align='left'>Información adicional</legend>
    
        <label for="asignar" id="lasignar" class="tam-2">Cantidad</label>
        <input class="tam-1" id='asignar' tabindex='2' name='cantidad' type="text"  value="<?php echo $cantidad?>"/>
    

 </fieldset>
    <br />
    

    <p style='text-align: center;'>
    	<button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)">Guardar</button>
    </p>
</form>
<script>
	
		$("#asignar").validacion({
			ent: true,
			numMin: 0
		});
</script>