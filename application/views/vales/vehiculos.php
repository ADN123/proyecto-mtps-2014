        <table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            Placa
                        </th>
                        <th>
                            Marca
                        </th>  
                        <th>
                            Modelo
                        </th>                  
                        <th width="40">
                            Acci&oacute;n
                        </th>
                    </thead>
                    <tbody id="content_table">
                 <?php
                    foreach($vehiculos as $val) { ?>
                        <tr> 
                            <td><?php echo $val['placa'] ?></td>
                            <td><?php echo $val['marca'] ?></td>
                            <td><?php echo $val['modelo'] ?></td>
                            <td><input type="checkbox"  name="values[]"  value="<?php echo $val['id_vehiculo'] ?>" /> </td>
                        </tr>
                <?php } ?> 

                    </tbody>
                </table>
                