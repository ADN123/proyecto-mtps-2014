
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>

	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Liquidacion de combustible</h2>
</section>


<form name="filtro" method="post" id="filtro" action="<? echo base_url()?>index.php/vales/liquidacion_pdf" target="_blank">

            <p> 
               <label for="mes" id="lmes">Mes </label>
                    <select class="select" style="width:300px;" tabindex="1" id="mes" name="mes">
                    <?php     
                        foreach($meses as $val) 
                        {                    ?>
                                <option value="<?php echo $val['mes'] ?>"><?php echo  ucwords($val['mesn']); ?></option>                
                    <?php
                        } 
                    ?>
                                                                
                    </select>
            
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                    <select class="select" style="width:300px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo" >
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
                     <label for="id_seccion" id="lid_seccion">Sección</label>
                    <select class="select" style="width:300px;" tabindex="3" id="ilid_seccion" name="id_seccion" >
                        <option value="0">[Todo]</option>  
                    <?php     
                        foreach($oficinas as $val) 
                        {                    ?>
                                <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['seccion']; echo $val['nombre_seccion'];  ?></option>                
                    <?php
                        } 
                    ?>
                                                                
                    </select>
                    <input name="salida" value="1" checked type="radio">  PDF 
                    <input name="salida" value="2"  type="radio">   XLS

            </p>
            <p align="center">                   
                    <button   id="imp1" class="button tam-1" >Imprimir</button>
            </p>
</form>

<script type="text/javascript">
   // $('#id_fuente_fondo').kendoDropDownList();
    //$("#sexo").kendoDropDownList();

</script>
