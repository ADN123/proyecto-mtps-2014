<script>
	var permiso=<?php echo $id_permiso;?>;
	estado_transaccion='<?php echo $estado_transaccion;?>';
	estado_correcto='La requisición se ha guardado correctamente';
	estado_incorrecto='Error al intentar guardar la requisición: No se pudo conectar al servidor. Por favor vuelva a intentarlo.';


</script>
<script src="<?php echo base_url()?>js/views/entrega_vales.js" type="text/javascript"></script>
<section>
    <h2>Consumo de Vales de Combustible</h2>
</section>
<style>
.k-multiselect {
	display: inline-block;
}

</style>
<form name="form_mision" method="post" id="form_mision" action="<?php //echo base_url()?>#">
	           
            <p> 

                <label for="start" >Start date:</label><input id="start" style="width: 200px"/>
                 <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                <select class="select" style="width:200px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo">
                
                <?php     
                    foreach($fuente as $val) 
                    {                    ?>
                                 <option value="<?php echo $val['id_fuente_fondo'] ?>"><?php echo $val['nombre_fuente'] ?></option>                
                <?php
                    } 
                ?>
                </select>


					
            </p>
            <p>
                <label for="end">End date:</label><input id="end" style="width: 200px"/>
                <label for="id_seccion" id="lservicio_de">Sección</label>
                <select class="select" style="width:300px;" tabindex="4" id="id_seccion" name="id_seccion" onChange="cargar_vehiculo()">
                        <?php
                            foreach($oficinas as $val) {
                        ?>
                                <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
                        <?php   
                            }
                        ?>
                </select>               

            </p>
            <p align="right">
                <button type="button" id="nuevo1" class="button tam-1" >Buscar</button>
                <a id="nuevo2" rel="leanModal" href="#ventana"></a>

            </p>


    
</form>

<script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>
<div id="datos">



</div>