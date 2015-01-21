<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/199s9/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if($base){
     echo '<link href="'.base_url().'/css/style-base.css" rel="stylesheet" type="text/css" />';
 } ?>
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="<?php if($base){ echo base_url();} ?>img/mtps_report2.jpg" width="175" height="106" />
            </td>
            <td align="right">
                <h3>REPORTE DE VALES DE COMBUSTIBLE</h3>
                <h6>Fecha: <strong><?php echo date('d-m-Y') ?></strong> </h6>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong id="titulo">Liquidacion del mes de <?php echo $mesn ?></strong>
            </td>
        </tr>
  	</table>
    <br>
    <table align="center"   cellspacing="0" class='table_design'>    
        <thead>
        <tr>
            <th>Oficina</th>
            <th>Fecha<br> Liquidación</th>
            <th>Cuota</th>
            <th>Sobrante  <br><?php echo $mesn1;?></th>
            <th>Entregado <br><?php echo $mesn;?></th>  
            <th>Disponibles</th>
            <th>Consumidos<br> <?php echo $mesn;?></th>
            <th>Sobrantes<br>  <?php echo $mesn;?> </th>                                                    
        </tr>
        </thead>
        <tbody> 
    <?php 

    foreach ($l as $key ) {
        $s1+=$key['anterior'];
        $s2+=$key['entregado'];
        $s3+=$key['disponibles'];
        $s4+=$key['consumido'];
        $s5+=$key['sobrante'];
    ?>          
        <tr>
            <td><?php echo $key['seccion']; ?></td>
            <td><?php echo $key['fecha']; ?></td>
            <td><?php echo $key['cuota']; ?></td>
            <td><?php echo $key['anterior']; ?></td>
            <td><?php echo $key['entregado']; ?></td>
            <td><?php echo $key['disponibles']; ?></td>
            <td><?php echo $key['consumido']; ?></td>
            <td><?php echo $key['sobrante']; ?></td>                                 
        </tr>
    <?php 
            }
        ?>
         <tr>
            <td><strong>TOTAL</strong></td>
            <td></td>
            <td></td>
            <td> <strong><?php echo $s1;?></strong></td>
            <td> <strong><?php echo $s2;?></strong></td>
            <td> <strong><?php echo $s3;?></strong></td>
            <td> <strong><?php echo $s4;?></strong></td>
            <td> <strong><?php echo $s5;?></strong></td>                             
        </tr>          
    </tbody>
    </table>
    
</body>
        <br><br>
        <p style="width:650px; margin:auto;"> <?php ?></p>

</html>