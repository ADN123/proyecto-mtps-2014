        <table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            nombre
                        </th>
                        <th>
                            descripcion
                        </th>  
                        <th width="40">
                            Acci&oacute;n
                        </th>
                    </thead>
                    <tbody id="content_table">
                 <?php
                    foreach($otros as $val) { ?>
                        <tr> 
                            <td><?php echo $val['nombre'] ?></td>
                            <td><?php echo $val['descripcion'] ?></td>
                            <td><input type="checkbox"  name="values2[]"  value="<?php echo $val['id_herramienta'] ?>"  onChange="marcados()" class="cheke2"/> </td>
                        </tr>
                <?php } ?> 

                    </tbody>
                </table>
                