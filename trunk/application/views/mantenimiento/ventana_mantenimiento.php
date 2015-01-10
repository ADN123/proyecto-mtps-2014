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
        if($trabajo_solicitado_carroceria!=NULL && $trabajo_solicitado_carroceria!='')
		echo "Trabajo Solicitado en Carrocería: <strong>".$trabajo_solicitado_carroceria."</strong> <br>";
		echo "Accesorios Registrados al Ingresar: <br><strong>";
		$i=1;
		$j=1;
		foreach($revision as $r)
		{
			if($r['tipo']=='interno')
			{
				if($i==1) echo "<br>INTERNO <br>";
				echo $i." - ".$r['revision'];
				if($r['varios']!=0) echo " --- Cantidad: ".$r['varios'];
				echo "<br>";
				$i++;
			}
			elseif($r['tipo']=='externo')
			{
				if($j==1) echo "<br>EXTERNO <br>";
				echo $j." - ".$r['revision'];
				if($r['varios']!=0) echo " --- Cantidad: ".$r['varios'];
				echo "<br>";
				$j++;
			}
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
		$x=0;
		$fecha='';
		foreach($mantenimientos as $m)
		{
			if($x==0)
			{
				echo "<fieldset><legend>".$m['fecha']."</legend>";
				$fecha=$m['fecha'];
				$x++;
			}
			if($fecha!=$m['fecha'])
			{
				echo "</fieldset><fieldset><legend>".$m['fecha']."</legend>";
				$fecha=$m['fecha'];
			}
			if($m['tipo']=='mantenimiento')
			{
				echo "Mantenimientos: <br><strong>".$m['reparacion']."</strong><br>";
				if($m['otro_mtto']!=NULL && $m['otro_mtto']!='') echo "Mantenimientos Adicionales: <strong>".$m['otro_mtto']."</strong><br>";
			}
			elseif($m['tipo']=='inspeccion')
			{
				echo "<br>Inspecciones o Chequeos: <br><strong>".$m['reparacion']."</strong><br>";
				if($m['observaciones']!=NULL && $m['observaciones']!='')echo "Observaciones: <strong>".$m['observaciones']."</strong><br>";
			}
		}
	?>
    </fieldset>
</fieldset>
<?php
	}
?>
<p style='text-align: center;'>
	<button type="button" id="aceptar" onclick="cerrar_vent()" name="Aceptar">Aceptar</button>
</p>
</form>