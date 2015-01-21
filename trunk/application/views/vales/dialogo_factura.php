    <form id='form' action="#" method='post'>
    <fieldset>      
        <legend align='left'>General</legend>
            <?php 
           // echo"<pre>"; print_r($e); echo "</pre>";
                extract($g);
            
                echo "
                ID Consumo: <strong>".$id_consumo."</strong> <br>
                Numero : <strong>".$factura."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                Fecha : <strong>".$fecha."</strong> <br>
                Precio super : <strong>".$super."</strong> <br>
                Precio regular : <strong>".$regular."</strong> <br>
                Precio diesel : <strong>".$diesel."</strong> <br>
                Vales utilizados: <strong>".$cant."</strong> <br>
                </fieldset>
    <br />"; ?>
   
    <br>
    <fieldset>
        <legend align='left'> Detalle &nbsp;&nbsp;<img id="boton1"  src="<?php echo base_url()?>img/lupa.gif"/> </legend>
      

        <div id='autos'>

        <table cellspacing='0' align='center' class='table_design'>
            <thead>
                <th>
                    Aplicado en
                </th>
                <th>
                    Cantidad
                </th>
                <th>
                    Vales
                </th>
               <th>
                    Actividad 
                </th>
            </thead>
            <tbody>
            <?php

                foreach($d as $r)
                {
                    echo "<tr><td align='center'>".$r["en"]."</td>";
                    echo "<td align='center'>".$r["cantidad"]."</td>";
                    echo "<td align='center'>".$r["del"]." - ".$r["al"]."</td>";
                    echo "<td align='center'>".$r["actividad"]."</td></tr>";
                }
                   ?>
        
            </tbody>
        </table>
    </div>
    </fieldset>
 

</form>
<script type="text/javascript">
$( "#boton1" ).click(function() {
        $('#autos').toggle("blind");
    });

</script>