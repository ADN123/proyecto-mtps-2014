<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/199s9/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen">
                <img src="img/mtps_report.jpg" />
            </td>
            <td align="right">
                <h3>REPORTE DE VALES DE COMBUSTIBLE</h3>
                <h6>Fecha: <strong><?php echo date('d-m-Y') ?></strong> </h6>
            </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
              <strong id="titulo">Liquidacion del mes de <?php echo $mesn ?></strong><br>
              <strong id="titulo2"> <?php echo $seccion ?></strong>
            </td>
        </tr>
    </table>
    <br>
<!---------------------------------------------------------------------------------- -->
<table align="center" class='table_design'>

  <thead>
  <tr>
    <th>VALES RECIBIDOS</th>
    <th>DEL</th>
    <th>AL</th>
  </tr>
  </thead>
  <tbody>
  <?php// foreach ($recibidos as $key) {  ?>
  <?php for ($i=0; $i <2 ; $i++)  {  
      $cant=7;
    ?>
  <tr>
    <td aling="center"><?php echo $cant; $tsolicit+=$cant; ?></td>
    <td>12312</td>
    <td>1231</td>
  </tr>
  <?php }?>
  </tbody>
  <thead>
  <tr>
    <th>SOBRANTES MES ANTERIOR</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php  $tsobrant=0;// foreach ($recibidos as $key) {  ?>
  <?php for ($i=0; $i <1 ; $i++)  {  
        $cant=4;
    ?>
  <tr>
    <td aling="center"><?php echo $cant; $tsobrant+=$cant; ?></td>
    <td>12312</td>
    <td>1231</td>
  </tr>
  <?php }?>
  </tbody>
  </table>
  
<!---------------------------------------------------------------------------------- -->
  <br>
  <table align="left" class='table_design' style="width:400px">
  <thead>
  <tr>
    <th colspan="3">VALES UTILIZADOS POR VEHICULO</th>
  </tr>
  <tr>
    <th>VEHICULO</th>
    <th>PLACA</th>
    <th>CANTIDAD</th>
  </tr>
  </thead>
  <tbody>
  <?php// foreach ($recibidos as $key) {  ?>
  <?php for ($i=0; $i <2 ; $i++)  {  ?>
  <tr>
    <td aling="center">CARRO</td>
    <td>P-1231</td>
    <td>31</td>
  </tr>
  <?php }?>
  <tr>
    <td aling="center"><strong>TOTAL</strong></td>
    <td></td>
    <td><strong>43</strong></td>
  </tr>
  </tbody>
</table>
<br>
<!---------------------------------------------------------------------------------- -->
<table align="center" class='table_design'>

  <thead>
  <tr>
    <th>VALES UTILIZADOS</th>
    <th>DEL</th>
    <th>AL</th>
  </tr>
  </thead>
  <tbody>
  <?php// foreach ($recibidos as $key) {  ?>
  <?php for ($i=0; $i <2 ; $i++)  {  ?>
  <tr>
    <td aling="center">2</td>
    <td>12312</td>
    <td>1231</td>
  </tr>
  <?php }?>
  </tbody>
  <thead>
  <tr>
    <th> VALES SOBRANTES</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php// foreach ($recibidos as $key) {  ?>
  <?php for ($i=0; $i <1 ; $i++)  {  ?>
  <tr>
    <td aling="center">2</td>
    <td>12312</td>
    <td>1231</td>
  </tr>
  <?php }?>
   <tr>
    <td><strong>T0TAL</strong></td>
    <td></td>
    <td><strong>434</strong></td>
  </tr>
 
  </tbody>
  </table>
  
<!---------------------------------------------------------------------------------- -->
  <br>
  <table class="table_design" style="width:300px;">
  <tr>
    <td>SOBRANTES DEL MES ANTERIOR</td>
    <td><?php echo $tsobrant; ?></td>
  </tr>
  <tr>
    <td>SOLICITADOS EN <?php echo strtoupper($mesn);?></td>
    <td><?php echo $tsolicit; ?></td>
  </tr>
  <tr>
    <th >TOTAL DE CUPONES</th>
    <th ><strong><?php echo $tsolicit+$tsobrant; ?></strong></th>
  </tr>
</table>
