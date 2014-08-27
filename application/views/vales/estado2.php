
<br>
<section>
        <h2 >Series de vales</h2>
</section>
        <br>

    
    <script type="text/javascript">  
        $(document).ready(function(){
            $("#report tr:odd").addClass("odd");
            $("#report tr:not(.odd)").hide();
            $("#report tr:first-child").show();            
            $("#report tr.odd").click(function(){
                $(this).next("tr").toggle();             
                
            });
            
        });

        function detalles(id) {
            console.log("Click en "+ id);
                    $.ajax({
                        async:  true, 
                        url:    base_url()+"index.php/vales/detalleVjson/"+id,
                        dataType:"json",
                        success: function(data){
                            //console.log("proceso");
                            console.log(data);
                            var div = '#detalle'+id;
                            tabla1(data,div, id);

                            },
                        error:function(data){
                        console.log("error");
                        }
                    });                         
        }

        function tabla1(data, div, id) {
            
            var html='<table cellspacing="0" align="right" class="table_design" id="reportv'+id+'">'+
                    '<thead>          '+
                    '   <th>          '+
                    '        Inicial  '+
                    '   </th>         '+
                    '    <th>         '+
                    '        Final    '+
                    '   </th>         '+  
                    '  <th>           '+
                    '      Sección    '+
                    '    </th>        '+
                    '    <th>         '+
                    '       Restantes '+
                    '    </th>        '+
                    '    <th>         '+
                    '        Cantidad '+
                    '    </th>        '+
                    ' </thead>        '+
                    '<tbody id="content_table">';
                 for (var i = 0; i < data.length; i++) {
                  
                        html+= '<tr onClick="detalles2('+data[i].id_requisicion_vale+')"> '+
                    '        <td>'+data[i].del+'</td>           '+
                    '        <td>'+data[i].al+'</td>'+
                    '        <td>'+data[i].seccion+'</td>'+
                    '        <td>'+data[i].restante+'</td>'+
                    '        <td>'+data[i].cantidad+'</td>'+
                    '    </tr>'+
                    '    <tr>'+
                    '       <td colspan="6" class="oculto">'+
                    '             <div id="detallev'+data[i].id_requisicion_vale+'">'+
                    '            </div>'+
                    '        </td>'+
                    '    </tr> ';
                        }              
                    html+='</tbody> '+
                '</table>';                                     
                 
            $(div).html(html);
   
            $("#reportv"+id+" tr:odd").addClass("odd");
            $("#reportv"+id+" tr:not(.odd)").hide();
            $("#reportv"+id+" tr:first-child").show();            
            $("#reportv"+id+" tr.odd").click(function(){
                $(this).next("tr").toggle();             
            });

            }
        function detalles2(id) {
            console.log("Click en "+ id);
                        $.ajax({
                        async:  true, 
                        url:    base_url()+"index.php/vales/detalleRjson/"+id,
                        dataType:"json",
                        success: function(data){

                            
                            var div = '#detallev'+id;
                            console.log(div);
                           tabla2(data,div,id);


                            },
                        error:function(data){
                        console.log("nada");
                        console.log(data);
                        }
                    });                         
        }
   

        function tabla2(data, div, id) {
            
            var html='<table cellspacing="0" align="right" class="table_design" id="reportr'+id+'">'+
                    '<thead>          '+
                    '   <th>          '+
                    '        Inicial  '+
                    '   </th>         '+
                    '    <th>         '+
                    '        Final    '+
                    '   </th>         '+  
                    '  <th>           '+
                    '      Fecha    '+
                    '    </th>        '+
                    '  <th>           '+
                    '      N° Factura    '+
                    '    </th>        '+
                    '    <th>         '+
                    '        Cantidad '+
                    '    </th>        '+
                    ' </thead>        '+
                    '<tbody id="content_table">';
                 for (var i = 0; i < data.length; i++) {
                  
                        html+= '<tr onClick="detalles3('+data[i].id_consumo+')"> '+
                    '        <td>'+data[i].del+'</td>           '+
                    '        <td>'+data[i].al+'</td>'+
                    '        <td>'+data[i].fecha+'</td>'+
                    '        <td>'+data[i].factura+'</td>'+
                    '        <td>'+data[i].cantidad+'</td>'+
                    '    </tr>'+
                    '    <tr>'+
                    '       <td colspan="6" class="oculto">'+
                    '             <div id="detaller'+data[i].id_consumo+'">'+
                    '            </div>'+
                    '        </td>'+
                    '    </tr> ';
                        }              
                    html+='</tbody> '+
                '</table>';                                     
                 
            $(div).html(html);
   
            $("#reportr"+id+" tr:odd").addClass("odd");
            $("#reportr"+id+" tr:not(.odd)").hide();
            $("#reportr"+id+" tr:first-child").show();            
            $("#reportr"+id+" tr.odd").click(function(){
                $(this).next("tr").toggle();             
                
            });

            }
                function detalles3(id) {
            console.log("Click en "+ id);
                        $.ajax({
                        async:  true, 
                        url:    base_url()+"index.php/vales/detalleFjson/"+id,
                        dataType:"json",
                        success: function(data){

                            
                            var div = '#detaller'+id;
                            console.log(div);
                           tabla3(data,div,id);


                            },
                        error:function(data){
                        console.log("nada");
                        console.log(data);
                        }
                    });                         
        }
   

        function tabla3(data, div, id) {
            
            var html='<table cellspacing="0" align="right" class="table_design" id="reportf'+id+'">'+
                    '<thead>          '+
                    '   <th>          '+
                    '        Inicial  '+
                    '   </th>         '+
                    '    <th>         '+
                    '        Final    '+
                    '   </th>         '+  
                    '  <th>           '+
                    '    Aplicado en  '+
                    '    </th>        '+
                    '    <th>         '+
                    '        Cantidad '+
                    '    </th>        '+
                    ' </thead>        '+
                    '<tbody id="content_table">';
                 for (var i = 0; i < data.length; i++) {
                  
                        html+= 
                    '        <td>'+data[i].del+'</td>           '+
                    '        <td>'+data[i].al+'</td>'+
                    '        <td>'+data[i].en+'</td>'+
                    '        <td>'+data[i].cantidad+'</td>'+
                    '    </tr>'+
                    '    <tr>'+
                    '       <td colspan="6" class="oculto">'+
                    '             <div id="detallef'+i+'">'+
                    '            </div>'+
                    '        </td>'+
                    '    </tr> ';
                        }              
                    html+='</tbody> '+
                '</table>';                                     
                 
            $(div).html(html);
   
            $("#reportf"+id+" tr:odd").addClass("odd");
            $("#reportf"+id+" tr:not(.odd)").hide();
            $("#reportf"+id+" tr:first-child").show();            
            $("#reportf"+id+" tr.odd").click(function(){
                $(this).next("tr").toggle();             
                
            });

            }

    </script>        

        <table cellspacing="0" align="center" class="table_design " id="report">
                    <thead>
                        <th>
                            Inicial
                        </th>
                        <th>
                            Final
                        </th>      
                        <th>
                            Valor 
                        </th> 
                         <th>
                            Fuente 
                        </th> 
                          <th>
                            Gasolinera
                        </th> 
                        <th>
                            Restantes
                        </th>                  
                          <th>
                            Cantidad
                        </th>              
                    </thead>
                    <tbody id="content_table">
                 <?php
                    
                    foreach($ne as $val) { ?>
                        <tr onClick="detalles(<?php echo $val['id_vale'] ?>)"> 
                            <td><?php echo $val['inicial'] ?></td>
                            <td><?php echo $val['final'] ?></td>
                            <td>$<?php echo $val['valor'] ?></td>
                            <td><?php echo $val['fuente'] ?></td>
                            <td><?php echo $val['gasolinera'] ?></td>
                            <td><?php echo $val['restante'] ?></td>
                            <td><?php echo $val['cant'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="7" class="oculto">
                                <div id="detalle<?php echo $val['id_vale'] ?>">

                                </div>
                            </td>
                        </tr>
                <?php $i++;} ?> 

                    </tbody>
                </table>
