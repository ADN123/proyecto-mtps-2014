<?php
extract($vehiculo);
?>
<form name="form_mtto_info" method="post">

<fieldset>
	<legend>Información del Vehículo</legend>
	<?php 
        echo "<img src='".base_url()."fotografias_vehiculos/".$imagen."' align='center' width='200px'></img><br/>";
        echo "Placa: <strong>".$placa."</strong> <br>
        Marca: <strong>".$marca."</strong> <br>
        Modelo: <strong>".$modelo."</strong> <br>";
		echo "Sección: <strong>".$seccion."</strong> <br>
		Motorista: <strong>".$motorista."</strong> <br>
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
        if($trabajo_solicitado_carroceria!=NULL && $trabajo_solicitado_carroceria!='')
		echo "Trabajo Solicitado en Carrocería: <strong>".$trabajo_solicitado_carroceria."</strong> <br>";
		echo "Accesorios Registrados al Ingresar: <br><strong>";
		$i=1;
		foreach($revision as $r)
		{
			echo $i." - ".$r['revision'];
			if($r['varios']!=0) echo " --- Cantidad: ".$r['varios'];
			echo "<br>";
			$i++;
		}
		echo "</strong>";
	?>
</fieldset>
<?php
	if(!empty($mantenimientos))
	{
?>
<fieldset>
	<legend>Mantenimientos Realizados</legend>
    <?php
		foreach($mantenimientos as $m)
		{
			echo "Fecha: <strong>".$m['fecha']."</strong> <br>";
			echo "Observaciones: <strong>".$m['observaciones']."</strong><br>";
		}
	?>
</fieldset>
<?php
	}
?>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>