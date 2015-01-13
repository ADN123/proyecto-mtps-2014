<?php
extract($vehiculo);
?>
<form name="form_taller_ext_info" method="post">

<fieldset>
	<legend>Información del Vehículo</legend>
	<?php 
        echo "<img src='".base_url()."fotografias_vehiculos/".$imagen."' align='center' width='200px'></img><br/>";
        echo "Placa: <strong>".$placa."</strong> <br>
        Marca: <strong>".$marca."</strong> <br>
        Modelo: <strong>".$modelo."</strong> <br>";
		echo "Sección: <strong>".$seccion."</strong> <br>
		Motorista: <strong>".ucwords($motorista)."</strong> <br>
		Fuente de Fondo: <strong>".$fuente_fondo."</strong> <br>
		Kilometraje Recorrido: <strong>".$kilometraje." km</strong> <br>";
	?>
</fieldset>
<br />
<fieldset>
	<legend>Información de Ingreso a Taller</legend>
    <?php 
        echo "Fecha de Recepción: <strong>".$fecha_recepcion."</strong> <br>
        Trabajo Solicitado: <strong>".$trabajo_solicitado."</strong> <br>";
	?>
</fieldset>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>