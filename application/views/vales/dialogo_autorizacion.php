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
                    $refuerzo=$datos->refuerzo;
                }
            
                echo "Nombre: <strong>".$nombre."</strong> <br>
                Sección: <strong>".$seccion."</strong> <br>
                ID Requisicion: <strong>".$id_requisicion."</strong> <br>
                Fecha y hora de Solicitud: <strong>".$fecha."</strong> <br>
                Cantidad Solicitada: <strong>".$cantidad."</strong> <br>
                Justificacion: <strong>".$justificacion."</strong> <br>
                Refuerzo: <strong>"; echo ($refuerzo==1)?"Si":"No"; echo "</strong> <br></fieldset>

                 <br />";
    ?>
        
    
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
    <fieldset>
        <legend align='left'>Informaci&oacute;n  Adicional</legend>
        <?php 
            if($v['cantidad_restante']>0){?>
                
                <label for="asignar" id="lasignar" class="tam-2">Cantidad a Entregar</label>
                        <?php 

                    if($refuerzo==1){?>
                            
                                <input class="tam-1" id='asignar' tabindex='2' name='asignar' type="text"/>
                                
                            <?php } else {?>
                                <input  id='asignar' tabindex='2' name='asignar'  type="hidden" value="<?php echo $cantidad;?>"/>
                                <strong>: <?php echo $cantidad;?></strong> <br>
                            <?php } ?>
                            
            
        <?php 
            }
            else {
                echo "<strong>En estos momentos no hay vales disponibles</strong>";
            }
        ?>
        <label for="observacion" id="lobservacion" class="label_textarea">Observaciones</label>
        <textarea class='tam-4' id='observacion' tabindex='2' name='observacion'></textarea>

    </fieldset>
    <p style='text-align: center;'>
        <?php 
            if($v['cantidad_restante']>0){?>
                <button type="submit"  id="aprobar" class="button tam-1 boton_validador"  onclick="Enviar(2)">Autorizar</button>
        <?php 
            }
        ?>
        <button  type="submit" id="denegar" class="button tam-1 boton_validador"  onclick="Enviar(0)">Denegar</button>
    </p>

</form>

 <script type="text/javascript">
       $(document).ready(function(){  

    <?php if($v['cantidad_restante']>0&& $refuerzo==1) {?>

            
                    $("#asignar").validacion({
                        ent: true,
                        numMin: 0,
                        numMax: <?php echo $v['cantidad_restante'];?>
                    });

        <?php }?>

    $( "#boton1" ).click(function() {
        $('#autos').toggle("blind");
    });
    $("#observacion").validacion({
        req: false,
        lonMin: 10
    });
     
        });
        </script>