<?php 
foreach($datos as $fila)
{
	$id_requisicion=$fila->id_requisicion;
	$fecha=$fila->fecha;
	$seccion=$fila->seccion;
	$cantidad_solicitada=$fila->cantidad_solicitada;
	$nombre=$fila->nombre;
	$justificacion=$fila->justificacion;
	$cantidad_entregado=$fila->cantidad_entregado;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<table align="center">
	<tr>
    	<th colspan="2"><strong><u>MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL</u></strong></th>
    </tr>
    <tr>
    	<td><div style="border:thin; border:#000; width:340px">CONTROL DE ENTREGA DE COMBUSTIBLE</div></td>
        <td align="right">Requisición No. <b><?php echo $id_requisicion; ?></b></td>
    </tr>
    <tr>
    	<td>Unidad Presupuestaria: <b><?php echo "UACI"; ?></b></td>
        <td>Sección: <b><?php echo $seccion; ?></b></td>
    </tr>
    <tr>
    	<td>Línea de Trabajo: <b><?php echo "No sé que escribir aquí"; ?></b></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>Fecha: <b><?php echo $fecha; ?></b></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>Cantidad de Cupones Solicitados: <b>Un millón trescientos cuarentitres mil doscientos veintinueve</b></td>
        <td align="right">Cantidad Entregada: <b><?php echo $cantidad_entregado; ?></b></td>
    </tr>
    <tr>
    	<td align="center" valign="top"><sup>(Letras y Números)</sup></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2" rowspan="3">Justificación: <b><?php echo $justificacion ?></b></td>
    </tr>
    <tr></tr><tr></tr><tr></tr>
    <tr>
    	<td colspan="2">No. de Serie del Cupón o Vale: <b><?php echo "123456789ABCDEF" ?></b></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td align="right">Al Servicio de: <b><?php echo "Oficina Departamental de San Vicente"; ?></b></td>
    </tr>
    <tr>
    	<td colspan="2">Vehículo Placas: <b><?php echo "Aquí irán muchas placas"; ?></b></td>
    </tr>
    <tr>
    	<td colspan="2">Clase de Vehículo: <b><?php echo "Aquí irán muchas clases"; ?></b></td>
    </tr>
</table>

<table align="center">
	<tr align="center">
    	<td><b><?php echo "Firma Solicitante"; ?></b></td>
        <td><b><?php echo "Firma Recibido"; ?></b></td>
        <td><b><?php echo "Firma Entregado"; ?></b></td>
    </tr>
    <tr align="center" valign="top">
    	<td>Solicitante:</td>
        <td>Recibido:</td>
        <td>Entregado:</td>
    </tr>
    <tr align="center">
    	<td><u><?php echo "Firma Visto Bueno"; ?></u></td>
        <td>&nbsp;</td>
        <td><u><?php echo "Firma Autorizado"; ?></u></td>
    </tr>
    <tr align="center" valign="top">
    	<td>Visto Bueno:</td>
        <td>&nbsp;</td>
        <td>Autorizado:</td>
    </tr>
</table>
</body>
</html>