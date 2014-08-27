
    
    <script type="text/javascript">  
        $(document).ready(function(){
            $("#report2 tr:odd").addClass("odd");
            $("#report2 tr:not(.odd)").hide();
            $("#report2 tr:first-child").show();            
            $("#report2 tr.odd").click(function(){
                $(this).next("tr").toggle();
               
                
            });
            
        });

        function detalles(id) {
            console.log("Click en "+ id);
            $('#detalle2'+id).html("detalles del div en la fila "+id)
        }
    </script>        

        <table cellspacing="0" align="center" class="table_design" id="report2">
                    <thead>
                        <th>
                            Inicial
                        </th>
                        <th>
                            Final
                        </th>  
                        <th>
                            Sección
                        </th>                  
                        <th>
                            Cantidad 
                        </th> 
                    </thead>
                    <tbody id="content_table">
                 <?php
                    $i=0;
                    foreach($v as $val) { ?>
                        <tr onClick="detalles(<?php echo "$i" ?>)"> 
                            <td><?php echo $val['del'] ?></td>
                            <td><?php echo $val['al'] ?></td>
                            <td><?php echo $val['seccion'] ?></td>
                            <td><?php echo $val['cantidad'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="oculto">
                                <div id="detalle<?php echo $i; ?>">

                                </div>
                            </td>
                        </tr>
                <?php $i++;} ?> 
                
                    </tbody>
                </table>


