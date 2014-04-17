<div id='signup-header'>
    <h2>Aprobacion de solicitud de Misión Oficial</h2>
    <a class='cerrar-modal'></a>
</div>
<div id="contenido-ventana" style="height: 440px; overflow: auto;">
    <form id='form' action="<?php echo base_url()?>index.php/transporte/aprobar_solicitud" method='post'>
    	<input type='hidden' id='resp' name='resp' />
    	<input type='hidden' name='ids' value="<?php echo $id?>" />
    
    	<fieldset>      
        	<legend align='left'>Información de la Solicitud</legend>
				<?php 
                    foreach($d as $datos)
                    {
                        $nombre=ucwords($datos->nombre);
                        $seccion=$datos->seccion;
                        $fechaS=$datos->fechaS;
                        $fechaM=$datos->fechaM;
                        $salida=$datos->salida;
                        $entrada=$datos->entrada;
                        $requiere=$datos->req;
                        $acompanante=ucwords($datos->acompanante);
                        $id_empleado=$datos->id_empleado_solicitante;
                    }
                
					echo "Nombre: <strong>".$nombre."</strong> <br>
					Sección: <strong>".$seccion."</strong> <br>
					Fecha de Solicitud: <strong>".$fechaS."</strong> <br>
					Fecha de Misión: <strong>".$fechaM."</strong> <br>
					Hora de Salida: <strong>".$salida."</strong> <br>
					Hora de Regreso: <strong>".$entrada."</strong> <br>
                
        </fieldset>
    	<br />
    
    	<fieldset>
    		<legend align='left'>Destinos</legend>
			<table cellspacing='0' align='center' class='table_design'>
				<thead>
					<th>
						Municipio
					</th>
					<th>
						Lugar de destino
					</th>
					<th>
						Dirección
					</th>
					<th>
						Misión Encomendada
					</th>
				</thead>
				<tbody>
					";
					foreach($f as $r)
					{
						echo "<tr><td>".$r->municipio."</td>";
						echo "<td>".$r->destino."</td>";
						echo "<td>".$r->direccion."</td>";
						echo "<td>".$r->mision."</td></tr>";
					}
				echo "
				</tbody>
			</table>
		</fieldset>
		<br>
		<fieldset>
			<legend align='left'>Acompañantes</legend>
			
			";
			foreach($a as $acompa)
			{
				echo "<strong>".ucwords($acompa->nombre)."</strong> <br />";
			}
			echo "<strong>".$acompanante."</strong><br />";
		?>	
        </fieldset>
       	<br>
		<fieldset>
			<legend align='left'>Adicional</legend>
            <label for="observacion" id="lobservacion" class="label_textarea">Observaciones</label>
            <textarea class='tam-4' id='observacion' tabindex='2' name='observacion'/></textarea>
        </fieldset>
        <p style='text-align: center;'>
            <button type="submit"  id="aprobar" class="button tam-1 boton_validador" name="aprobar" onclick="Enviar(2)">Aprobar</button>
            <button  type="submit" id="denegar" class="button tam-1 boton_validador" name="Denegar" onclick="Enviar(0)">Denegar</button>
        </p>
    </form>
</div>
<script>
	$("#observacion").validacion({
		req: false,
		lonMin: 10
	});
	
	$(".cerrar-modal").click(function(){
		$(".modal_close").click();
	});
</script>