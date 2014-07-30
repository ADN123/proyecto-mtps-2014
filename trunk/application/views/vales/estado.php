<?php if($g) { ?>
<br>
<section>
        <h2 >Vales No Entregados</h2>
</section>
        <br>

        <table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            Inicial
                        </th>
                        <th>
                            Final
                        </th>  
                        <th>
                            Restantes
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
                    </thead>
                    <tbody id="content_table">
                 <?php
                    foreach($ne as $val) { ?>
                        <tr> 
                            <td><?php echo $val['inicial'] ?></td>
                            <td><?php echo $val['final'] ?></td>
                            <td><?php echo $val['restante'] ?></td>
                            <td>$<?php echo $val['valor'] ?></td>
                            <td><?php echo $val['fuente'] ?></td>
                            <td><?php echo $val['gasolinera'] ?></td>
                        </tr>
                <?php } ?> 

                    </tbody>
                </table>
<?php } // fin if ?> 

<section>
        <h2>Vales Entregados</h2>
</section>     
<br>
        <table cellspacing="0" align="center" class="table_design">
                    <thead>
                        <th>
                            Inicial
                        </th>
                        <th>
                            Final
                        </th>  
                        <th>
                            Restantes
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
    <?php if($s) { ?>                        
                        <th>
                            Sección
                        </th> 
    <?php } // fin if ?> 
                    </thead>
                    <tbody id="content_table">
                 <?php
                    foreach($e as $val) { ?>
                        <tr> 
                            <td><?php echo $val['inicial'] ?></td>
                            <td><?php echo $val['final'] ?></td>
                            <td><?php echo $val['restante'] ?></td>
                            <td>$<?php echo $val['valor'] ?></td>
                            <td><?php echo $val['fuente'] ?></td>
                            <td><?php echo $val['gasolinera'] ?></td>
    <?php if($s) { ?>                        
                            <td><?php echo $val['seccion'] ?></td>
    <?php } // fin if ?> 
                        
                <?php } ?> 

                    </tbody>
                </table>
    <?php if(!$g) { ?>

            <br><br><br><br><br><br><br><br><br>
    <?php } ?> 