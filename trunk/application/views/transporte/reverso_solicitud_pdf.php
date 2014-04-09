<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table align="center" border="0" cellspacing="0" style="width:100%;">
    	<tr>
        	<td colspan="4" align="center">
            	<strong id="titulo">MINISTERIO DE TRABAJO Y PREVISION SOCIAL</strong>
            </td>
        </tr>
    	<tr>
        	<td colspan="4" align="center">
            	<strong style="font-size: 10px;">DETALLE DE MISIONES  A EFECTUAR EN ESTA FECHA : <?php echo $info_solicitud['fecha_mision'] ?> </strong>
            </td>
        </tr>
   	</table>
	<table align="center" border="1" cellspacing="0" style="width:100%;">
        <tr>
        	<td style="font-size: 12px;" align="center"><strong>DIRECCION</strong></td>
        	<td style="font-size: 12px;" align="center"><strong>DEPARTAMENTO</strong></td>
        	<td style="font-size: 12px;" align="center"><strong>EMPRESA</strong></td>
        	<td style="font-size: 12px;" align="center"><strong>MISION ENCOMENDADA</strong></td>            
        </tr>
        <?php 
			if(count($destinos)>1) {
				foreach($destinos as $val) {
		?>
                    <tr>
                        <td style="font-size: 12px;"><?php echo $val->direccion ?></td>
                        <td style="font-size: 12px;"><?php echo ucwords($val->municipio) ?></td>
                        <td style="font-size: 12px;"><?php echo $val->destino ?></td>
                        <td style="font-size: 12px;"><?php echo $val->mision ?></td>            
                    </tr>	
        <?php
				}
			}
		?>
    </table>
</body>
</html>