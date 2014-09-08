<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "<table border=1> ";
echo "<tr> ";
echo "<th>Nombre</th> ";
echo "<th>Email</th> ";
echo "</tr> ";
echo "<tr> ";
echo "<td><font color=green>Manuel Gomez</font></td> ";
echo "<td>manuel@gomez.com</td> ";
echo "</tr> ";
echo "<tr> ";
echo "<td><font color=blue>Pago gomez</font></td> ";
echo "<td>paco@gomez.com</td> ";
echo "</tr> ";
echo "</table> ";
?>
