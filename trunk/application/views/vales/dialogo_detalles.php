    <form id='form' action="<?php echo base_url()?>index.php/vales/guardar_autorizacion" method='post'>
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
                    $cantidad=$datos->cantidad;
                    $justificacion=$datos->justificacion;
                    $id_requisicion=$datos->id_requisicion;
                    $cantidadE =$datos->entregado;
                    $fuente_fondo=$datos->fuente_fondo;
                    $fechaVB =$datos->fecha_visto_bueno;
                    $visto_bueno =ucwords($datos->visto_bueno);
                    $estado =$datos->estado;
                    $fecha_autorizado =$datos->fecha_autorizado;
                    $autorizado =ucwords($datos->autorizado);
                }
            
                echo "
                ID Requisicion: <strong>".$id_requisicion."</strong> <br>
                Solicitante: <strong>".$nombre."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                Fecha y hora de Solicitud: <strong>".$fecha."</strong> <br>
                Cantidad Solicitada: <strong>".$cantidad."</strong> <br>
                Fuente de Fondo: <strong>".$fuente_fondo."</strong> <br>
                Justificacion: <strong>".$justificacion."</strong> <br>
                </fieldset>
    <br />";
    if ($estado>=2) {
    echo "
    
            <fieldset>      
                <legend align='left'>Visto Bueno</legend>
                Visto Bueno por: <strong>".$visto_bueno."</strong> <br>
                Cantidad a Entregar: <strong>".$cantidadE."</strong> <br>
                Fecha y Hora de Visto Bueno: <strong>".$fechaVB."</strong> <br>          
            </fieldset>
            <br />
            ";
    }
    if ($estado>=3) {
    echo "
    
            <fieldset>      
                <legend align='left'>Autorización</legend>
                Autorizado por: <strong>".$autorizado."</strong> <br>
                Fecha y Hora de autorización: <strong>".$fecha_autorizado."</strong> <br>          
            </fieldset>
            <br />
            ";
    }
            
    echo "
	<br>
    <fieldset>
        <legend align='left'>Vehiculos</legend>
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
                ";
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
    </fieldset>";
 

</form>
