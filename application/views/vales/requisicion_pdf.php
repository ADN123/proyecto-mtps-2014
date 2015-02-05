 <?php 
           // echo"<pre>"; print_r($e); echo "</pre>";
                foreach($d as $datos)
                {
                    $nombre=ucwords($datos->nombre);
                    $seccion=ucwords($datos->seccion);
                    $fecha=$datos->fecha;
                    $observaciones=$datos->observaciones;
                    $cantidad=$datos->cantidad_solicitada;
                    $justificacion=$datos->justificacion;
                    $id_requisicion=$datos->id_requisicion;
                    $cantidadE =$datos->cantidad_entregado;
                    $fuente_fondo=$datos->fuente_fondo;
                    $fechaVB =$datos->fecha_visto_bueno;
                    $visto_bueno =ucwords($datos->visto_bueno);
                    $estado =$datos->estado;
                    $fecha_autorizado =$datos->fecha_autorizado;
                    $autorizado =ucwords($datos->autorizado);
                    $fecha_entrega =$datos->fecha_entregado;
                    $entrego =ucwords($datos->entrego);
                    $correlativo= $datos->correlativo;
                    

                }

           ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:800px;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php if($base){ echo base_url();} ?>img/mtps_report2.jpg" width="175" height="106" />

            </td>
            <td align="right">
                <h3>REQUISICIÓN DE VALES DE COMBUSTIBLE</h3>
                <h6>ID Requisición: <strong><?php echo $id_requisicion ?></strong> </h6>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong id="titulo">CONTROL DE ENTREGA DE COMBUSTIBLE</strong>
            </td>
        </tr>
  	</table>
    <br><br>


    <table cellspacing='0' align='center' class="table_design">    
    <thead>

        <tr>
            <th colspan="2">
                DATOS GENERALES

            </th>
        </tr>
    </thead>

        <tr>
           <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solicitante: <strong><?php echo $nombre;?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: <strong><?php echo $seccion;?></strong>
            </td>
        </tr>
        <tr>
        	<td >
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora y Fecha de Solicitud:       	<strong><?php echo $fecha;?></strong>
            </td>
           <td >
                   Cantidad Solicitada:           <strong><?php echo $cantidad;?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificaci&oacute;n: <strong><?php echo $justificacion;?></strong>
            </td>
        </tr>
    </table>
     <br><br>

    <table cellspacing='0' align='center' class="table_design">    
    <thead>

        <tr>
            <th colspan="2">
                DATOS DE AUTORIZACIÓN

            </th>
        </tr>
    </thead>

        <tr>
           <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autorizado por: <strong><?php echo $visto_bueno;?></strong>
            </td>
        </tr>
        <tr>
            <td >
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora y Fecha de Autorizacion:           <strong><?php echo $fechaVB;?></strong>
            </td>
           <td >
                   Cantidad Autorizada:           <strong><?php echo $cantidadE;?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observaciones: <strong><?php echo $observaciones;?></strong>
            </td>
        </tr>
    </table>
<br><br>
    <table cellspacing='0' align='center' class='table_design'>
            <thead>
                <tr>
                <th colspan="2">
                    DATOS DE ENTREGA
                </th>
                </tr>
            </thead>
                <tr>
                   <td colspan="2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entregado por: <strong><?php echo $visto_bueno;?></strong>
                    </td>
                </tr>
                <tr>
                    <td >
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora y Fecha de Entrega:           <strong><?php echo $fechaVB;?></strong>
                    </td>
                   <td >
                     
                    </td>
                </tr>
               <tr>
                   <td colspan="2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recibido por: 
                    </td>
                </tr>
            <thead>
            <tr>
                <th>
                    Numero inicial
                </th>
                <th>
                    Numero final
                </th>
            </tr>
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


    <table  style=" border-collapse: separate;   border-spacing:  50px;" align='center' class="table_design2">    
        <tr>
            <td  align="center">_______________________________<br>Solicitante</td>
            <td  align="center">_______________________________<br>Autorizado</td>
        </tr>
        <tr>
            <td  align="center">_______________________________<br>Recibido</td>
            <td  align="center">_______________________________<br>Entregado</td>
        </tr>

    </table>

<br><br>
     <table cellspacing='0' align='center' class='table_design'>
                <thead>
                <tr>
                    <th colspan="4">
                        UTILIZACION DE VALES
                    </th>
                 </tr>
                  <tr>
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
                 </tr>
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

</body>
</html>

























