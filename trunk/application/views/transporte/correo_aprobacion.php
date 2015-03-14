<?php  

$id_usuario=1;
$id_solicitud_transporte=6;
$usuarioe= md5($id_usuario);
$solicitude= md5($id_solicitud_transporte);
$url=base_url()."index.php/peticiones/aprobar_solicitud/".$usuarioe."/".$solicitude;
$aprobar=md5(1);
$denegar=md5(0);

?>

<html>
	<head>
		<style>
		</style>
	</head>	
			
	
	<body>
			Estimad@ <?php echo $nombre; ?>,<br><br>

			<p>
			La solicitud N&deg;<strong> <?php echo $id_solicitud_transporte; ?> </strong> realizada por <strong><?php echo ucwords($solicitud['nombre']); ?> 
			</strong>  
			 requiere de su autorizaci&oacute;n.
			</p>
			<p>
				Presione click en el bot&oacute;n "Aprobar" para autorizar la solicitud <br>
				Presione click en el bot&oacute;n "Denegar" para rechazar la solicitud <br>
			</p>

			<a href="<?php echo $url.'/'.$aprobar; ?> " target="blank"><button>Aprobar</button></a>
			<a href="<?php echo $url.'/'.$denegar; ?> " target="blank"><button>Denegar</button></a>

			<br><br>Departamento de Transporte.

	</body>


</html>



