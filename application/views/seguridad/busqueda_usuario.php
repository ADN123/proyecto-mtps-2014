		<style type="text/css" title="currentStyle">
			@import "<?php echo base_url()?>/datatable/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>/datatable/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>/datatable/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#tabla').dataTable();
			} );
			

function modificar(ele){
	 location.href="modificar_usuario/"+ele;
}

function cambiar(ele){
	 location.href="cambiar_estado_usuario/"+ele+"/"+1;
}
</script>
<div id="resultados" style=" width:650px;  float:right"> 
<table id="tabla" width="650px" align="center">
 <thead>
 <tr>
 <th width="125px" >Login</th>
 <th width="250px" >Nombre</th>
 <th width="100px">Nivel</th>
 <th width="175px" >Opciones</th>
  </tr>
   </thead>
   <tbody>	
 <?php
   $s= "";  
   foreach ($datos->result() as $fila)
{
$s.= '<tr>';
 $s.='<td>'.$fila->loginC.'</td>';
 $s.='<td>'.$fila->nombreC.' '.$fila->apellidoC.'</td>';
 if($fila->nivelN==1)$s.='<td> Doctor/a </td>';
 else if($fila->nivelN==2)$s.='<td> Secretario/a </td>';
 $s.="<td><button name='boton' id='boton' type='button' onclick='modificar(".$fila->id_usuario.");'><img src='/siscliden/imagenes/modificar.png' width='20' height='20' align='top'>Modificar</button><button name='boton2' id='boton2' type='button' onclick='cambiar(".$fila->id_usuario.");'><img src='/siscliden/imagenes/baja.jpg' width='20' height='20' align='top'>Dar de Baja</button></td>"; 
 $s.=' </tr>'; 
 }
 echo $s;
   
 ?>
 </tbody>
 </table>
 </div>