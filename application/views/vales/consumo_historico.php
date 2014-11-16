
<script type="application/javascript" language="javascript">
	estado_transaccion='<?php echo $estado_transaccion?>';
<?php if($accion!="") {?>
	estado_correcto='La solicitud se ha <?php echo $accion?>do exitosamente.';
	estado_incorrecto='Error al intentar <?php echo $accion?>r la solicitud: No se pudo conectar al servidor. Porfavor vuelva a intentarlo.';
<?php }?>

</script>

<section>
    <h2>Consumo Historico </h2>
</section>


<form name="filtro" method="post" id="filtro" action="<? echo base_url()?>index.php/vales/historico_pdf" target="_blank">

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
            <p>
                <label for="color1" style="width: 300px">Color de grafico</label>
                 <input id="color1" style="width: 200px" name="color1"/>
                <label for="grupo" style="width: 160px">Ver por</label>
                <select class="select" style="width:200px;" tabindex="4" id="agrupar" name="agrupar" >
                     <option value="1" selected>Día</option>
                     <option value="2" >Mes</option>
                     <option value="3" >Año</option>                    
                </select>   

                 

            </p>

            <p align="center">
                    <button type="button" id="Filtrar" class="button tam-1" >Filtrar</button>                    
                    <button   id="imp1" class="button tam-1" >Imprimir</button

            ></p>
</form>

    <!------------------------------------------Plantilla de carga de grafico y tabla----------------------------------------------------------------------- -->
<div style="height:400px; background:#FFFFFF;" id="chartdiv">
</div>
<br>
<table cellspacing='0' align='center' class='table_design' id="datos" >
            <thead>
               <th>
                   N°
                </th>
                <th>
                   Fecha
                </th>
                <th>
                    Consumido
                </th> 
                 <th>
                    Consumido ($)
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
            url:    base_url()+"index.php/vales/historico_json",
            dataType:"json",
             type: "POST",
            data: formu,
            success: function(data){
              console.log(data);

              var label;
                      if(data.length<=30){
                           label="fec";
                      }else{
                            label="row_number";
                            
                        }
                        label="fec";
                        grafico1(data,label);//contructor del grafico
                        tabla1(data) 


                },
            error:function(data){

                

         //        alertify.alert('Error al cargar datos');
          console.log(data);
                }
        });          
        
    }

function  grafico1(chartData, label){

           var color1 = $("#color1").val();

                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = label;
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 0;
                categoryAxis.gridPosition = "start";

                // value
                // in case you don't want to change default settings of value axis,
                // you don't need to create it, as one value axis is created automatically.

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "consumido";
                graph.balloonText = "[[category]]: <b>[[value]] Vales de combustible</b>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.8;
                graph.fillColors = color1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);


                chart.write("chartdiv");
    }   

setTimeout ("reporte();", 2000);
/*//llamada al finalizar la contrucion del archivo  */
</script>
<script src="<?php echo base_url()?>js/views/reporte_consumo.js" type="text/javascript"></script>