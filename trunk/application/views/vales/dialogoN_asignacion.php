<form id='form' action="<?php echo base_url()?>index.php/vales/insertar_asignacion" method='post'>

    <fieldset>      
        <legend align='left'>Informacion general</legend>    
          <p> 
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                <select class="select" style="width:200px;" tabindex="1" id="id_fuente_fondo" name="id_fuente_fondo" >
                    <?php
                        foreach($fuente as $val) {
                    ?>
                       <option value="<?php echo $val['id_fuente_fondo'] ?>"><?php echo $val['nombre_fuente'] ?></option>
                    <?php   
                        }
                    ?>
                </select>
            </p>        
            <p>
                <label for="id_seccion" id="lservicio_de">Sección</label>
                <select class="select" style="width:300px;" tabindex="1" id="id_seccion" name="id_seccion">
                        <?php
                            foreach($oficinas as $val) {
                        ?>
                                <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
                        <?php   
                            }
                        ?>
                    </select>
            </p>
</fieldset>      
<fieldset>      
        <legend align='left'>Informacion adicional</legend>
    
        <label for="asignar" id="lasignar" class="tam-2">Cantidad</label>
        <input class="tam-1" id='asignar' tabindex='3' name='cantidad' type="text"  value="<?php echo $cantidad?>"/>
    

 </fieldset>
    <br />
    

    <p style='text-align: center;'>
    	<button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)" tabindex='3' >Guardar</button>
    </p>
</form>
<script>
	
		$("#asignar").validacion({
			ent: true,
			numMin: 0
		});
</script>