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
					$fec=explode("/",$info_solicitud['fecha_mision']);
					switch($fec[1]) {
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
					
					switch($id_seccion)
					{
						case 52:
						$depto="Ahuachapán";
						break;
						case 53:
						$depto="Cabañas";
						break;
						case 54:
						$depto="Chalatenango";
						break;
						case 55:
						$depto="Cuscatlán";
						break;
						case 56:
						$depto="La Libertad";
						break;
						case 57:
						$depto="La Unión";
						break;
						case 58:
						$depto="Morazán";
						break;
						case 59:
						$depto="San Vicente";
						break;
						case 60:
						$depto="Sonsonate";
						break;
						case 61:
						$depto="Usulután";
						break;
						case 64:
						$depto="Zacatecoluca";
						break;
						case 65:
						$depto="San Miguel";
						break;
						case 66:
						$depto="Santa Ana";
						break;
						default:
						$depto="San Salvador";
						break;
					}
					
				?>
            	<?php echo $depto; ?>, <?php echo $fec[0]?> de <?php echo $mes." ".$fec[2]?> 
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
                        	<strong><?php echo $salida_entrada_real['fecha_mision'] ?></strong>
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
                        	<strong><?php echo $salida_entrada_real['hora_salida']?></strong>
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
                        	<strong><?php echo $salida_entrada_real['hora_entrada'] ?></strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Departamento: <strong><?php if($info_empleado['nivel_2']!="") echo $info_empleado['nivel_2']."."; else echo "_____________________________________________________________________________________________________________________";?></strong>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secci&oacute;n: <strong><?php if($info_empleado['nivel_1']!="") echo $info_empleado['nivel_1']."."; else echo "____________________________________________________________________________________________________________________________";?></strong>
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
        <!--<tr>
        	<td align="center" style="width:50%">
            	f. _____________________________________________<br />
            	Solicitado Por <strong><?php echo ucwords($info_solicitud['nombre']) ?></strong><br />&nbsp;
            </td>
        	<td align="center" style="width:50%">
            	f. _____________________________________________<br />
            	Autorizado Por <strong><?php echo ucwords($info_solicitud['nombre2']) ?></strong><br />Jefe de Departamento o Sección
            </td>
        </tr>-->
        <tr>
        	<td colspan="2" align="center">
            	Aprobado por <strong><?php echo ucwords($info_solicitud['nombre2']) ?></strong><br /><?php echo ucwords($info_empleado2['nominal']) ?>
            </td>
        </tr>
    </table>
    <table align="center" class="tabla2" cellspacing="0">
    	<tr><td colspan="2">&nbsp;</td></tr>
    	<tr>
        	<td align="center" style="width:43%">
            	<strong>USO EXCLUSIVO SERVICIOS GENERALES</strong>
                 <table align="center" class="tabla" cellspacing="0" style="width:1000px;">
                 	<tr>
                    	<td style="border-bottom: 1px solid #000;" align="center">
                        	<strong>AUTORIZACION  DE VEHICULO A  MISION  OFICIAL</strong>
                        </td>
                    </tr>
        			<tr><td>&nbsp;</td></tr>
                 	<tr>
                    	<td>
                        	Motorista: <strong><?php echo ucwords($motorista_vehiculo['nombre']) ?></strong>
                        </td>
                    </tr>
                 	<tr>
                    	<td>
                        	No. placa del veh&iacute;culo: <strong><?php echo $motorista_vehiculo['placa'] ?></strong>
                        </td>
                    </tr>
                 	<tr>
                    	<td>
                        	Clase del veh&iacute;culo: <strong><?php echo ucwords($motorista_vehiculo['nombre_clase']) ?></strong>
                        </td>
                    </tr>
        			<tr><td>&nbsp;</td></tr>
        			<tr><td>&nbsp;</td></tr>
        			<tr><td>&nbsp;</td></tr>
        			<tr><td>&nbsp;</td></tr>
        			<tr><td>&nbsp;</td></tr>
        			<tr><td>&nbsp;</td></tr>
                    <tr>
                        <td align="center">
                           	<!--f. _____________________________________________<br />-->
                            Asignado por <strong><?php echo ucwords($motorista_vehiculo['nombre2']) ?> </strong><br /><?php echo ucwords($info_empleado3['nominal']) ?>
                        </td>
                  	</tr>
                 </table>
            </td>
        	<td align="center" style="width:55%">
            	<strong>USO EXCLUSIVO PORTERO</strong>
                 <table align="center" class="tabla" cellspacing="0" style="width:1000px">
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                        <td rowspan="10" align="right">
                        	<img src="img/marcador_combustible<?php echo $salida_entrada_real['combustible'] ?>.jpg" style="width:20%;height:auto;" />
                            <span style="font-size: 10px;">Remanente de combustible  que queda al final de la misión  en el vehículo.</span>
                        </td>
                   	</tr>
                 	<tr>
                    	<td style="width:15%;">
                        	Kilometraje inicial:
                        </td>
                    	<td style="width:13%;" <?php if($salida_entrada_real['km_inicial']=="") echo 'class="titu"';?>>
                        	<strong><?php echo $salida_entrada_real['km_inicial'] ?></strong>
                        </td>
                    </tr>
                 	<tr>
                    	<td>
                        	kilometraje final:
                        </td>
                    	<td <?php if($salida_entrada_real['km_final']=="") echo 'class="titu"';?>>
                        	<strong><?php echo $salida_entrada_real['km_final'] ?></strong>
                        </td>
                    </tr>
                 	<tr>
                    	<td>
                        	Kms. recorridos:
                        </td>
                    	<td <?php if($salida_entrada_real['km_final']=="") echo 'class="titu"';?>>
                        	<strong><?php echo $salida_entrada_real['total'] ?></strong>
                        </td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                   	</tr>
                    <tr>
                    	<td>No. placa veh&iacute;culo:</td>
                    	<td><strong><?php echo $motorista_vehiculo['placa'] ?></strong></td>
                   	</tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                   	</tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                   	</tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                   	</tr>
                    <tr>
                    	<td>&nbsp;</td>
                    	<td></td>
                   	</tr>
                    <tr>
                    	<td colspan="3">&nbsp;</td>
                   	</tr>
                    <tr>
                        <td align="center" colspan="3">
                            f. _____________________________________________<br />
                            Portero
                        </td>
                  	</tr>
                 </table>
            </td>
        </tr>
    </table>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
    	<tr>
        	<td style="vertical-align:top; font-size: 13px;">
				<br>
				<?php
                    foreach($observaciones as $val) {
                        switch($val['quien_realiza']) {
                            case 1:
                                $quien="Observaciones por parte del solicitante";
                                break;
                            case 2:
                                $quien="Observaciones por parte del Jefe de Departamento o Secci&oacute;n";
                                break;
                            case 3:
                                $quien="Observaciones por parte del Jefe de Servicios Generales";
                                break;
                            default:
                                $quien="General";
                        }
                        echo $quien.":<br><ul><li><strong>".$val['observacion'].".</strong></li></ul>";					
                    }
                ?>
            </td>
        	<td align="center" style="width:40%; height:300px; vertical-align:bottom;">
            	<img src="img/firma_gerencia.png" /><br />
                f. _______________________________________<br />
                Administración
            </td>
        </tr>
    </table>
</body>
</html>

























