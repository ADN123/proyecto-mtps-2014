
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Consumo de Vales</h2>
</section>
<button type="button" id="nuevo1" class="button tam-1">Filtrar</button>
<a id="nuevo2" rel="leanModal" href="#ventana"></a>

<div style="height:400px; background:#FFFFFF;" id="chartdiv">


</div>

  <table cellspacing='0' align='center' class='table_design'>
            <thead>
                <th>
                   Seccion
                </th>
                <th>
                    Consumido
                </th>
                <th>
                    Asignado
                </th>
                

            </thead>
            <tbody>
            <?php

                foreach($a as $r)
                {
                    echo "<tr><td align='center'>".$r->seccion."</td>";
                    echo "<td align='center'>".$r->consumido."</td>";
                    echo "<td align='center'>".$r->asignado."</td></tr>";                    
                }
                   ?>
        
            </tbody>
        </table>

    <!----------------------------------------------------------------------------------------------------------------- -->

<div id="ventana" style="height:300px">
    <div id='signup-header'>
        <h2>Consumos de Vales</h2>
        <a class="modal_close"></a>
    </div>

    <div id='contenido-ventana'>
        <form name="form_mision" method="post" id="form_mision" action="<?php //echo base_url()?>#">

         <fieldset>      
        <legend align='left'>Origen de Vales</legend>

               
                <p> 
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
                <br>
                <p>
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
             </fieldset>      
             <br>
        <fieldset>      
        <legend align='left'>Intervalo de Fechas</legend>
            <p>

                <label for="start" >Fecha Inicio:</label><input id="start" style="width: 200px"/>
            </p>
            <br>
            <p>
                
                <label for="end">Fecha Final:</label><input id="end" style="width: 200px"/>
            </p>
            </fieldset>      
              <p align="center">
                <button type="button" id="nuevo1" class="button tam-1" >Buscar</button>
                <a id="nuevo2" rel="leanModal" href="#ventana"></a>

            </p>
    
</form>

    </div>
</div>
<script language="javascript" >

    $("#nuevo1").click(function(){
            $("#nuevo2").click();
        });
    
    $("#nuevo2").click(function(){
        //$('#contenido-ventana').load(base_url()+'index.php/vales/dialogoN_asignacion');
        return false;
    });

        var chart;

            var chartData =<?php echo $b;?>


</script>
<script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>