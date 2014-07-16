<?php 

                foreach($d as $datos)
                {
                    $nombre=$datos->nombre;
                    $id_seccion=$datos->id_seccion_vale;
                    $id_fuente_fondo=$datos->id_fuente_fondo;
                    $descripcion=$datos->descripcion;
                    $id=$datos->id_herramienta;
                }



?>

<form id='form' action="<?php echo base_url()?>index.php/vales/modificar_herramienta" method='post'>
            <input  id='id' tabindex='3' name='id' value="<?php echo $id;?>" type="hidden" />
    <fieldset>      
        <legend align='left'>Información general</legend>    
          <p> 
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                <select class="select" style="width:200px;" tabindex="1" id="id_fuente_fondo" name="id_fuente_fondo" >
                    <?php
                        foreach($fuente as $val) {
                    ?>
                       <option value="<?php echo $val['id_fuente_fondo'] ?>" 
                        <?php if($id_fuente_fondo==$val['id_fuente_fondo']){  echo " selected";}?>
                        ><?php echo $val['nombre_fuente'] ?></option>
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
                                <option value="<?php echo $val['id_seccion'] ?>"
                        <?php if($id_seccion==$val['id_seccion']){  echo " selected";}?>
                                    ><?php echo $val['nombre_seccion'] ?></option>
                        <?php   
                            }
                        ?>
                    </select>
            </p>
</fieldset>      
<fieldset>      
        <legend align='left'>Información adicional</legend>
    
        <p>
            <label for="nombre" id="lnombre" class="tam-1" >Nombre</label>
            <input class="tam-2" id='nombre' tabindex='3' name='nombre' type="text"  value="<?php echo $nombre;?>"/>
        </p>
        <p>

            <label for="descripcion" id="ldescripcion" class="label_textarea">Descripción</label>
            <textarea class="tam-3" id='descripcion' tabindex='4' name='descripcion' ><?php echo $descripcion;?></textarea>
        </p>
    

 </fieldset>
    <br />
    

    <p style='text-align: center;'>
    	<button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)" tabindex='3' >Guardar</button>
    </p>
</form>
<script>
    $("#nombre").validacion({
        lonMin: 5
    });
    $("#descripcion").validacion({
         lonMin: 5,
         req: false
        });
</script>