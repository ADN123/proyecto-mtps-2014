
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Consumo por vehiculo</h2>
</section>


<form name="filtro" method="post" id="filtro" action="<? echo base_url()?>index.php/vales/reporte_vehiculo_pdf" target="_blank">

            <p> 
                <label for="start" >Fecha Inicio:</label><input id="start" name="start" style="width: 200px" tabindex="1"/>
            
                <label for="id_fuente_fondo" id="lid_fuente_fondo">Fuente de Fondo </label>
                    <select class="select" style="width:300px;" tabindex="2" id="id_fuente_fondo" name="id_fuente_fondo">
                        <option value="0">[Todo]</option>  
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
                    <label for="end">Fecha Final:</label><input id="end" name="end" style="width: 200px" tabindex="4"/>                    
                    <label for="id_seccion" id="lservicio_de">Sección</label>
                    <select class="select" style="width:300px;" tabindex="4" id="id_seccion" name="id_seccion" >
                             <option value="0">[Todo]</option>  
                            <?php
                                foreach($oficinas as $val) {
                            ?>
                                    <option value="<?php echo $val['id_seccion'] ?>"><?php echo $val['nombre_seccion'] ?></option>
                            <?php   
                                }
                            ?>
                           
                    </select>               
            </p>
            <p align="center">
                    <button type="button" id="Filtrar" class="button tam-1" >Filtrar</button>                    
                    <button   id="imp1" class="button tam-1" >Imprimir</button

            </p>
</form>
<br><br>

<table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
               <th>
                    Placa
                </th>
                <th>
                    Marca
                </th>
                <th>
                    Vales aplicados
                </th>
                 <th>
                    Combustible Aplicado (gal)
                </th>
               <th>
                    Recorrido (Km)
                </th>  
                 <th>
                    Rendimiento (gal/Km)
                </th>             

            </thead>
            <tbody>
            </tbody>
        </table>


    <!----------------------------------------------------------------------------------------------------------------- -->

<script language="javascript" >

    $("#Filtrar").click(function(){             

            var formu = $('#filtro').serializeArray();
        //    console.log(formu); 

        reporte(formu);
        });

    function reporte(formu){  
                $.ajax({
            async:  true, 
            url:    base_url()+"index.php/vales/reporte_vehiculo_json",
            dataType:"json",
             type: "POST",
            data: formu,
            success: function(data){
                tabla2(data) 

                },
            error:function(data){
                    alertify.alert('Error al cargar datos');

                }
        });          
        
    }

setTimeout ("reporte();", 300);
///llamada al finalizar la contrucion del archivo
</script>

<script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>