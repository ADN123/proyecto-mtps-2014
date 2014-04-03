<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Solicitud de Transporte - PDF</title>
    <style>
		body {
			font-family: Arial, Helvetica, sans-serif;
		}
		.tabla, .titu {
			border: 1px solid #000;
		}
		.tabla tr {
			height: 25px;
		}
	</style>
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" style="width:40%;">
                <img src="img/mtps.jpg" />
            </td>
            <td align="right">
                <h3>SOLICITUD DE USO DE VEHICULO</h3>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong style="font-size:13px">DATOS DEL SOLICITANTE</strong>
            </td>
        </tr>
  	</table>
    <table align="center" class="tabla" cellspacing="0" style="width:100%; font-size: 12px">    
        <tr>
        	<td colspan="2" align="center">
            	<?php 
					switch(date('m')) {
						case 1: 
							$mes="Enero";
							break;
						case 2: 
							$mes="Febreo";
							break;
						case 3: 
							$mes="Marzo";
							break;
						case 4: 
							$mes="Abril";
							break;
						case 5: 
							$mes="Mayo";
							break;
						case 6: 
							$mes="Junio";
							break;
						case 7: 
							$mes="Julio";
							break;
						case 8: 
							$mes="Agosto";
							break;
						case 9: 
							$mes="Septiembre";
							break;
						case 10: 
							$mes="Octubre";
							break;
						case 11: 
							$mes="Noviembre";
							break;
						case 12: 
							$mes="Diciembre";
							break;
					}
				?>
            	San Salvador, <?php echo date('d')?> de <?php echo $mes." ".date('Y')?> 
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="left">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NR: <strong><?php echo $info_empleado['nr'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
            	Nombre: <strong><?php echo ucwords($info_solicitud['nombre']) ?></strong>
            </td>
        </tr>
        <tr>
        	<td align="left" style="width:50%;">
            </td>
        	<td align="left">
            	<table>
                	<tr>
                    	<td style="width: 50%;">
                        </td>
                    	<td class="titu" align="center">
                        	SEG&Uacute;N SOLICITADO
                        </td>
                    	<td class="titu" align="center">
                        	DATOS REALES
                        </td>
                    </tr>
                	<tr>
                    	<td align="right">
                        	Fecha de la Misi&oacute;n:
                        </td>
                    	<td align="center">
                        	<strong><?php echo $info_solicitud['fecha_mision'] ?></strong>
                        </td>
                    	<td align="center">
                        	<?php  ?>
                        </td>
                    </tr>
                	<tr>
                    	<td align="right">
                        	Hra. Salida a Misi&oacute;n:
                        </td>
                    	<td align="center">
                        	<strong><?php echo $info_solicitud['hora_salida'] ?></strong>
                        </td>
                    	<td align="center">
                        	<?php  ?>
                        </td>
                    </tr>
                	<tr>
                    	<td align="right">
                        	Hra. Regreso a Misi&oacute;n:
                        </td>
                    	<td align="center">
                        	<strong><?php echo $info_solicitud['hora_entrada'] ?></strong>
                        </td>
                    	<td align="center">
                        	<?php  ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Departamento: <strong><?php echo $info_empleado['nivel_2'] ?></strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: <strong><?php echo $info_empleado['nivel_1'] ?></strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acompa&ntilde;antes: 
                <strong>
					<?php 
                        $i=0;
                        foreach($acompanantes as $val) {
                            if($i==1)
                                echo ", ";
                            echo ucwords($val->nombre);
                            $i=1;
                        }
                        if($i==1 && $info_solicitud['acompanante']!="")
                            echo ", ";
                        echo $info_solicitud['acompanante'];
                    ?>
                </strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lugar de destino: 
                <strong>
					<?php 
                        if(count($destinos)>1) {
                            echo "<strong>Ver atr&aacute;s</strong>";
                        }
                        else {
                            foreach($destinos as $val) {
                                echo $val->destino.". ". $val->municipio;
                            }
                        }
                    ?>
                </strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Misi&oacute;n encomendada: <strong><?php echo $info_solicitud['mision_encomendada'] ?></strong>
            </td>
        </tr>
        <tr style="height: 125px;">
        	<td align="center">
            	f. _____________________________________________<br />
            	Solicitado Por <strong><?php echo ucwords($info_solicitud['nombre']) ?></strong>
            </td>
        	<td align="center">
            	f. _____________________________________________<br />
            	Autorizado Por <strong><?php echo ucwords($info_solicitud['nombre2']) ?></strong><br />
            </td>
        </tr>
    </table>
    <table align="center" class="tabla" cellspacing="0" style="width:100%; font-size: 12px">
    	<tr>
        	<td>
            	<strong>USO EXCLUSIVO SERVICIOS GENERALES</strong>
            </td>
        	<td>
            	<strong>USO EXCLUSIVO PORTERO</strong>
            </td>
        </tr>
    </table>
</body>
</html>

























