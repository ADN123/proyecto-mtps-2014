
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

<form name="filtro" method="post" id="filtro" action="<?php //echo base_url()?>#">

            <p> 
                <label for="start" >Fecha Inicio:</label><input id="start" style="width: 200px" tabindex="1"/>
            
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                    <select class="select" style="width:300px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo">
                    
                    <?php     
                        foreach($fuente as $val) 
                        {                    ?>
                                     <option value="<?php echo $val['id_fuente_fondo'] ?>"><?php echo $val['nombre_fuente'] ?></option>                
                    <?php
                        } 
                    ?>
                                    <option value="0">[Todo]</option>
                    </select>

            </p>
            <p>
                    <label for="end">Fecha Final:</label><input id="end" style="width: 200px" tabindex="4"/>                    
                    <label for="id_seccion" id="lservicio_de">Sección</label>
                    <select class="select" style="width:300px;" tabindex="4" id="id_seccion" name="id_seccion" onChange="cargar_vehiculo()">
                            <?php
                                foreach($oficinas as $val) {
                            ?>
                                    <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
                            <?php   
                                }
                            ?>
                                    <option value="0">[Todo]</option>
                    </select>               
            </p>
            <p align="center">
                    <button type="button" id="Filtrar" class="button tam-1">Filtrar</button>

            </p>
</form>

    <!------------------------------------------Plantilla de carga de grafico y tabla----------------------------------------------------------------------- -->
<div style="height:400px; background:#FFFFFF;" id="chartdiv">
</div>
<br>
<table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
                <th>
                   Seccion
                </th>
                <th>
                    Asignado
                </th>
                <th>
                    Consumido
                </th>            

            </thead>
            <tbody>
            </tbody>
        </table>


    <!----------------------------------------------------------------------------------------------------------------- -->

<script language="javascript" >

    $("#Filtrar").click(function(){

            var formu = $('#filtro').serializeArray();
            console.log(formu);

        reporte();
        });

    function reporte(){  
                $.ajax({
            async:  true, 
            url:    base_url()+"index.php/vales/consumo_json",
            dataType:"json",
            success: function(data){
                grafico(data);//contructor del grafico
                tabla(data) 

                },
            error:function(data){
                 alertify.alert('Error al cargar datos');
                console.log(data);
                }
        });          
        
    }

reporte();///llamada al finalizar la contrucion del archivo
</script>

<script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>