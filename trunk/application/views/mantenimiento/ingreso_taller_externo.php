<?php
extract($vehiculos);
?>
<section>
    <h2>Reparación y Mantenimiento en Taller MTPS</h2>
</section>
<form name="form_taller" method="post" action="<?php echo base_url()?>index.php/vehiculo/guardar_taller" >
	<div id="wizard" class="swMain">
        <ul>
            <li>
                <a href="#step-1">
                    <span class="stepNumber">1<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Información del vehículo</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <span class="stepNumber">2<small>do</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Mantenimiento Realizado</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <span class="stepNumber">3<small>er</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Inspección Realizada</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <span class="stepNumber">4<small>to</small></span>
                    <span class="stepDesc">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paso<br/>
                        <small>&nbsp;Artículos Usados</small>
                    </span>
                </a>
            </li>
        </ul>
        <div id="step-1">	
            <h2 class="StepTitle">Datos Generales del Vehículo</h2>
            <table>
            <tr>
            <td width="300px">
			<p>
                <label style="width:150px">Fecha de Revisión: </label>
                <strong><?php echo date('d/m/Y')?></strong>
            </p>
            <p>
                <label style="width:150px">Número de Placa: </label>
                <strong><?php echo $placa ?></strong>
            </p>
            </td>
            <td width="700px">
             <p>
             	<input type="hidden" name="id_ingreso_taller" value="<?php echo $id_ingreso_taller ?>" />
            	<label class="label_textarea" style="width:100px">Trabajo solicitado: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado" readonly="readonly"><?php echo $trabajo_solicitado; ?></textarea>
                <label class="label_textarea" style="width:100px">Trabajo solicitado en carrocería: </label>
                <textarea style="width:200px; resize:none;" name="trabajo_solicitado_carroceria" readonly="readonly"><?php echo $trabajo_solicitado_carroceria; ?></textarea>
            </p>
            </td>
            </tr></table>
            <p>
            <table align='center' class='table_design' cellspacing='0' cellpadding='0'>
            <thead>
            	<tr>
                	<th colspan="2">Datos Generales del Vehículo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                	<td>Marca: <strong><?php echo $marca ?></strong></td>
                    <td>Motorista Asignado: <strong><?php echo $motorista ?></strong></td>
                </tr>
                <tr>
                    <td>Modelo: <strong><?php echo $modelo ?></strong></td>
                    <td>Oficina Asiganada: <strong><?php echo $seccion ?></strong></td>
                </tr>
                <tr>
                    <td>Clase: <strong><?php echo $clase ?></strong></td>
                    <td>Kilometraje Actual: <strong><?php echo $kilometraje ?>km</strong></td>
                </tr>
                <tr>
                    <td>Año: <strong><?php echo $anio ?></strong></td>
                    <td>Tipo de Combustible: <strong><?php echo $tipo_combustible?></strong></td>
                </tr>
            </tbody>
            </table>
            </p>
        </div>
        <div id="step-2">	
            <h2 class="StepTitle">Informaci&oacute;n del mantenimiento realizado al vehículo</h2>
            <table width="500px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Mantenimiento</th>
                        <th width="250">Realizado</th>
                    </tr>
                </thead>
            	<tbody>
                <?php
					foreach($reparacion as $re)
					{
						if($re['tipo']=="mantenimiento")
						{
							echo "<tr>";
							echo "<td>".$re['reparacion']."</td>";
							echo "<td><input type='checkbox' name='reparacion1[]' value='".$re['id_reparacion']."' /></td>";
							echo "</tr>";
						}
					}
                ?>
               
                <tr>
                	<td colspan="2">Seleccionar/Deseleccionar Todo: <input type="checkbox" name="selectall1" onclick="select_all(this.checked)" /></td>
                </tr>
                <tr>
                	<td>Otro mantenimiento: </td>
                    <td><textarea style="width:200px; resize:none;"  name="otro_mtto"></textarea></td>
                </tr>
               </tbody>
            </table></td></tr></table>
        </div>
        <div id="step-3">	
            <h2 class="StepTitle">Informaci&oacute;n de inspección o chequeo realizado al vehículo</h2>
             <table width="600px" align="center">
            <tr><td>
            <table align="center" class="table_design" cellspacing="0">
            	<thead>
                	<tr>
                    	<th>Inspección/Chequeo</th>
                        <th width="250px">Realizado</th>
                    </tr>
                </thead>
            	<tbody>
               <?php
					foreach($reparacion as $re)
					{
						if($re['tipo']=="inspeccion")
						{
							echo "<tr>";
							echo "<td>".$re['reparacion']."</td>";
							echo "<td><input type='checkbox' name='reparacion2[]'  value='".$re['id_reparacion']."'></td>";
							echo "</tr>";
						}
					}
                ?>
                <tr>
                	<td colspan="2">Seleccionar/Deseleccionar Todo: <input type="checkbox" name="selectall2" onclick="select_all2(this.checked)" /></td>
                </tr>
                <tr>
                	<td>Obervaciones: </td>
                    <td><textarea style="width:200px; resize:none;"  name="observaciones"></textarea></td>
                </tr>
              </tbody>
            </table>
          </td>
         </tr>
        </table>
        </div>
         <div id="step-4">	
            <h2 class="StepTitle">Artículos que se usaron durante el mantenimiento</h2>
             <p>
                <table align="center" class="table_design" cellpadding="0" cellspacing="0">
                <thead>
                	<tr>
                    	<th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad Disponible</th>
                        <th>Utilizado</th>
                        <th>Cantidad Utilizada</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
						foreach($inventario as $inv)
						{
							if($inv['cantidad']>0)
							{
								echo "<tr>";
								echo "<td>".$inv['nombre']."</td>";
								echo "<td>".$inv['descripcion']."</td>";
								echo "<td align='right'>".$inv['cantidad']." ".$inv['unidad_medida']."</td>";
								echo "<td><input type='checkbox' value='".$inv['id_articulo']."' name='id_articulo[]' onclick='habilitar(".$inv['id_articulo'].",this.checked)'></td>";
								echo "<td><input type='text' name='cant_usada[]' id='".$inv['id_articulo']."' disabled='disabled' size='1px'></td>";
								echo "</tr>";
							}
						}
					?>
                </tbody>
                </table>
            </p>
         </div>
    </div>
</form>