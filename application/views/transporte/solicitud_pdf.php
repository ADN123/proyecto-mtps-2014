<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="img/mtps.jpg" />
            </td>
            <td align="right">
                <h3>SOLICITUD DE USO DE VEHICULO</h3>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            	<strong id="titulo">DATOS DEL SOLICITANTE</strong>
            </td>
        </tr>
  	</table>
    <table align="center" class="tabla" cellspacing="0">    
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
        	<td align="left">
            </td>
        	<td align="left">
            	<table align="right">
                	<tr>
                    	<td width="125">
                        </td>
                    	<td class="titu" align="center" width="90">
                        	SEG&Uacute;N SOLICITADO
                        </td>
                    	<td class="titu" align="center" width="90">
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
                        	<strong><?php ?></strong>
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
                        	<strong><?php  ?></strong>
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
                        	<strong><?php ?></strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Departamento: <strong><?php if($info_empleado['nivel_2']!="") echo $info_empleado['nivel_2']."."; else echo "_____________________________________________________________________________________________________";?></strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: <strong><?php if($info_empleado['nivel_1']!="") echo $info_empleado['nivel_1']."."; else echo "____________________________________________________________________________________________________________";?></strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acompa&ntilde;antes: 
                <strong>
					<?php 
                        $i=0;
						$cadena="";
                        foreach($acompanantes as $val) {
							$x=substr(ucwords($val->nombre), 0, -1);
                            if($i==1)
                                $cadena.=", ";
                            $cadena.=$x;
                            $i=1;
                        }
						echo $cadena;
                        if($i==1 && $info_solicitud['acompanante']!="")
                            echo ", ";
                        echo $info_solicitud['acompanante'];
						if($i==1 || $info_solicitud['acompanante']!="")
							echo ".";
						else
							echo "Ninguno.";
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
                            echo "Ver atr&aacute;s.";
                        }
                        else {
                            foreach($destinos as $val) {
                                echo $val->destino.", ".ucwords($val->municipio).".";
                            }
                        }
                    ?>
                </strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Misi&oacute;n encomendada:  
                <strong>
					<?php 
                        if(count($destinos)>1) {
                            echo "Ver atr&aacute;s.";
                        }
                        else {
                            foreach($destinos as $val) {
                                echo $val->mision.".";
                            }
                        }
                    ?>
                </strong>
        	</td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
        	<td align="center" style="width:50%">
            	f. _____________________________________________<br />
            	Solicitado Por <strong><?php echo ucwords($info_solicitud['nombre']) ?></strong><br />&nbsp;
            </td>
        	<td align="center" style="width:50%">
            	f. _____________________________________________<br />
            	Autorizado Por <strong><?php echo ucwords($info_solicitud['nombre2']) ?></strong><br />Jefe de Departamento o Sección
            </td>
        </tr>
    </table>
    <table align="center" class="tabla2" cellspacing="0">
    	<tr><td colspan="2">&nbsp;</td></tr>
    	<tr>
        	<td align="center" style="width:50%">
            	<strong>USO EXCLUSIVO SERVICIOS GENERALES</strong>
            </td>
        	<td align="center" style="width:50%">
            	<strong>USO EXCLUSIVO PORTERO</strong>
            </td>
        </tr>
    </table>
</body>
</html>

























