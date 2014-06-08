<form id='form' action="<?php echo base_url()?>index.php/vales/dialogo_autorizacion" method='post'>
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
                }
            
                echo "Nombre: <strong>".$nombre."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                ID Requisicion: <strong>".$id_requisicion."</strong> <br>
                Fecha de Solicitud: <strong>".$fecha."</strong> <br>
                Cantidad Solicitada: <strong>".$cantidad."</strong> <br>
                Justificacion: <strong>".$justificacion."</strong> <br></fieldset>
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
        <button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(3)">Aprobar</button>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador"  onclick="Enviar(0)">Denegar</button>
    </p>
</form>
