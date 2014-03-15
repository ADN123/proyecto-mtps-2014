		<style type="text/css" title="currentStyle">
			@import "<?= base_url()?>/datatable/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="<?= base_url()?>/datatable/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?= base_url()?>/datatable/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#tabla').dataTable();
			} );
			

function restaurar(ele){
	 location.href="restaurar_copia_seguridad/"+ele;
}
</script>
<div id="resultados" style=" width:650px; margin:auto; float:right"> 
<table id="tabla" align="center" width="650px">
 <thead>
 <tr>
 <th width="100px">Fecha</th>
 <th width="100px">Nombre</th>
 <th width="100px">Opciones</th>
  </tr>
   </thead>
   <tbody>
	<?php 
	mysql_connect("localhost","root","root");
	mysql_select_db("sisclidenbd_respaldo");
	$query=mysql_query("SELECT * FROM backuptb order by fechaF");
	while($row=mysql_fetch_array($query))
	{
		echo "<tr><td>";
		echo $row['fechaF'];
		echo "</td><td>";
		echo $row['nombreC'];
		echo "</td><td><button name='boton' id='boton' type='button' onclick='restaurar(".$row['id_backup'].");'><img src='/siscliden/imagenes/restaurar.png' width='20' height='20' align='top'>Restaurar</button></td></tr>";
		
	}
	mysql_close();
	?>
	
     </tbody>
 </table>
 <form action="<?=base_url();?>subida.php" method="post" enctype="multipart/form-data">
 <input type="file" name="foto" />
 <button type="submit"><img src='/siscliden/imagenes/restaurar.png' width='20' height='20' align='top'>Restaurar</button>
 </form>
 </div>