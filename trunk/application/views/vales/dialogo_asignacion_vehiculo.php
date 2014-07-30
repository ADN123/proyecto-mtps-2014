<form id='form' action="<?php echo base_url()?>index.php/vales/modificar_asignacion_vehiculo" method='post'>

    <fieldset>      
        <legend align='left'>Información del vehículo</legend>
            <?php 

                foreach($d as $datos)
                {

                    $seccion=ucwords($datos['seccion']);
                    $placa=$datos['placa'];
                    $modelo=$datos['modelo'];
                    $fuente=$datos['fuente'];
                    $marca=$datos['marca'];
                    $id_fuente_fondo= $datos['id_fuente_fondo']; 
                    $id_vehiculo= $datos['id_vehiculo']; 

                }
            
                echo "Vehiculo a servicio de : <strong>".$seccion."</strong> <br>
                    Fuente de Fondo: <strong>".$fuente."</strong> <br>
                    Placa: <strong>".$placa."</strong> <br>
                    Modelo: <strong>".$modelo."</strong> <br>
                    Marca: <strong>".$marca."</strong> <br>
                </fieldset>
    <br />";
	?>
    <input type='hidden' name='id_seccion' value="<?php echo $id_seccion?>" />
    <input type='hidden' name='id_fuente_fondo' value="<?php echo $id_fuente_fondo?>" />    	
    <input type='hidden' name='id_vehiculo' value="<?php echo $id_vehiculo?>" />        
<fieldset>      
  <legend align='left'>Sección de consumo de vehículo</legend>
<select class="select" style="width:500px;" tabindex="4" id="id_seccion" name="id_seccion" >
         
        <?php
            foreach($oficinas as $val) {
        ?>
                <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
        <?php   
            }
        ?>
 </select> 

 </fieldset>
    <br />
    

    <p style='text-align: center;'>
    	<button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)">Guardar</button>
    </p>
</form>
<script>
	
		$("#id_seccion").validacion();
</script>