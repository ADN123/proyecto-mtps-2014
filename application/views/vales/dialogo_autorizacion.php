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
                    $fechaVB =$datos->fecha_visto_bueno;
                    $visto_bueno =ucwords($datos->visto_bueno);
                }
            
                echo "
                ID Requisicion: <strong>".$id_requisicion."</strong> <br>
                Nombre: <strong>".$nombre."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                Fecha y hora de Solicitud: <strong>".$fecha."</strong> <br>
                Cantidad Solicitada: <strong>".$cantidad."</strong> <br>
                Justificacion: <strong>".$justificacion."</strong> <br>
                Cantidad a Entregar: <strong>".$cantidadE."</strong> <br>
                Fecha y Hora de Visto Bueno: <strong>".$fechaVB."</strong> <br>
                Visto Bueno por: <strong>".$visto_bueno."</strong> <br>
                </fieldset>
    <br />";
	?>
    	
	<?php
            
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
            echo "
            </tbody>
        </table>
    </fieldset>";
    ?>
    <p style='text-align: center;'>
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(3)">Autorizar</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador"  onclick="Enviar(0)">Denegar</button>
    </p>
</form>
