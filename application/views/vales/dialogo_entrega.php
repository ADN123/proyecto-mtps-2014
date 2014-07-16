    <form id='form' action="<?php echo base_url()?>index.php/vales/guardar_entrega" method='post'>
    <input type='hidden' id='resp' name='resp' />
    <input type='hidden' name='ids' value="<?php echo $id?>" />

    <fieldset>      
        <legend align='left'>Información de la Solicitud</legend>
            <?php 

                foreach($d as $datos)
                {
                    $nombre=ucwords($datos->nombre);
                    $seccion=ucwords($datos->seccion);
                    $fecha=$datos->fecha;
                    $cantidad=$datos->cantidad_solicitada;
                    $justificacion=$datos->justificacion;
                    $id_requisicion=$datos->id_requisicion;
                    $fuente_fondo=$datos->fuente_fondo;
                    $fechaVB =$datos->fecha_visto_bueno;
                    $visto_bueno =ucwords($datos->visto_bueno);
                    $estado =$datos->estado;
                    $cantidad_entregado=$datos->cantidad_entregado;

                }
                $correlativo= $c->correlativo;

                echo "
                ID Requisicion: <strong>".$id_requisicion."</strong> <br>
                Solicitante: <strong>".$nombre."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                Fecha y hora de Solicitud: <strong>".$fecha."</strong> <br>
                Cantidad Solicitada: <strong>".$cantidad."</strong> <br>
                Fuente de Fondo: <strong>".$fuente_fondo."</strong> <br>
                Correlativo: <strong>".$correlativo."</strong> <br>
                Justificacion: <strong>".$justificacion."</strong> <br>
                </fieldset>
    <br />";

echo "

    <fieldset>      
        <legend align='left'>Autorización</legend>
        Autorizado por: <strong>".$visto_bueno."</strong> <br>
        Cantidad a Entregar: <strong>".$cantidad_entregado."</strong> <br>
        Fecha y Hora de Autorización: <strong>".$fechaVB."</strong> <br>  
         ";    ?>
    </fieldset>
    <br />
    

 
    <fieldset>      
        <legend align='left'>Vales a entregar</legend>
        
        <table cellspacing='0' align='center' class='table_design'>
            <thead>
                <th>
                    Numero inicial
                </th>
                <th>
                    Numero final
                </th>
            </thead>
            <tbody>
            <?php

                foreach($e as $r)
                {
                    echo "<tr><td align='center'>".$r["inicial"]."</td>";
                    echo "<td align='center'>".$r["final"]."</td></tr>";
                }
                   ?>
        
            </tbody>
        </table>
    </fieldset>
    <br />    
    <br>
    <fieldset>
        <legend align='left'> Vehiculos &nbsp;&nbsp;<img id="boton1"  src="<?php echo base_url()?>img/lupa.gif"/> </legend>
      

        <div id='autos' style="display:none">

        <table cellspacing='0' align='center' class='table_design'>
            <thead>
                <th>
                    Placa
                </th>
                <th>
                    Clase
                </th>
                <th>
                    Marca
                </th>
                <th>
                    Fuente de Fondo
                </th>
            </thead>
            <tbody>
            <?php

                foreach($f as $r)
                {
                    echo "<tr><td>".$r->placa."</td>";
                    echo "<td>".$r->clase."</td>";
                    echo "<td>".$r->marca."</td>";
                    echo "<td>".$r->fondo."</td></tr>";
                }
                   ?>
        
            </tbody>
        </table>
    </div>
    </fieldset>
     <p style='text-align: center;'>
            <input  id='asignar' tabindex='2' name='correlativo'  type="hidden" value="<?php echo $correlativo;?>"/>
            <input  id='asignar' tabindex='2' name='asignar'  type="hidden" value="<?php echo $cantidad;?>"/>
                <button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)">Entregar</button>        
    </p>
    <input type='hidden' name='asignar' value="<?php echo $cantidad_entregado; ?>" />
        <input type='hidden' name='correlativo' value="<?php echo $correlativo; ?>" />
</form>
<script type="text/javascript">
$( "#boton1" ).click(function() {
        $('#autos').toggle("blind");
    });

</script>